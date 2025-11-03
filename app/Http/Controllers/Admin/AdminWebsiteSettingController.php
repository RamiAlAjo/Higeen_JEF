<?php

namespace App\Http\Controllers\Admin;

use App\Models\WebsiteSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AdminWebsiteSettingController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::first();
        $phones = [];

        if ($settings && $settings->phone) {
            $phones = json_decode($settings->phone, true);
            if (!is_array($phones)) {
                $phones = [];
            }
        }

        return view('admin.setting.index', compact('settings', 'phones'));
    }

    public function store(Request $request)
    {
        Log::info('Website Settings Request:', $request->all());

        $validated = $request->validate([
            // Social links
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'pinterest' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'watsapp' => 'nullable|url',

            // Website info
            'title' => 'nullable|string|max:255',
            'website_description' => 'nullable|string',
            'key_words' => 'nullable|string',
            'phone' => 'nullable|array|max:3',
            'phone.*' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'contact_email' => 'nullable|email',
            'carrers_email' => 'nullable|email',
            'address' => 'nullable|string',
            'url' => 'nullable|url',
            'location' => 'nullable|string',

            // Logo upload
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_logo' => 'nullable|boolean',
        ]);

        $setting = WebsiteSetting::firstOrNew([]);
        $setting->fill($validated);
        $setting->phone = json_encode($request->phone ?? []);

        // Handle logo upload or removal
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($setting->logo && File::exists(($setting->logo))) {
                File::delete(($setting->logo));
            }

            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $destination = ('uploads/logos');

            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $setting->logo = '/uploads/logos/' . $filename;

            Log::info('Logo uploaded: ' . $setting->logo);
        } elseif ($request->input('remove_logo')) {
            // Remove logo manually
            if ($setting->logo && File::exists(($setting->logo))) {
                File::delete(($setting->logo));
            }
            $setting->logo = null;
            Log::info('Logo removed manually');
        }

        try {
            $setting->save();
            Log::info('Website settings saved successfully', $setting->toArray());

            return redirect()->route('admin.setting.index')
                ->with('status-success', 'Settings have been updated successfully!');
        } catch (\Exception $e) {
            Log::error('Website settings save failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('status-error', 'Failed to save settings: ' . $e->getMessage());
        }
    }
}
