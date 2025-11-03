<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'full_name',
        'email',
        'phone_number',
        'shipping_area',
        'shipping_address',
        'discount',
        'discount_percent',
        'discount_type',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'delivery_status',
        'client_id',
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
}
