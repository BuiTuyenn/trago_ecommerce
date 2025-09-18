<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2'
    ];

    // Relationship với cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Relationship với product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Get total price for this item
    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}
