<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingArea extends Model
{
    protected $fillable = ['name', 'type', 'parent_id', 'cost'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function scopeDistricts($query)
    {
        return $query->where('type', 'district');
    }
}
