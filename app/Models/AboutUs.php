<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        // Titles and Descriptions
        'about_us_title_en',
        'about_us_title_ar',
        'about_us_description_en',
        'about_us_description_ar',

        // Features
        'features_en',
        'features_ar',

        // Main image
        'about_main_image',

        // Slider
        'slider_title_en',
        'slider_title_ar',
        'slider_description_en',
        'slider_description_ar',
        'slider_icon',
    ];

       /**
     * Automatically cast these attributes to arrays when accessed.
     */
    protected $casts = [
        'features_en' => 'array',
        'features_ar' => 'array',
    ];

    public function whyUsSections()
{
    return $this->hasMany(WhyUsSection::class, 'about_us_id');
}
}
