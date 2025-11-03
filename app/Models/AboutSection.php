<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $table = 'about_section';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'heading_en',
        'heading_ar',
        'subtitle_en',
        'subtitle_ar',
        'highlight_word_en',
        'highlight_word_ar',
        'paragraph_en',
        'paragraph_ar',
        'main_image',
        'main_image_alt',
        'small_image',
        'small_image_alt',
        'icon_image',
        'label_en',
        'label_ar',
        'description_en',
        'description_ar',
    ];
}
