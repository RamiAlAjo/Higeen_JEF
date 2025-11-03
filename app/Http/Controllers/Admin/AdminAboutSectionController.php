<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminAboutSectionController extends Controller
{
    public function index()
    {
        $aboutSection = AboutSection::first();
        return view('admin.homepage.about.index', compact('aboutSection'));
    }

    public function store(Request $request)
    {
        Log::info('About Section Form Data:', $request->all());

        $validated = $request->validate([
            'heading_en' => 'required|string|max:255',
            'heading_ar' => 'required|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string|max:255',
            'highlight_word_en' => 'nullable|string|max:255',
            'highlight_word_ar' => 'nullable|string|max:255',
            'paragraph_en' => 'nullable|string',
            'paragraph_ar' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'main_image_alt' => 'nullable|string|max:255',
            'small_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'small_image_alt' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'label_en' => 'nullable|string|max:255',
            'label_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'remove_main_image' => 'nullable|boolean',
            'remove_small_image' => 'nullable|boolean',
            'remove_icon_image' => 'nullable|boolean',
        ]);

        $aboutSection = AboutSection::firstOrNew([]);
        $aboutSection->fill($validated);

        // ===== Handle Main Image =====
        if ($request->hasFile('main_image')) {
            if ($aboutSection->main_image && file_exists(($aboutSection->main_image))) {
                unlink(($aboutSection->main_image));
            }

            $file = $request->file('main_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = ('uploads/about-sections/main_images');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $aboutSection->main_image = '/uploads/about-sections/main_images/' . $filename;
            Log::info('Main image uploaded: ' . $aboutSection->main_image);
        } elseif ($request->input('remove_main_image') == 1) {
            if ($aboutSection->main_image && file_exists(($aboutSection->main_image))) {
                unlink(($aboutSection->main_image));
            }
            $aboutSection->main_image = null;
            Log::info('Main image removed');
        }

        // ===== Handle Small Image =====
        if ($request->hasFile('small_image')) {
            if ($aboutSection->small_image && file_exists(($aboutSection->small_image))) {
                unlink(($aboutSection->small_image));
            }

            $file = $request->file('small_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = ('uploads/about-sections/small_images');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $aboutSection->small_image = '/uploads/about-sections/small_images/' . $filename;
            Log::info('Small image uploaded: ' . $aboutSection->small_image);
        } elseif ($request->input('remove_small_image') == 1) {
            if ($aboutSection->small_image && file_exists(($aboutSection->small_image))) {
                unlink(($aboutSection->small_image));
            }
            $aboutSection->small_image = null;
            Log::info('Small image removed');
        }

        // ===== Handle Icon Image =====
        if ($request->hasFile('icon_image')) {
            if ($aboutSection->icon_image && file_exists(($aboutSection->icon_image))) {
                unlink(($aboutSection->icon_image));
            }

            $file = $request->file('icon_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = ('uploads/about-sections/icon_images');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $aboutSection->icon_image = '/uploads/about-sections/icon_images/' . $filename;
            Log::info('Icon image uploaded: ' . $aboutSection->icon_image);
        } elseif ($request->input('remove_icon_image') == 1) {
            if ($aboutSection->icon_image && file_exists(($aboutSection->icon_image))) {
                unlink(($aboutSection->icon_image));
            }
            $aboutSection->icon_image = null;
            Log::info('Icon image removed');
        }

        // ===== Save to Database =====
        try {
            $aboutSection->save();
            Log::info('About section saved successfully', $aboutSection->toArray());
        } catch (\Exception $e) {
            Log::error('Failed to save about section: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('status-error', 'Failed to save about section: ' . $e->getMessage());
        }

        return redirect()->route('admin.about-sections.index')
            ->with('status-success', 'About section has been updated successfully!');
    }
}
