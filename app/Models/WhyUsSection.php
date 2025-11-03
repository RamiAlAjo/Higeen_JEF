<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyUsSection extends Model
{
    use HasFactory;

    // Specify the table if it doesn't follow Laravel's naming convention (plural snake_case)
    protected $table = 'why_us_section';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'about_us_id',
        'why_us_page_title_en',
        'why_us_page_title_ar',
        'why_us_page_description_en',
        'why_us_page_description_ar',
        'why_us_page_images',
    ];

    /**
     * The attributes that should be cast.
     * Casting why_us_page_images as array to handle JSON automatically.
     */
    protected $casts = [
        'why_us_page_images' => 'array',
    ];

    /**
     * Get the AboutUs that owns this WhyUsSection.
     */
    public function aboutUs()
    {
        return $this->belongsTo(AboutUs::class, 'about_us_id');
    }
}
