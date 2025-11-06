<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'client_id',
        'full_name',
        'email',
        'phone_number',
        'shipping_area_id',        // ← new
        'shipping_address',
        'subtotal',
        'shipping_cost',
        'discount',
        'discount_percent',
        'discount_type',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'delivery_status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function shippingArea()
    {
        return $this->belongsTo(ShippingArea::class, 'shipping_area_id');
    }


}