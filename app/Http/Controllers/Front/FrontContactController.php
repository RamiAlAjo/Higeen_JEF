<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FrontContactController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::firstOrCreate([]); // Always returns a model
        return view('front.contact', compact('settings'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email',
            'message' => 'required|string|max:2000',
        ]);

        $settings = WebsiteSetting::first();

        try {
            Mail::to($settings->contact_email ?? 'info@hospital.com')
                ->send(new \App\Mail\ContactMessage($request->all()));
        } catch (\Exception $e) {
            \Log::error('Contact form email failed: ' . $e->getMessage());
        }

        return back()->with('success', __('contact.success_message'));
    }
}
