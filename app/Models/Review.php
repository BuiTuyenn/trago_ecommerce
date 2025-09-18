<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'rating',
        'title',
        'comment',
        'verified_purchase',
        'is_approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified_purchase' => 'boolean',
        'is_approved' => 'boolean'
    ];

    // Relationship với product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship với order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scope cho approved reviews
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope cho verified purchases
    public function scopeVerified($query)
    {
        return $query->where('verified_purchase', true);
    }

    // Scope by rating
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}
