<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSubcategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File; // Import the File facade
use Illuminate\Support\Facades\Storage; // Use the Storage facade

class AdminProductSubcategoriesController extends Controller
{
    public function index()
    {
        $subcategories = ProductSubcategory::with('category')->latest()->get();
        return view('admin.products.product_subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.products.product_subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:2055',
            'name_ar' => 'required|string|max:2055',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|max:20048',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $data = $request->only([
            'name_en',
            'name_ar',
            'description_en',
            'description_ar',
            'status',
            'category_id',
        ]);

        $data['slug'] = Str::slug($request->name_en);

        // Handle image upload manually
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Custom name for the image

            // Move the image to 'public/uploads/product_subcategories' folder
            $image->move(('uploads/product_subcategories'), $imageName);

            // Save the relative path
            $data['image'] = 'uploads/product_subcategories/' . $imageName;
        }

        ProductSubcategory::create($data);

        return redirect()->route('admin.product_subcategories.index')
            ->with('status-success', 'Product subcategory created successfully.');
    }

    public function edit(ProductSubcategory $product_subcategory)
    {
        $categories = ProductCategory::all();
        return view('admin.products.product_subcategories.edit', [
            'subcategory' => $product_subcategory,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, ProductSubcategory $product_subcategory)
    {
        $request->validate([
            'name_en' => 'required|string|max:2055',
            'name_ar' => 'required|string|max:2505',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|max:20048',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $data = $request->only([
            'name_en',
            'name_ar',
            'description_en',
            'description_ar',
            'status',
            'category_id',
        ]);

        $data['slug'] = Str::slug($request->name_en);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product_subcategory->image && file_exists(('uploads/product_subcategories/' . $product_subcategory->image))) {
                unlink(('uploads/product_subcategories/' . $product_subcategory->image)); // Remove old image
            }

            // Upload the new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Custom name for the image

            // Move the image to 'public/uploads/product_subcategories' folder
            $image->move(('uploads/product_subcategories'), $imageName);

            // Save the relative path
            $data['image'] = 'uploads/product_subcategories/' . $imageName;
        }

        $product_subcategory->update($data);

        return redirect()->route('admin.product_subcategories.index')
            ->with('status-success', 'Product subcategory updated successfully.');
    }

    public function destroy(ProductSubcategory $product_subcategory)
    {
        // Delete the image if it exists
        if ($product_subcategory->image && file_exists(('uploads/product_subcategories/' . $product_subcategory->image))) {
            unlink(('uploads/product_subcategories/' . $product_subcategory->image)); // Remove old image
        }

        $product_subcategory->delete();

        return redirect()->route('admin.product_subcategories.index')
            ->with('status-success', 'Product subcategory deleted successfully.');
    }
}
