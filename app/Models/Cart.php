<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    // Relationship với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship với cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Get total items count
    public function getTotalItemsAttribute()
    {
        return $this->cartItems->sum('quantity');
    }

    // Get total price
    public function getTotalPriceAttribute()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }

    // Check if cart is expired
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    // Get or create cart for user/session
    public static function getOrCreate($userId = null, $sessionId = null)
    {
        $query = self::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }
        
        $cart = $query->first();
        
        if (!$cart) {
            $cart = self::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'expires_at' => now()->addDays(30)
            ]);
        }
        
        return $cart;
    }
}
