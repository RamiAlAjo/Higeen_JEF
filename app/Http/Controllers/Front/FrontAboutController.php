<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;

class FrontAboutController extends Controller
{
    public function index()
    {
        // Load AboutUs with all WhyUs cards
        $aboutUs = AboutUs::with('whyUsSections')->first();

        $locale = app()->getLocale();

        return view('front.about', compact('aboutUs', 'locale'));
    }

    public function show($id)
    {
        $card = \App\Models\WhyUsSection::findOrFail($id);
        $locale = app()->getLocale();

        return view('front.pages.whyus-show', compact('card', 'locale'));
    }
}
