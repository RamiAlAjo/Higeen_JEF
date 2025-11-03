<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name_en','product_name_ar','description_en','description_ar',
        'image','price','status','category_id','subcategory_id','slug','quantity'
    ];

    protected $casts = ['image' => 'array'];

    // Relationships – Laravel will use the $table from the related models
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id')->withDefault();
    }

    public function subcategory()
    {
        return $this->belongsTo(ProductSubcategory::class, 'subcategory_id')->withDefault();
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getMainImageUrlAttribute()
    {
        return $this->image && count($this->image)
            ? asset($this->image[0])
            : asset('images/default.png');
    }

    public function getGalleryImagesAttribute()
    {
        return $this->image ?? [];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($p) {
            if (empty($p->slug)) {
                $base = Str::slug($p->product_name_en);
                $count = static::where('slug', 'like', $base.'%')->count();
                $p->slug = $count ? "$base-$count" : $base;
            }
        });

        static::updating(function ($p) {
            if ($p->isDirty('product_name_en') && empty($p->slug)) {
                $base = Str::slug($p->product_name_en);
                $count = static::where('slug', 'like', $base.'%')->count();
                $p->slug = $count ? "$base-$count" : $base;
            }
        });
    }
}
