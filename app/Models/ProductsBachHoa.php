<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProductsBachHoa extends Model
{
    use HasFactory;

    protected $table = 'products_bach_hoa';

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
        'weight_volume',
        'packaging_type',
        'expiry_date',
        'manufacturing_date',
        'origin_country',
        'ingredients',
        'nutrition_facts',
        'allergen_info',
        'organic',
        'gluten_free',
        'vegan',
        'halal',
        'storage_instructions',
        'scent',
        'usage_instructions',
        'antibacterial',
        'eco_friendly',
        'pieces_per_pack',
        'bulk_available',
        'bulk_price',
        'min_order_quantity',
        'category_id',
        'certifications',
        'refrigerated',
        'frozen',
        'temperature_storage',
        'images',
        'status',
        'featured',
        'bestseller',
        'daily_essential',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'bulk_price' => 'decimal:2',
        'expiry_date' => 'date',
        'manufacturing_date' => 'date',
        'ingredients' => 'array',
        'nutrition_facts' => 'array',
        'allergen_info' => 'array',
        'usage_instructions' => 'array',
        'certifications' => 'array',
        'images' => 'array',
        'organic' => 'boolean',
        'gluten_free' => 'boolean',
        'vegan' => 'boolean',
        'halal' => 'boolean',
        'antibacterial' => 'boolean',
        'eco_friendly' => 'boolean',
        'bulk_available' => 'boolean',
        'refrigerated' => 'boolean',
        'frozen' => 'boolean',
        'featured' => 'boolean',
        'bestseller' => 'boolean',
        'daily_essential' => 'boolean',
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
        return is_array($images) && count($images) > 0 ? $images[0] : '/images/placeholder-grocery.jpg';
    }

    public function getDaysToExpiryAttribute()
    {
        if (!$this->expiry_date) return null;
        return Carbon::now()->diffInDays($this->expiry_date, false);
    }

    public function getExpiryStatusAttribute()
    {
        $days = $this->days_to_expiry;
        if ($days === null) return 'no_expiry';
        if ($days <= 0) return 'expired';
        if ($days <= 7) return 'expiring_soon';
        if ($days <= 30) return 'expires_this_month';
        return 'fresh';
    }

    public function getWeightVolumeDisplayAttribute()
    {
        return $this->weight_volume ?: 'N/A';
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

    public function scopeDailyEssential($query)
    {
        return $query->where('daily_essential', true);
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    public function scopeByProductType($query, $type)
    {
        return $query->where('product_type', $type);
    }

    public function scopeByCategoryType($query, $type)
    {
        return $query->where('category_type', $type);
    }

    public function scopeOrganic($query)
    {
        return $query->where('organic', true);
    }

    public function scopeVegan($query)
    {
        return $query->where('vegan', true);
    }

    public function scopeGlutenFree($query)
    {
        return $query->where('gluten_free', true);
    }

    public function scopeHalal($query)
    {
        return $query->where('halal', true);
    }

    public function scopeRefrigerated($query)
    {
        return $query->where('refrigerated', true);
    }

    public function scopeFrozen($query)
    {
        return $query->where('frozen', true);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>', Carbon::now());
        });
    }

    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->whereBetween('expiry_date', [Carbon::now(), Carbon::now()->addDays($days)]);
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

    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date < Carbon::now();
    }

    public function isExpiringSoon($days = 7)
    {
        if (!$this->expiry_date) return false;
        return $this->expiry_date <= Carbon::now()->addDays($days);
    }

    public function requiresRefrigeration()
    {
        return $this->refrigerated || $this->frozen;
    }

    public function isBulkAvailable()
    {
        return $this->bulk_available && $this->bulk_price;
    }

    public function getBulkSavings()
    {
        if (!$this->isBulkAvailable()) return 0;
        return $this->price - $this->bulk_price;
    }

    public function hasAllergen($allergen)
    {
        return in_array($allergen, $this->allergen_info ?? []);
    }

    public function hasCertification($cert)
    {
        return in_array($cert, $this->certifications ?? []);
    }
}