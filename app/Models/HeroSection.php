<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $table = 'hero_sections';
    protected $fillable = ['page', 'title_en', 'title_ar', 'description_en', 'description_ar', 'button_text_en', 'button_text_ar', 'button_link', 'image','identifier', 'label'];
}
