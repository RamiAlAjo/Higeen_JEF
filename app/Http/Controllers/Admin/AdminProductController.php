<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'subcategory')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('product_name_en', 'like', '%' . $request->search . '%')
                  ->orWhere('product_name_ar', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(10);
        $categories = ProductCategory::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        $subcategories = ProductSubcategory::all();
        return view('admin.products.create', compact('categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name_en' => 'required|string|max:255',
            'product_name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'price' => 'required|numeric|min:0',  // Made required to match form
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,pending',
            'category_id' => 'nullable|exists:products_categories,id',
            'subcategory_id' => 'nullable|exists:products_subcategories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:51200',
            'slug' => 'nullable|string|unique:products,slug',
        ]);

        // Handle multiple image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $imagePaths[] = $this->uploadImage($image, 'products');
                } catch (\Exception $e) {
                    Log::error('Image upload failed: ' . $e->getMessage());
                    return redirect()->back()->withInput()->with('error', 'Failed to upload image: ' . $e->getMessage());
                }
            }
        }

        // Let model boot handle slug if empty
        if (empty($validated['slug'])) {
            unset($validated['slug']);  // Remove to let model generate
        }

        // Prepare data
        $data = $validated;
        $data['image'] = $imagePaths;  // Now fillable, will be JSON-encoded via cast

        try {
            Product::create($data);
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create product: ' . $e->getMessage());
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        $subcategories = ProductSubcategory::all();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

  public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name_en' => 'required|string|max:255',
            'product_name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'price' => 'required|numeric|min:0',  // Required
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,pending',
            'category_id' => 'nullable|exists:products_categories,id',
            'subcategory_id' => 'nullable|exists:products_subcategories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:51200',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
        ]);

        $existing = $product->image ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $existing[] = $this->uploadImage($image, 'products');
                } catch (\Exception $e) {
                    Log::error('Image upload failed: ' . $e->getMessage());
                    return redirect()->back()->withInput()->with('error', 'Failed to upload image: ' . $e->getMessage());
                }
            }
        }

        $data = $validated;
        $data['image'] = $existing;

        // Handle slug if needed
        if (empty($data['slug'])) {
            unset($data['slug']);
        }

        try {
            $product->update($data);
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update product: ' . $e->getMessage());
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully.');
    }

  public function destroy(Product $product)
{
    $images = $product->image ?? [];

    // Ensure it's an array (in case it's stored as JSON string)
    if (is_string($images)) {
        $images = json_decode($images, true) ?: [];
    }

    // Delete all images from disk
    foreach ($images as $imagePath) {
        $this->deleteImage($imagePath); // Now works correctly
    }

    try {
        $product->delete();
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    } catch (\Exception $e) {
        Log::error('Product deletion failed: ' . $e->getMessage());
        return redirect()
            ->back()
            ->with('error', 'Failed to delete product: ' . $e->getMessage());
    }
}

    /**
     * Delete a specific image by index.
     */
   public function destroyImage(Request $request, Product $product)
{
    $request->validate(['image_index' => 'required|integer|min:0']);

    $images = $product->image ?? [];
    if (is_string($images)) {
        $images = json_decode($images, true) ?: [];
    }

    $idx = $request->image_index;

    if (isset($images[$idx])) {
        $this->deleteImage($images[$idx]); // Now uses correct path
        unset($images[$idx]);
        $images = array_values($images); // Re-index

        $product->update(['image' => $images]);
        return back()->with('success', 'Image deleted successfully.');
    }

    return back()->with('error', 'Image not found.');
}

    /**
     * Upload an individual image to public/uploads/[folder]
     * Returns relative path without leading slash.
     */
    private function uploadImage($file, $folder)
    {
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = time() . '_' . Str::slug($basename) . '.' . $file->getClientOriginalExtension();

        $dir = ("uploads/{$folder}");
        if (!File::exists($dir)) {
            try {
                File::makeDirectory($dir, 0755, true);
            } catch (\Exception $e) {
                Log::error('Failed to create directory: ' . $dir . ' - ' . $e->getMessage());
                throw new \Exception('Failed to create directory: ' . $e->getMessage());
            }
        }

        try {
            $file->move($dir, $filename);
        } catch (\Exception $e) {
            Log::error('Failed to move file to ' . $dir . '/' . $filename . ': ' . $e->getMessage());
            throw new \Exception('Failed to save file: ' . $e->getMessage());
        }

        // Return path without leading slash to match frontend
        return "uploads/{$folder}/{$filename}";
    }

    /**
     * Delete an image from public folder if it exists.
     */
   /**
 * Delete an image from public folder if it exists.
 */
private function deleteImage($path)
{
    if (!$path) return;

    // Normalize path: remove leading slash and prepend public_path
    $fullPath = public_path(ltrim($path, '/'));

    if (File::exists($fullPath)) {
        try {
            File::delete($fullPath);
            Log::info("Deleted image: {$fullPath}");
        } catch (\Exception $e) {
            Log::error("Failed to delete image: {$fullPath} - " . $e->getMessage());
        }
    }
}

