<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\WebsiteSetting;

class FrontHomepageController extends Controller
{
    public function index()
    {
        // About Us section
        $about = AboutSection::first();


        $settings = WebsiteSetting::first();

        // Latest 8 active products
        $products = Product::where('status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->take(8)
                    ->get();

        // Top 6 active categories with product count
        $categories = ProductCategory::withCount('products')
                        ->where('status', 'active')
                        ->orderByDesc('products_count')
                        ->take(6)
                        ->get();

        // Top 6 active subcategories
        $subcategories = ProductSubcategory::where('status', 'active')
                            ->take(6)
                            ->get();

        // Send all data to the homepage view
        return view('front.homepage', compact(
            'about',
            'products',
            'categories',
            'subcategories',
            'settings'
        ));
    }
}
