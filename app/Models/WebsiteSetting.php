<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $table = 'website_settings';

    protected $fillable = [
        'facebook', 'instagram', 'twitter', 'youtube', 'linkedin',
        'pinterest', 'tiktok', 'title', 'website_description',
        'key_words', 'phone', 'fax', 'email', 'address', 'logo',
        'contact_email', 'carrers_email', 'url', 'locations'
    ];

    protected $casts = [
        'phone'     => 'array',
        'locations' => 'array',
    ];

    // Always return array of phones
    public function getPhoneAttribute($value)
    {
        if (empty($value)) {
            return ['+962 79112559'];
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? array_filter($decoded) : [$value];
        }
        return is_array($value) ? array_filter($value) : [$value];
    }

    // Always return valid locations with lat/lng
    public function getLocationsAttribute($value)
    {
        $default = [[
            'name'    => 'المستشفى التخصصي',
            'address' => 'عمان - الأردن',
            'lat'     => 31.9787532,
            'lng'     => 35.9004003
        ]];

        if (empty($value)) return $default;

        $decoded = is_string($value) ? json_decode($value, true) : $value;
        if (!is_array($decoded)) return $default;

        $valid = array_filter($decoded, fn($loc) =>
            is_array($loc) &&
            !empty($loc['lat']) &&
            !empty($loc['lng'])
        );

        return !empty($valid) ? array_values($valid) : $default;
    }

    // Optional: Get first location easily
    public function getPrimaryLocationAttribute()
    {
        return $this->locations[0] ?? null;
    }
}