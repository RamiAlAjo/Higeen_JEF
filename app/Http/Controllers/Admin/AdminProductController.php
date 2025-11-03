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
        if (is_string($images)) {
            $images = json_decode($images, true) ?: [];
        }
        foreach ($images as $imgPath) {
            $this->deleteImage($imgPath);
        }

        try {
            $product->delete();
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }

    /**
     * Delete a specific image by index.
     */
    public function destroyImage(Request $request, Product $product)
    {
        $request->validate([
            'image_index' => 'required|integer|min:0',
        ]);

        $images = $product->image ?? [];
        if (is_string($images)) {
            $images = json_decode($images, true) ?: [];
        }

        $idx = $request->image_index;
        if (isset($images[$idx])) {
            $this->deleteImage($images[$idx]);
            unset($images[$idx]);
            // Re-index
            $images = array_values($images);
            try {
                $product->update(['image' => $images]);
            } catch (\Exception $e) {
                Log::error('Image deletion failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to delete image: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Image deleted successfully.');
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
    private function deleteImage($path)
    {
        // Remove leading slash for consistency
        $path = ltrim($path, '/');
        if ($path && File::exists(($path))) {
            try {
                File::delete(($path));
            } catch (\Exception $e) {
                Log::error('Failed to delete image: ' . $path . ' - ' . $e->getMessage());
            }
        }
    }
}
