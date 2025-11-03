<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class AdminProductCategoriesController extends Controller
{
    // Show list of product categories
    public function index()
    {
        $categories = ProductCategory::latest()->get();
        return view('admin.products.product_categories.index', compact('categories'));
    }

    // Show create form
    public function create()
    {
        return view('admin.products.product_categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:2055',
            'name_ar' => 'required|string|max:2055',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|max:20048',
            'status' => 'required|in:active,inactive,pending',
        ]);

        $data = $request->only([
            'name_en', 'name_ar', 'description_en', 'description_ar', 'status'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Custom name for the image

            // Move the image to 'public/uploads/categories' folder
            $image->move(('uploads/categories'), $imageName);

            // Save the relative path
            $data['image'] = 'uploads/categories/' . $imageName;
        }

        // Generate unique slug
        $data['slug'] = Str::slug($request->name_en);
        $slugExists = ProductCategory::where('slug', $data['slug'])->exists();
        if ($slugExists) {
            $data['slug'] .= '-' . uniqid();
        }

        // Create the new category
        ProductCategory::create($data);

        return redirect()->route('admin.product_categories.index')
                         ->with('status-success', 'Product category created successfully.');
    }

    // Show edit form
    public function edit(ProductCategory $product_category)
    {
        return view('admin.products.product_categories.edit', ['category' => $product_category]);
    }

    // Update category
    public function update(Request $request, ProductCategory $product_category)
    {
        $request->validate([
            'name_en' => 'required|string|max:2055',
            'name_ar' => 'required|string|max:2055',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image|max:20048',
            'status' => 'required|in:active,inactive,pending',
        ]);

        $data = $request->only([
            'name_en', 'name_ar', 'description_en', 'description_ar', 'status'
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product_category->image && file_exists(('uploads/categories/' . $product_category->image))) {
                unlink(('uploads/categories/' . $product_category->image)); // Remove old image
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Custom name for the image

            // Move the image to 'public/uploads/categories' folder
            $image->move(('uploads/categories'), $imageName);

            // Save the relative path
            $data['image'] = 'uploads/categories/' . $imageName;
        }

        // Update slug if name_en changed
        if ($product_category->name_en !== $request->name_en) {
            $slug = Str::slug($request->name_en);
            if (ProductCategory::where('slug', $slug)->where('id', '!=', $product_category->id)->exists()) {
                $slug .= '-' . uniqid();
            }
            $data['slug'] = $slug;
        }

        $product_category->update($data);

        return redirect()->route('admin.product_categories.index')
                         ->with('status-success', 'Product category updated successfully.');
    }

    // Delete category
    public function destroy(ProductCategory $product_category)
    {
        // Delete the image if exists
        if ($product_category->image && file_exists(('uploads/categories/' . $product_category->image))) {
            unlink(('uploads/categories/' . $product_category->image)); // Remove old image
        }

        $product_category->delete();

        return redirect()->route('admin.product_categories.index')
                         ->with('status-success', 'Product category deleted successfully.');
    }
}
