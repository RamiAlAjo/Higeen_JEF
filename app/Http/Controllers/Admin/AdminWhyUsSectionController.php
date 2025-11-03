<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyUsSection;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminWhyUsSectionController extends Controller
{
    // Show paginated Why Us sections
    public function index()
    {
        $sections = WhyUsSection::paginate(10);
        return view('admin.about.whyus.index', compact('sections'));
    }

    // Show create form
public function create()
{
    $aboutUs = AboutUs::first(); // or find($id)
    return view('admin.about.whyus.create', compact('aboutUs'));
}

    // Store multiple Why Us entries
    public function store(Request $request)
{
    $request->validate([
        'about_us_id' => 'required|exists:about_us,id',
        'pages' => 'required|array',
        'pages.*.title_en' => 'required|string',
        'pages.*.title_ar' => 'required|string',
        'pages.*.description_en' => 'nullable|string', // Allow HTML
        'pages.*.description_ar' => 'nullable|string', // Allow HTML
        'pages.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    foreach ($request->pages as $page) {
        $uploadedImages = [];

        if (!empty($page['images'])) {
            foreach ($page['images'] as $image) {
                if ($image && $image->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = public_path('uploads/whyus_pages');
                    if (!File::exists($path)) File::makeDirectory($path, 0755, true);
                    $image->move($path, $filename);
                    $uploadedImages[] = 'uploads/whyus_pages/' . $filename;
                }
            }
        }

        WhyUsSection::create([
            'about_us_id' => $request->about_us_id,
            'why_us_page_title_en' => $page['title_en'],
            'why_us_page_title_ar' => $page['title_ar'],
            'why_us_page_description_en' => $page['description_en'], // HTML saved
            'why_us_page_description_ar' => $page['description_ar'], // HTML saved
            'why_us_page_images' => $uploadedImages,
        ]);
    }

    return redirect()->route('admin.whyus.index')->with('success', 'Saved!');
}

public function edit($aboutUsId)
{
    $aboutUs = AboutUs::with('whyUsSections')->findOrFail($aboutUsId);
    return view('admin.about.whyus.edit', compact('aboutUs'));
}
public function update(Request $request, $aboutUsId)
{
    $request->validate([
        'pages' => 'required|array',
        'pages.*.title_en' => 'required|string',
        'pages.*.title_ar' => 'required|string',
        'pages.*.description_en' => 'nullable|string',
        'pages.*.description_ar' => 'nullable|string',
        'pages.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $aboutUs = AboutUs::findOrFail($aboutUsId);

    // Delete removed pages
    $existingIds = collect($request->pages)->pluck('id')->filter()->toArray();
    WhyUsSection::where('about_us_id', $aboutUsId)->whereNotIn('id', $existingIds)->delete();

    foreach ($request->pages as $index => $page) {
        $images = $page['existing_images'] ?? [];

        if (!empty($page['images'])) {
            foreach ($page['images'] as $file) {
                if ($file && $file->isValid()) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/whyus_pages'), $filename);
                    $images[] = 'uploads/whyus_pages/' . $filename;
                }
            }
        }

        $data = [
            'why_us_page_title_en' => $page['title_en'],
            'why_us_page_title_ar' => $page['title_ar'],
            'why_us_page_description_en' => $page['description_en'],
            'why_us_page_description_ar' => $page['description_ar'],
            'why_us_page_images' => $images,
        ];

        if (isset($page['id'])) {
            WhyUsSection::find($page['id'])->update($data);
        } else {
            $data['about_us_id'] = $aboutUsId;
            WhyUsSection::create($data);
        }
    }

    return redirect()->route('admin.whyus.index')->with('success', 'Updated successfully!');
}

    // Delete a Why Us section and its images
    public function destroy($id)
    {
        $section = WhyUsSection::findOrFail($id);

        if ($section->why_us_page_images) {
            foreach ($section->why_us_page_images as $imagePath) {
                $fullPath = ($imagePath);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
            }
        }

        $section->delete();

        return redirect()->route('admin.whyus.index')->with('success', 'Why Us section deleted successfully.');
    }
}
