<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Table name
     */
    protected $table = 'gallery'; // Explicitly set since not plural

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'album_id',
        'image',
        'alt',
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'filesize',
        'mime_type',
        'status',
        'sort_order',
    ];

    /**
     * Cast attributes to proper data types
     */
    protected $casts = [
        'status' => 'boolean',
        'filesize' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Relationships
     */

    // Each gallery image belongs to one album
    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    /**
     * Accessors & Mutators
     */

    // Get full image URL (assuming images are stored in /storage/gallery)
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? asset('storage/gallery/' . $this->image)
            : null;
    }

    // Dynamic title accessor (returns appropriate language)
    public function getTitleAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->title_ar
            ? $this->title_ar
            : $this->title_en;
    }

    // Dynamic description accessor
    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->description_ar
            ? $this->description_ar
            : $this->description_en;
    }

    /**
     * Scopes
     */

    // Scope: only visible images
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope: order by display order
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
