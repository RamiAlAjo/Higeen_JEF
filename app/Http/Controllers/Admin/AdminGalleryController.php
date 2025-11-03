<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;
use Illuminate\Support\Facades\File;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of albums.
     */
    public function index()
    {
        $albums = Album::latest()->paginate(10);
        return view('admin.gallery.index', compact('albums'));
    }

    /**
     * Show the form for creating a new album.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created album in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'album_name_en' => 'required|string|max:255',
            'album_name_ar' => 'required|string|max:255',
            'album_description_en' => 'nullable|string',
            'album_description_ar' => 'nullable|string',
        ]);

        $coverImagePath = $this->uploadCoverImage($request);

        Album::create([
            'cover_image' => $coverImagePath,
            'album_name_en' => $request->album_name_en,
            'album_name_ar' => $request->album_name_ar,
            'album_description_en' => $request->album_description_en,
            'album_description_ar' => $request->album_description_ar,
        ]);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Album created successfully.');
    }

    /**
     * Show the form for editing the specified album.
     */
    public function edit(Album $gallery)  // ← Changed: $album → $gallery
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified album in storage.
     */
    public function update(Request $request, Album $gallery)  // ← Changed: $album → $gallery
    {
        $request->validate([
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'album_name_en' => 'required|string|max:255',
            'album_name_ar' => 'required|string|max:255',
            'album_description_en' => 'nullable|string',
            'album_description_ar' => 'nullable|string',
        ]);

        $coverImagePath = $gallery->cover_image;

        if ($request->hasFile('cover_image')) {
            $this->deleteImage($gallery->cover_image);
            $coverImagePath = $this->uploadCoverImage($request);
        }

        $gallery->update([
            'cover_image' => $coverImagePath,
            'album_name_en' => $request->album_name_en,
            'album_name_ar' => $request->album_name_ar,
            'album_description_en' => $request->album_description_en,
            'album_description_ar' => $request->album_description_ar,
        ]);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Album updated successfully.');
    }

    /**
     * Remove the specified album from storage.
     */
    public function destroy(Album $gallery)  // ← Changed: $album → $gallery
    {
        $this->deleteImage($gallery->cover_image);
        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Album deleted successfully.');
    }

    // =================================================================
    // Helper Methods
    // =================================================================

    private function uploadCoverImage(Request $request): ?string
    {
        if (!$request->hasFile('cover_image')) {
            return null;
        }

        $file = $request->file('cover_image');
        $directory = public_path('uploads/albums');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
        $file->move($directory, $filename);

        return 'uploads/albums/' . $filename;
    }

    private function deleteImage(?string $path): void
    {
        if (!$path) return;

        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
