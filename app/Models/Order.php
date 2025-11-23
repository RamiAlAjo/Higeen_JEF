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
        'shipping_area_id',
        'shipping_address',
        'shipping_area', // legacy
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
        'hesabate_sent_at',
        'hesabate_synced',
    ];

    protected $casts = [
        'hesabate_sent_at' => 'datetime',
        'hesabate_synced'  => 'boolean',
        'total'            => 'decimal:2',
        'subtotal'         => 'decimal:2',
        'shipping_cost'    => 'decimal:2',
        'discount'         => 'decimal:2',
    ];

    // =================================================================
    // Relationships
    // =================================================================
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

    // =================================================================
    // Hesabate Sync Helpers (Best Practice)
    // =================================================================

    // Check if already sent
    public function wasSentToHesabate(): bool
    {
        return !is_null($this->hesabate_sent_at) || $this->hesabate_synced === true;
    }

    // Scope: only orders not sent
    public function scopeNotSentToHesabate($query)
    {
        return $query->whereNull('hesabate_sent_at')
                     ->where('hesabate_synced', false);
    }

    // Scope: already sent
    public function scopeSentToHesabate($query)
    {
        return $query->where(function ($q) {
            $q->whereNotNull('hesabate_sent_at')
              ->orWhere('hesabate_synced', true);
        });
    }

    // Accessor: human readable status
    public function getHesabateStatusAttribute(): string
    {
        return $this->wasSentToHesabate() ? 'sent' : 'not_sent';
    }

    // Accessor: ready-to-use badge (Blade)
    public function getHesabateBadgeAttribute(): string
    {
        if ($this->wasSentToHesabate()) {
            $time = $this->hesabate_sent_at?->diffForHumans() ?? 'Synced';
            return '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Sent ' . $time . '</span>';
        }

        if ($this->status === 'delivered' && $this->payment_status === 'paid') {
            return '<span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Ready to send</span>';
        }

        return '<span class="badge bg-secondary"><i class="fas fa-ban"></i> Not eligible</span>';
    }

    // Accessor: eligibility for sending
    public function getCanSendToHesabateAttribute(): bool
    {
        return $this->status === 'delivered'
            && $this->payment_status === 'paid'
            && !$this->wasSentToHesabate();
    }
}
