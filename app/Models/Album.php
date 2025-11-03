<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    // If your table name is NOT 'albums', uncomment the line below
    // protected $table = 'albums';

    protected $fillable = [
        // 'name',
        'cover_image',
        'album_name_en',
        'album_name_ar',
        'album_description_en',
        'album_description_ar',
    ];

    /**
     * Relationship: An album has many gallery images.
     */
    public function gallery()
    {
        return $this->hasMany(Gallery::class, 'album_id');
    }

    // Optional: alias for clarity
    public function images()
    {
        return $this->hasMany(Gallery::class, 'album_id');
    }
}
