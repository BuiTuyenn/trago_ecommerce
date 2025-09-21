<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    // Relationship với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship với product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scope để lấy wishlist của user
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Check if product is in user's wishlist
    public static function isInWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->exists();
    }

    // Add product to wishlist
    public static function addToWishlist($userId, $productId)
    {
        return self::firstOrCreate([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
    }

    // Remove product from wishlist
    public static function removeFromWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->delete();
    }
}