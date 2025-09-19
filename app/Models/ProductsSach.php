<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsSach extends Model
{
    use HasFactory;

    protected $table = 'products_sach';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'isbn',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'author',
        'translator',
        'publisher',
        'publication_date',
        'language',
        'pages',
        'format',
        'dimensions',
        'weight',
        'category_id',
        'genres',
        'series',
        'volume',
        'age_rating',
        'keywords',
        'images',
        'preview_pdf',
        'audio_sample',
        'status',
        'featured',
        'bestseller',
        'new_release',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'genres' => 'array',
        'keywords' => 'array',
        'images' => 'array',
        'featured' => 'boolean',
        'bestseller' => 'boolean',
        'new_release' => 'boolean',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' VNĐ';
    }

    public function getSalePriceAttribute($value)
    {
        return $value ? number_format($value, 0, ',', '.') . ' VNĐ' : null;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getMainImageAttribute()
    {
        $images = $this->images;
        return is_array($images) && count($images) > 0 ? $images[0] : '/images/placeholder-book.jpg';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('bestseller', true);
    }

    public function scopeNewRelease($query)
    {
        return $query->where('new_release', true);
    }

    public function scopeByAuthor($query, $author)
    {
        return $query->where('author', 'like', '%' . $author . '%');
    }

    public function scopeByPublisher($query, $publisher)
    {
        return $query->where('publisher', 'like', '%' . $publisher . '%');
    }

    public function scopeByGenre($query, $genre)
    {
        return $query->whereJsonContains('genres', $genre);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    // Methods
    public function isInStock()
    {
        return $this->stock_quantity > 0;
    }

    public function isOnSale()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    public function getEffectivePrice()
    {
        return $this->isOnSale() ? $this->sale_price : $this->price;
    }

    public function decreaseStock($quantity = 1)
    {
        if ($this->stock_quantity >= $quantity) {
            $this->decrement('stock_quantity', $quantity);
            return true;
        }
        return false;
    }

    public function increaseStock($quantity = 1)
    {
        $this->increment('stock_quantity', $quantity);
    }
}