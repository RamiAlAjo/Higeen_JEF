<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Gallery;

class FrontGalleryController extends Controller
{
    public function index()
    {
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

        return view('front.gallery', [
            'albums' => $albums,
            'albumsData' => $albumsData,
        ]);
    }
}
