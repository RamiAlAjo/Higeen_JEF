<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminAboutController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::first();
        return view('admin.about.index', compact('aboutUs'));
    }

    public function create()
    {
        if (AboutUs::exists()) {
            return redirect()->route('admin.about.index')->with('error', 'About Us already exists.');
        }

        return view('admin.about.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $about = new AboutUs();
        $about->about_us_title_en = $validated['about_us_title_en'];
        $about->about_us_title_ar = $validated['about_us_title_ar'];
        $about->about_us_description_en = $validated['about_us_description_en'];
        $about->about_us_description_ar = $validated['about_us_description_ar'];

        // Handle features as JSON
        $about->features_en = !empty($validated['features_en']) ? json_encode(array_filter($validated['features_en'], function ($feature) {
            return !empty($feature['text']);
        })) : null;
        $about->features_ar = !empty($validated['features_ar']) ? json_encode(array_filter($validated['features_ar'], function ($feature) {
            return !empty($feature['text']);
        })) : null;

        // Handle main image
        if ($request->hasFile('about_main_image')) {
            $about->about_main_image = $this->uploadImage($request->file('about_main_image'), 'about');
        }

        // Handle sliders
        if (isset($validated['sliders']) && is_array($validated['sliders'])) {
            $sliderDescriptionsEn = [];
            $sliderDescriptionsAr = [];
            $sliderIcon = null;

            foreach ($validated['sliders'] as $index => $sliderData) {
                if (!empty(array_filter($sliderData))) {
                    $sliderDescriptionsEn[] = $sliderData['slider_description_en'] ?? null;
                    $sliderDescriptionsAr[] = $sliderData['slider_description_ar'] ?? null;

                    // Use the first valid slider icon
                    if (!$sliderIcon && $request->hasFile("sliders.$index.slider_icon")) {
                        $sliderIcon = $this->uploadImage($request->file("sliders.$index.slider_icon"), 'slider');
                    }
                }
            }

            $about->slider_title_en = $validated['sliders'][0]['slider_title_en'] ?? null;
            $about->slider_title_ar = $validated['sliders'][0]['slider_title_ar'] ?? null;
            $about->slider_description_en = !empty($sliderDescriptionsEn) ? json_encode(array_filter($sliderDescriptionsEn, 'trim')) : null;
            $about->slider_description_ar = !empty($sliderDescriptionsAr) ? json_encode(array_filter($sliderDescriptionsAr, 'trim')) : null;
            $about->slider_icon = $sliderIcon;
        }

        $about->save();

        return redirect()->route('admin.about.index')->with('success', 'About Us created successfully.');
    }

    public function edit($id)
    {
        $aboutUs = AboutUs::findOrFail($id);
        return view('admin.about.edit', compact('aboutUs'));
    }

    public function update(Request $request, $id)
    {
        $about = AboutUs::findOrFail($id);
        $validated = $this->validateRequest($request);

        // Update AboutUs fields
        $about->about_us_title_en = $validated['about_us_title_en'];
        $about->about_us_title_ar = $validated['about_us_title_ar'];
        $about->about_us_description_en = $validated['about_us_description_en'];
        $about->about_us_description_ar = $validated['about_us_description_ar'];

        // Handle features as JSON
        $about->features_en = !empty($validated['features_en']) ? json_encode(array_filter($validated['features_en'], function ($feature) {
            return !empty($feature['text']);
        })) : null;
        $about->features_ar = !empty($validated['features_ar']) ? json_encode(array_filter($validated['features_ar'], function ($feature) {
            return !empty($feature['text']);
        })) : null;

        // Handle main image
        if ($request->hasFile('about_main_image')) {
            $this->deleteOldImage($about->about_main_image);
            $about->about_main_image = $this->uploadImage($request->file('about_main_image'), 'about');
        }

        // Handle sliders
        if (isset($validated['sliders']) && is_array($validated['sliders'])) {
            $sliderDescriptionsEn = [];
            $sliderDescriptionsAr = [];
            $sliderIcon = $about->slider_icon;

            // Delete old slider icon if a new one is uploaded
            if ($request->hasFile('sliders.0.slider_icon')) {
                $this->deleteOldImage($about->slider_icon);
                $sliderIcon = $this->uploadImage($request->file('sliders.0.slider_icon'), 'slider');
            }

            foreach ($validated['sliders'] as $index => $sliderData) {
                if (!empty(array_filter($sliderData))) {
                    $sliderDescriptionsEn[] = $sliderData['slider_description_en'] ?? null;
                    $sliderDescriptionsAr[] = $sliderData['slider_description_ar'] ?? null;
                }
            }

            $about->slider_title_en = $validated['sliders'][0]['slider_title_en'] ?? null;
            $about->slider_title_ar = $validated['sliders'][0]['slider_title_ar'] ?? null;
            $about->slider_description_en = !empty($sliderDescriptionsEn) ? json_encode(array_filter($sliderDescriptionsEn, 'trim')) : null;
            $about->slider_description_ar = !empty($sliderDescriptionsAr) ? json_encode(array_filter($sliderDescriptionsAr, 'trim')) : null;
            $about->slider_icon = $sliderIcon;
        } else {
            // Clear sliders if none provided
            $this->deleteOldImage($about->slider_icon);
            $about->slider_title_en = null;
            $about->slider_title_ar = null;
            $about->slider_description_en = null;
            $about->slider_description_ar = null;
            $about->slider_icon = null;
        }

        $about->save();

        return redirect()->route('admin.about.index')->with('success', 'About Us updated successfully.');
    }

    public function destroy($id)
    {
        $about = AboutUs::findOrFail($id);

        $this->deleteOldImage($about->about_main_image);
        $this->deleteOldImage($about->slider_icon);

        $about->delete();

        return redirect()->route('admin.about.index')->with('success', 'About Us deleted.');
    }

    private function validateRequest(Request $request)
    {
        return $request->validate([
            'about_us_title_en' => 'required|string|max:255',
            'about_us_title_ar' => 'required|string|max:255',
            'about_us_description_en' => 'nullable|string',
            'about_us_description_ar' => 'nullable|string',
            'features_en' => 'nullable|array',
            'features_en.*.text' => 'required|string|max:255',
            'features_en.*.icon' => 'required|string|in:bi bi-check2-circle,bi bi-star-fill,bi bi-shield-fill,bi bi-lightbulb-fill,bi bi-headset',
            'features_ar' => 'nullable|array',
            'features_ar.*.text' => 'required|string|max:255',
            'features_ar.*.icon' => 'required|string|in:bi bi-check2-circle,bi bi-star-fill,bi bi-shield-fill,bi bi-lightbulb-fill,bi bi-headset',
            'about_main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sliders' => 'nullable|array',
            'sliders.*.slider_icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sliders.*.slider_title_en' => 'nullable|string|max:255',
            'sliders.*.slider_title_ar' => 'nullable|string|max:255',
            'sliders.*.slider_description_en' => 'nullable|string',
            'sliders.*.slider_description_ar' => 'nullable|string',
        ]);
    }

    private function uploadImage($file, $folder)
    {
        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = time() . '_' . Str::slug($baseName) . '.' . $file->getClientOriginalExtension();
        $path = "Uploads/about_us/$folder";

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $file->move($path, $filename);

        return "/Uploads/about_us/$folder/$filename";
    }

    private function deleteOldImage($path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
