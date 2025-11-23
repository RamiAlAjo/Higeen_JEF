<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\WebsiteSetting;
use App\Models\Album;

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
                    ->take(6)
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


                             // Fetch albums with their active images, paginated
        $albums = Album::with(['gallery' => function ($query) {
            $query->where('status', true)->orderBy('sort_order', 'asc');
        }])->latest()->paginate(9); // Show 9 albums per page

        // Prepare albums data for JavaScript
        $albumsData = $albums->mapWithKeys(function ($album) {
            return [
                'album' . $album->id => $album->gallery->map(function ($image) {
                    return [
                        'src' => $image->image ? asset($image->image) : asset('placeholder_image.png'),
                        'alt' => app()->getLocale() === 'ar' ? ($image->title_ar ?? $image->alt ?? 'Image') : ($image->title_en ?? $image->alt ?? 'Image'),
                    ];
                })->toArray()
            ];
        })->toArray();


        // Send all data to the homepage view
      return view('front.homepage', compact(
    'about',
    'products',
    'categories',
    'subcategories',
    'settings',
    'albums',
    'albumsData'
));


    }
}
