<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Gallery::with('album')
            ->orderBy('album_id')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('admin.images.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albums = Schema::hasColumn('albums', 'album_name_en')
            ? Album::pluck('album_name_en', 'id')
            : (Schema::hasColumn('albums', 'album_name_ar')
                ? Album::pluck('album_name_ar', 'id')
                : Album::pluck('id', 'id'));

        return view('admin.images.create', compact('albums'));
    }

    /**
     * Store newly uploaded images (save in /uploads/gallery/).
     */
    public function store(Request $request)
{
    $request->validate([
        'album_id'       => 'required|exists:albums,id',
        'images'         => 'required|array|min:1',
        'images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        'images_data'    => 'array',
        'images_data.*.alt' => 'nullable|string|max:255',
        'images_data.*.title_en' => 'nullable|string|max:255',
        'images_data.*.title_ar' => 'nullable|string|max:255',
        'images_data.*.description_en' => 'nullable|string',
        'images_data.*.description_ar' => 'nullable|string',
        'status'         => 'boolean',
        'sort_order'     => 'integer|min:0',
    ]);

    $baseSortOrder = $request->sort_order ?? 0;
    $destinationPath = ('uploads/gallery');

    // Create the uploads directory if it doesn't exist
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    foreach ($request->file('images') as $index => $file) {
        // ✅ Get file info BEFORE moving
        $originalName = $file->getClientOriginalName();
        $mime = $file->getClientMimeType();
        $size = $file->getSize();

        // ✅ Create a unique filename
        $filename = time() . '_' . uniqid() . '_' . $originalName;

        // ✅ Move file to /public/uploads/gallery
        $file->move($destinationPath, $filename);

        // ✅ Save to database
        Gallery::create([
            'album_id'       => $request->album_id,
            'image'          => '/uploads/gallery/' . $filename, // Full relative path
            'alt'            => $request->input("images_data.$index.alt"),
            'title_en'       => $request->input("images_data.$index.title_en"),
            'title_ar'       => $request->input("images_data.$index.title_ar"),
            'description_en' => $request->input("images_data.$index.description_en"),
            'description_ar' => $request->input("images_data.$index.description_ar"),
            'filesize'       => $size,
            'mime_type'      => $mime,
            'status'         => $request->boolean('status'),
            'sort_order'     => $baseSortOrder + $index,
        ]);
    }

    return redirect()
        ->route('admin.images.index')
        ->with('success', 'Images uploaded successfully.');
}

    /**
     * Edit a specific image.
     */
    public function edit(Gallery $image)
    {
        $albums = Schema::hasColumn('albums', 'album_name_en')
            ? Album::pluck('album_name_en', 'id')
            : (Schema::hasColumn('albums', 'album_name_ar')
                ? Album::pluck('album_name_ar', 'id')
                : Album::pluck('id', 'id'));

        return view('admin.images.edit', compact('image', 'albums'));
    }

    /**
     * Update an existing image (replace file in /uploads/gallery/ if new one is uploaded).
     */
    public function update(Request $request, Gallery $image)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'status' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $destinationPath = ('uploads/gallery');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Delete old image if exists
            if ($image->image && file_exists(($image->image))) {
                unlink(($image->image));
            }

            $file->move($destinationPath, $filename);
            $image->image = '/uploads/gallery/' . $filename;
            $image->mime_type = $file->getClientMimeType();
            $image->filesize = $file->getSize();
        }

        $image->fill([
            'album_id' => $request->album_id,
            'alt' => $request->alt,
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'status' => $request->boolean('status'),
            'sort_order' => $request->sort_order ?? 0,
        ])->save();

        return redirect()
            ->route('admin.images.index')
            ->with('success', 'Image updated successfully.');
    }

    /**
     * Remove an image and delete from uploads folder.
     */
    public function destroy(Gallery $image)
    {
        if ($image->image && file_exists(($image->image))) {
            unlink(($image->image));
        }

        $image->delete();

        return redirect()
            ->route('admin.images.index')
            ->with('success', 'Image deleted successfully.');
    }
}
