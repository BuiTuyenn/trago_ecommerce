<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsNhaCua extends Model
{
    use HasFactory;
    
    protected $table = 'products_nha_cua';
    
    protected $fillable = [
        'name',
        'brand',
        'category_id',
        'price',
        'sale_price',
        'stock_quantity',
        'description',
        'short_description',
        'primary_material',
        'materials',
        'warranty_years',
        'dimensions',
        'weight',
        'available_colors',
        'color',
        'room_type',
        'product_type',
        'images',
        'featured',
        'bestseller',
        'status',
        'slug',
        'sku',
        'assembly_required',
        'eco_friendly'
    ];
    
    protected $casts = [
        'materials' => 'array',
        'available_colors' => 'array',
        'images' => 'array',
        'featured' => 'boolean',
        'bestseller' => 'boolean',
        'assembly_required' => 'boolean',
        'eco_friendly' => 'boolean',
        'price' => 'decimal:0',
        'sale_price' => 'decimal:0'
    ];
    
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
    
    // Accessors
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }
    
    public function getFormattedSalePriceAttribute()
    {
        return $this->sale_price ? number_format($this->sale_price, 0, ',', '.') . 'đ' : null;
    }
    
    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }
}
