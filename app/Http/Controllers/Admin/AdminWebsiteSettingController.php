<?php

namespace App\Http\Controllers\Admin;

use App\Models\WebsiteSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AdminWebsiteSettingController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::firstOrCreate([]);
        $phones   = is_array($settings->phone) ? $settings->phone : [];

        return view('admin.setting.index', compact('settings', 'phones'));
    }

    public function store(Request $request)
    {
        Log::info('Website Settings Update Request:', $request->all());

        $validated = $request->validate([
            // Social Links
            'facebook'   => 'nullable|url:http,https',
            'instagram'  => 'nullable|url:http,https',
            'twitter'    => 'nullable|url:http,https',
            'youtube'    => 'nullable|url:http,https',
            'linkedin'   => 'nullable|url:http,https',
            'pinterest'  => 'nullable|url:http,https',
            'tiktok'     => 'nullable|url:http,https',
            'watsapp'    => 'nullable|url:http,https',

            // Website Info
            'title'              => 'nullable|string|max:255',
            'website_description'=> 'nullable|string|max:10000',
            'key_words'          => 'nullable|string|max:1000',
            'phone'              => 'nullable|array|max:5',
            'phone.*'            => 'nullable|string|max:20|regex:/^[\+0-9\s\-\(\)]+$/',
            'fax'                => 'nullable|string|max:20',
            'email'              => 'nullable|email',
            'contact_email'      => 'nullable|email',
            'carrers_email'      => 'nullable|email',
            'address'            => 'nullable|string|max:500',
            'url'                => 'nullable|url:http,https',

            // Locations (Dynamic Array)
            'locations'                    => 'nullable|array',
            'locations.*.name'             => 'required_with:locations.*|string|max:255',
            'locations.*.address'          => 'nullable|string|max:500',
            'locations.*.lat'              => 'required_with:locations.*|numeric|between:-90,90',
            'locations.*.lng'              => 'required_with:locations.*|numeric|between:-180,180',

            // Logo
            'logo'                        => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'remove_logo'                 => 'sometimes|in:1,true,on',
        ], [
            'locations.*.lat.required_with' => 'Latitude is required for each location.',
            'locations.*.lng.required_with' => 'Longitude is required for each location.',
            'phone.*.regex'                 => 'Phone number contains invalid characters.',
        ]);

        DB::beginTransaction();
        try {
            $setting = WebsiteSetting::firstOrNew(['id' => 1]);
            $setting->fill(collect($validated)->except(['phone', 'locations', 'logo', 'remove_logo'])->all());

            // Handle phones
            $phones = array_filter($request->input('phone', []), fn($p) => !empty(trim($p)));
            $setting->phone = !empty($phones) ? array_values($phones) : null;

            // Handle locations - filter out incomplete ones
            $rawLocations = $request->input('locations', []);
            $locations = collect($rawLocations)
                ->filter(function ($loc) {
                    return !empty($loc['name']) &&
                           isset($loc['lat']) && is_numeric($loc['lat']) &&
                           isset($loc['lng']) && is_numeric($loc['lng']);
                })
                ->map(function ($loc) {
                    return [
                        'name'    => trim($loc['name']),
                        'address' => trim($loc['address'] ?? ''),
                        'lat'     => (float) $loc['lat'],
                        'lng'     => (float) $loc['lng'],
                    ];
                })
                ->values()
                ->toArray();

            $setting->locations = !empty($locations) ? $locations : null;

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $this->deleteExistingLogo($setting);

                $file = $request->file('logo');
                $ext = $file->getClientOriginalExtension();
                $filename = 'logo_' . time() . '.' . $ext;

                $file->move(public_path('uploads/logos'), $filename);
                $setting->logo = 'uploads/logos/' . $filename;
            }

            // Handle logo removal
            if ($request->boolean('remove_logo')) {
                $this->deleteExistingLogo($setting);
                $setting->logo = null;
            }

            $setting->save();
            DB::commit();

            return redirect()
                ->route('admin.setting.index')
                ->with('status-success', 'تم حفظ الإعدادات بنجاح!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Website Settings Save Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('status-error', 'فشل حفظ الإعدادات: ' . $e->getMessage());
        }
    }

    private function deleteExistingLogo(WebsiteSetting $setting): void
    {
        if ($setting->logo && File::exists(public_path($setting->logo))) {
            File::delete(public_path($setting->logo));
        }
    }
}
