<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

 protected $fillable = [
    'name', 'email', 'password', 'phone_number',
    'shipping_address', 'billing_address', 'preferred_payment_method',
    'area', 'gender', 'date_of_birth', 'avatar'
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // A client can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
