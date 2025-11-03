<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component; // Correct namespace for the base Component class
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Models\HeroSection as HeroSectionModel;

class HeroSectionComponent extends Component
{
    public $hero;

    public function __construct(?string $page = null)
    {
        // Use route name as page identifier if not provided
        $page = $page ?? Route::currentRouteName() ?? 'home';

        $locale = App::getLocale();
        $heroData = HeroSectionModel::where('page', $page)->first();

        if ($heroData) {
            $this->hero = [
                'title' => $heroData->{'title_' . $locale} ?? 'Default Title',
                'description' => $heroData->{'description_' . $locale} ?? 'Default description.',
                'button_text' => $heroData->{'button_text_' . $locale} ?? null,
                'button_link' => $heroData->button_link ?? null,
                'image' => $heroData->image ? asset($heroData->image) : asset('uploads/default.jpg'),
            ];
        } else {
            $this->hero = [
                'title' => 'Default Hero Title',
                'description' => 'Lorem ipsum dolor sit amet...',
                'button_text' => null,
                'button_link' => null,
                'image' => asset('uploads/default.jpg'),
            ];
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.hero-section-component');
    }
}
