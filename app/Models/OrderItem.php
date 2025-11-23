<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name_en',
        'product_name_ar',
        'price',
        'quantity',
        'total',
        'variant_data', // optional: json for color/size
    ];

    protected $casts = [
        'price'   => 'decimal:2',
        'total'   => 'decimal:2',
        'variant_data' => 'array',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }

    // Helper: get name in current locale
    public function getNameAttribute(): string
    {
        return app()->getLocale() === 'ar' ? $this->product_name_ar : $this->product_name_en;
    }
}
