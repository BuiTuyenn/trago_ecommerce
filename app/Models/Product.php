<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'manage_stock',
        'in_stock',
        'image',
        'images',
        'weight',
        'dimensions',
        'category_id',
        'status',
        'featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock_quantity' => 'integer',
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'featured' => 'boolean',
        'images' => 'json'
    ];

    // Relationship với category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship với reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relationship với order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship với cart items
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Relationship với wishlist
    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Relationship với browse history
    public function browseHistory()
    {
        return $this->hasMany(BrowseHistory::class);
    }

    // Scope cho active products
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope cho featured products
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Scope cho in stock products
    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    // Get effective price (sale price if available, otherwise regular price)
    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    // Get average rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating');
    }

    // Get total reviews count
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    // Get images as array (safe method)
    public function getImagesArrayAttribute()
    {
        if (is_string($this->images)) {
            $decoded = json_decode($this->images, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return is_array($this->images) ? $this->images : [];
    }

    // Check if product has images
    public function hasImages()
    {
        $images = $this->images_array;
        return !empty($images);
    }

    // Get first image
    public function getFirstImageAttribute()
    {
        $images = $this->images_array;
        return !empty($images) ? $images[0] : null;
    }
}