public function import(Request $request)
{
    $proIds = $request->input('pro_id', '');

    $payload = [
        'token' => 'Vmc2QUhQak9WOGFoOGtmNXp5cEo4L3g4MHBmZE5uSGdKbk9LcnU0ZDdOWUZhRytna1BaTmxRSThEUEhLTWd3aTRUVk9acXlKK0hOWGQvKzFMbzJnRVNQOFBLZ2piWTZPakpUNEd2RVFqdVE9',
        'action' => 'download',
        'type' => 'products',
        'all' => '1',
        'view_items_by' => '0',
    ];

    if (!empty($proIds)) {
        $payload['pro_id'] = $proIds;
    }

    try {
        $response = Http::timeout(60)
                        ->asForm()
                        ->post('https://test.hesabate.com/store_api.php', $payload);

        $body = $response->body();

        // Critical checks — Hesabate often returns HTML!
        if (empty($body) || str_contains($body, '<html') || str_contains($body, 'login') || str_contains($body, 'error')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid response from Hesabate. Token may be wrong or blocked.'
            ]);
        }

        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid JSON received from API'
            ]);
        }

        if (empty($data['table']) || !is_array($data['table'])) {
            return response()->json([
                'success' => false,
                'message' => 'No products found. Response: ' . substr($body, 0, 200)
            ]);
        }

      $imported = 0;
    foreach ($data['table'] as $item) {
        $nameAr = trim($item['name'] ?? '');
        if (empty($nameAr)) continue;

        $hesabateId = $item['id'] ?? $item['barcode'] ?? null;
        $totalQty = (int)($item['amount'] ?? 0);
        $price = (float)($item['price'] ?? 0);

        // استخراج المقاسات والألوان من measure
        $variants = $item['measure'] ?? [];
        $sizes = [];
        $colors = [];

        foreach ($variants as $v) {
            $size = $this->extractSize($v['measure_name'] ?? '');
            $color = $this->extractColor($v['measure_name'] ?? '');
            if ($size) $sizes[] = $size;
            if ($color) $colors[] = $color;
        }

        $sizes = array_unique(array_filter($sizes));
        $colors = array_unique(array_filter($colors));

        Product::updateOrCreate(
            ['hesabate_id' => $hesabateId],
            [
                'product_name_ar' => $nameAr,
                'product_name_en' => $item['name_e'] ?: $this->arabicToEnglish($nameAr),
                'description_ar' => $item['note'] ?? null,
                'description_en' => $item['note'] ?? null,
                'price' => $price,
                'quantity' => $totalQty,
                'status' => $totalQty > 0 ? 'active' : 'inactive',
                'category_id' => $this->resolveCategoryId($item['class_id'] ?? null),
                'hesabate_class_id' => $item['class_id'] ?? null,
                'images' => !empty($item['item_img']) ? [$item['item_img']] : null,
                'variants' => $variants,           
                'sizes' => $sizes,
                'colors' => $colors,
                'slug' => Str::slug($item['name_e'] ?: $nameAr) . "-hesabate-{$hesabateId}",
            ]
        );

        $imported++;
    }

    return response()->json([
        'success' => true,
        'imported' => $imported,
        'message' => "تم استيراد {$imported} منتج بنجاح مع المقاسات والألوان"
    ]);

    } catch (\Exception $e) {
        Log::error('Hesabate Import Failed: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error: ' . $e->getMessage()
        ]);
    }
}

private function extractSize($str)
{
    preg_match('/\b(XS|S|M|L|XL|XXL|2XL|3XL|4XL|5XL|XXXXL)\b/i', $str, $m);
    return $m[1] ?? null;
}

private function extractColor($str)
{
    $map = [
        'اسود|أسود' => 'أسود',
        'ابيض|أبيض' => 'أبيض',
        'احمر|أحمر' => 'أحمر',
        'كحلي' => 'كحلي',
        'ازرق|أزرق' => 'أزرق',
        'اخضر|أخضر' => 'أخضر',
        'اصفر|أصفر' => 'أصفر',
        'اورنج|برتقالي' => 'برتقالي',
        'بنفسجي' => 'بنفسجي',
        'خمري' => 'خمري',
        'سكني' => 'سكني',
    ];

    foreach ($map as $pattern => $color) {
        if (preg_match("/$pattern/i", $str)) {
            return $color;
        }
    }
    return null;
}

private function arabicToEnglish($arabic)
{
    $map = [
        'بولو' => 'Polo', 'تيشيرت' => 'T-Shirt', 'بنطلون' => 'Pants',
        'جاكيت' => 'Jacket', 'هودي' => 'Hoodie', 'قميص' => 'Shirt',
    ];
    foreach ($map as $ar => $en) {
        if (str_contains($arabic, $ar)) return $en . ' - ' . $arabic;
    }
    return 'Product - ' . $arabic;
}

// Helper: Simple Arabic to English name fallback
// private function arabicToEnglish($arabic)
// {
//     $map = [
//         'تيشيرت' => 'T-Shirt',
//         'بولو' => 'Polo',
//         'بنطلون' => 'Pants',
//         'جاكيت' => 'Jacket',
//         'قميص' => 'Shirt',
//         'هودي' => 'Hoodie',
//         'جينز' => 'Jeans',
//         'شورت' => 'Shorts',
//     ];

//     foreach ($map as $ar => $en) {
//         if (str_contains($arabic, $ar)) {
//             return $en . ' - ' . $arabic;
//         }
//     }

//     return 'Product - ' . $arabic;
// }

// Resolve category (you should map Hesabate class_id → your category IDs)
private function resolveCategoryId($classId)
{
    static $defaultCategoryId = null;

    if ($defaultCategoryId === null) {
        $defaultCategoryId = \App\Models\ProductCategory::value('id');
    }

    return $defaultCategoryId; // سواء كان موجود أو null → آمن تمامًا
}
}