<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_name_en', 'product_name_ar', 'slug', 'description_en', 'description_ar',
        'price', 'quantity', 'status', 'featured',
        'category_id', 'subcategory_id',
        'images', 'hesabate_id', 'hesabate_class_id',
        'variants', 'sizes', 'colors'
    ];

    protected $casts = [
        'images'    => 'array',
        'variants'  => 'array',
        'sizes'     => 'array',
        'colors'    => 'array',
        'featured'  => 'boolean',
        'price'     => 'decimal:4',
    ];

    protected $appends = [
        'main_image',
        'has_variants',
        'variant_count',
        'source',
        'source_label',
        'is_from_hesabate'
    ];

    // =================================================================
    // ====================== SLUGGABLE ================================
    // =================================================================
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'    => 'product_name_en',
                'unique'    => true,
                'onUpdate'  => false,
                'maxLength' => 100,
            ]
        ];
    }

    // =================================================================
    // ====================== RELATIONSHIPS ============================
    // =================================================================
    public function category()
    {
        return $this->belongsTo(ProductCategory::class)
                    ->withDefault(['name_en' => 'Uncategorized', 'name_ar' => 'غير مصنف']);
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class)->withDefault();
    }

    // =================================================================
    // ====================== MUTATORS & ACCESSORS ====================
    // =================================================================

    // Fix: Prevent product_name_en/ar from ever being array (causes Sluggable error)
    public function getProductNameEnAttribute($value): string
    {
        return is_array($value) ? ($value[0] ?? '') : (string) $value;
    }

    public function getProductNameArAttribute($value): string
    {
        return is_array($value) ? ($value[0] ?? '') : (string) $value;
    }

    public function setProductNameEnAttribute($value): void
    {
        $this->attributes['product_name_en'] = is_array($value) ? ($value[0] ?? '') : (string) $value;
    }

    public function setProductNameArAttribute($value): void
    {
        $this->attributes['product_name_ar'] = is_array($value) ? ($value[0] ?? '') : (string) $value;
    }

    // Main Image (safe & always returns valid URL)
    public function getMainImageAttribute(): string
    {
        $images = $this->images ?? [];
        return is_array($images) && count($images) > 0 && !empty($images[0])
            ? asset($images[0])
            : asset('images/default-product.png');
    }

    public function getGalleryAttribute(): array
    {
        $images = $this->images ?? [];
        return collect($images)->map(fn($img) => asset($img))->all();
    }

    // Variants
    public function getHasVariantsAttribute(): bool
    {
        return !empty($this->variants);
    }

    public function getVariantCountAttribute(): int
    {
        return count($this->variants ?? []);
    }

    public function getAvailableSizesAttribute(): array
    {
        return $this->sizes ?? [];
    }

    public function getAvailableColorsAttribute(): array
    {
        return $this->colors ?? [];
    }

    // =================================================================
    // ====================== SOURCE DETECTION =========================
    // =================================================================
    public function getIsFromHesabateAttribute(): bool
    {
        return !empty($this->hesabate_id);
    }

    public function getSourceAttribute(): string
    {
        return $this->is_from_hesabate ? 'hesabate_api' : 'manual';
    }

    public function getSourceLabelAttribute(): string
    {
        return $this->is_from_hesabate ? 'Hesabate' : 'Manual';
    }

    public function getSourceBadgeAttribute(): string
    {
        return $this->is_from_hesabate
            ? '<span class="badge bg-info text-white"><i class="fas fa-cloud"></i> Hesabate</span>'
            : '<span class="badge bg-secondary"><i class="fas fa-user-edit"></i> Manual</span>';
    }

    // =================================================================
    // ====================== SCOPES ===================================
    // =================================================================
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('quantity', '>', 0);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    // =================================================================
    // ====================== BOOT =====================================
    // =================================================================
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            // Auto-calculate total quantity from variants
            if (!empty($product->variants) && is_array($product->variants)) {
                $total = collect($product->variants)->sum('current_amount');
                $product->quantity = $total > 0 ? $total : 0;
            }

            // Auto-update status based on stock
            $product->status = $product->quantity > 0 ? 'active' : 'inactive';
        });
    }
}
