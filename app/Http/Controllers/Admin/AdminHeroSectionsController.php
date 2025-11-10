<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminHeroSectionsController extends Controller
{
    private $pages = [
        'home' => 'Homepage',
        'about' => 'About Us',
        'contact' => 'Contact',
        'client_dashboard' => 'Client Dashboard',
        'confirmation' => 'Confirmation',
        'cart' => 'Cart',
        'gallery' => 'Gallery',
        'products.index' => 'Product List',
        'products.show' => 'Product Details',
    ];

    public function index()
    {
        $heroSections = HeroSection::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.hero_sections.index', compact('heroSections'));
    }

    public function create()
    {
        $pages = $this->pages;
        return view('admin.hero_sections.create', compact('pages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page' => ['required', 'string', Rule::in(array_keys($this->pages)), 'unique:hero_sections,page'],
            'title_en' => ['nullable', 'string', 'required_without:title_ar'],
            'title_ar' => ['nullable', 'string', 'required_without:title_en'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'button_text_en' => ['nullable', 'string', 'max:255'],
            'button_text_ar' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10048'],
        ]);

        if ($request->hasFile('image')) {
            try {
                $validated['image'] = $this->uploadImage($request->file('image'), 'hero_images');
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        try {
            HeroSection::create($validated);
        } catch (\Exception $e) {
            Log::error('Hero section creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create hero section: ' . $e->getMessage());
        }

        return redirect()->route('admin.hero_section.index')->with('success', 'Hero Section created successfully!');
    }

 public function edit(HeroSection $heroSection)
{
    $pages = $this->pages;
    return view('admin.hero_sections.edit', compact('heroSection', 'pages'));
}



    public function update(Request $request, HeroSection $heroSection)
    {
        $validated = $request->validate([
            'page' => ['required', 'string', Rule::in(array_keys($this->pages)), Rule::unique('hero_sections', 'page')->ignore($heroSection->id)],
            'title_en' => ['nullable', 'string', 'required_without:title_ar'],
            'title_ar' => ['nullable', 'string', 'required_without:title_en'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'button_text_en' => ['nullable', 'string', 'max:255'],
            'button_text_ar' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10048'],
        ]);

        if ($request->hasFile('image')) {
            try {
                $this->deleteImage($heroSection->image);
                $validated['image'] = $this->uploadImage($request->file('image'), 'hero_images');
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        try {
            $heroSection->update($validated);
        } catch (\Exception $e) {
            Log::error('Hero section update failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update hero section: ' . $e->getMessage());
        }

        return redirect()->route('admin.hero_section.index')->with('success', 'Hero Section updated successfully!');
    }

    public function destroy(HeroSection $heroSection)
    {
        try {
            $this->deleteImage($heroSection->image);
            $heroSection->delete();
        } catch (\Exception $e) {
            Log::error('Hero section deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete hero section: ' . $e->getMessage());
        }

        return redirect()->route('admin.hero_section.index')->with('success', 'Hero Section deleted successfully!');
    }

    private function uploadImage($file, $folder)
    {
        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = time() . '_' . Str::slug($baseName) . '.' . $file->getClientOriginalExtension();

        $path = ("uploads/$folder");
        if (!File::exists($path)) {
            try {
                File::makeDirectory($path, 0755, true);
            } catch (\Exception $e) {
                Log::error('Failed to create directory: ' . $path . ' - ' . $e->getMessage());
                throw new \Exception('Failed to create directory: ' . $e->getMessage());
            }
        }

        try {
            $file->move($path, $filename);
        } catch (\Exception $e) {
            Log::error('Failed to move file to ' . $path . '/' . $filename . ': ' . $e->getMessage());
            throw new \Exception('Failed to save file: ' . $e->getMessage());
        }

        return "uploads/$folder/$filename";
    }

    private function deleteImage($path)
    {
        if ($path && File::exists(($path))) {
            try {
                File::delete(($path));
            } catch (\Exception $e) {
                Log::error('Failed to delete image: ' . $path . ' - ' . $e->getMessage());
            }
        }
    }
}