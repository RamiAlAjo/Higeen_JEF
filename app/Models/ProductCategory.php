<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    // KEEP THE REAL TABLE NAME
    protected $table = 'products_categories';

    protected $fillable = [
        'name_en','name_ar','description_en','description_ar',
        'image','status','slug'
    ];

    public function subcategories()
    {
        return $this->hasMany(ProductSubcategory::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id')
                    ->whereNull('subcategory_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cat) {
            $cat->slug = $cat->slug ?: Str::slug($cat->name_en);
        });
    }
}
