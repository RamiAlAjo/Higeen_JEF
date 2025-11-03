<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $table = 'website_settings';

    protected $fillable = [
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'linkedin',
        'pinterest',
        'tiktok',
        'watsapp',
        'title',
        'website_description',
        'key_words',
        'phone',
        'fax',
        'email',
        'address',
        'logo',
        'contact_email',
        'carrers_email',
        'url',
        'location',
    ];

    protected $casts = [
        'phone' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
