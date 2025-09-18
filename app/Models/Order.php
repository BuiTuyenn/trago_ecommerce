<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'tax_amount',
        'shipping_cost',
        'total_amount',
        'currency',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_company',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',
        'shipping_phone',
        'billing_first_name',
        'billing_last_name',
        'billing_company',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
        'billing_phone',
        'payment_method',
        'payment_status',
        'notes',
        'shipped_at',
        'delivered_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime'
    ];

    // Relationship với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship với order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship với reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Y') . '-' . strtoupper(uniqid());
        } while (self::where('order_number', $orderNumber)->exists());
        
        return $orderNumber;
    }

    // Get full shipping address
    public function getShippingAddressAttribute()
    {
        return [
            'first_name' => $this->shipping_first_name,
            'last_name' => $this->shipping_last_name,
            'company' => $this->shipping_company,
            'address_1' => $this->shipping_address_1,
            'address_2' => $this->shipping_address_2,
            'city' => $this->shipping_city,
            'state' => $this->shipping_state,
            'postcode' => $this->shipping_postcode,
            'country' => $this->shipping_country,
            'phone' => $this->shipping_phone,
        ];
    }

    // Get full billing address
    public function getBillingAddressAttribute()
    {
        return [
            'first_name' => $this->billing_first_name,
            'last_name' => $this->billing_last_name,
            'company' => $this->billing_company,
            'address_1' => $this->billing_address_1,
            'address_2' => $this->billing_address_2,
            'city' => $this->billing_city,
            'state' => $this->billing_state,
            'postcode' => $this->billing_postcode,
            'country' => $this->billing_country,
            'phone' => $this->billing_phone,
        ];
    }
}
