<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsThiTrangNam extends Model
{
    use HasFactory;

    protected $table = 'products_thoi_trang_nam';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'brand',
        'product_type',
        'category_type',
        'style',
        'season',
        'available_sizes',
        'fit_type',
        'size_guide',
        'materials',
        'primary_material',
        'care_instructions',
        'machine_washable',
        'color',
        'available_colors',
        'pattern',
        'neckline',
        'sleeve_type',
        'closure_type',
        'pockets',
        'special_features',
        'category_id',
        'occasions',
        'dress_code',
        'images',
        'status',
        'featured',
        'bestseller',
        'new_arrival',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'available_sizes' => 'array',
        'materials' => 'array',
        'available_colors' => 'array',
        'special_features' => 'array',
        'occasions' => 'array',
        'images' => 'array',
        'machine_washable' => 'boolean',
        'pockets' => 'boolean',
        'featured' => 'boolean',
        'bestseller' => 'boolean',
        'new_arrival' => 'boolean',
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

    public function getMainImageAttribute()
    {
        $images = $this->images;
        return is_array($images) && count($images) > 0 ? $images[0] : '/images/placeholder-fashion-men.jpg';
    }

    public function getSizeListAttribute()
    {
        return is_array($this->available_sizes) ? implode(', ', $this->available_sizes) : '';
    }

    public function getColorListAttribute()
    {
        return is_array($this->available_colors) ? implode(', ', $this->available_colors) : '';
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

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    public function scopeByProductType($query, $type)
    {
        return $query->where('product_type', $type);
    }

    public function scopeBySeason($query, $season)
    {
        return $query->where('season', $season);
    }

    public function scopeBySize($query, $size)
    {
        return $query->whereJsonContains('available_sizes', $size);
    }

    public function scopeByColor($query, $color)
    {
        return $query->where('color', $color);
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

    public function hasSize($size)
    {
        return in_array($size, $this->available_sizes ?? []);
    }

    public function hasColor($color)
    {
        return in_array($color, $this->available_colors ?? []);
    }

    public function isMachineWashable()
    {
        return $this->machine_washable;
    }

    public function hasPockets()
    {
        return $this->pockets;
    }
}