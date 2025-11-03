<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductSubcategory extends Model
{
    use HasFactory;

    // KEEP THE REAL TABLE NAME
    protected $table = 'products_subcategories';

    protected $fillable = [
        'name_en','name_ar','description_en','description_ar',
        'image','status','category_id','slug'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sub) {
            $sub->slug = $sub->slug ?: Str::slug($sub->name_en);
        });
    }
}
