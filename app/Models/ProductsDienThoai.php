<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsDienThoai extends Model
{
    use HasFactory;

    protected $table = 'products_dien_thoai';

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
        'model',
        'device_type',
        'operating_system',
        'os_version',
        'screen_size',
        'screen_resolution',
        'screen_technology',
        'refresh_rate',
        'brightness_nits',
        'hdr_support',
        'processor',
        'gpu',
        'ram_gb',
        'storage_options',
        'storage_gb',
        'expandable_storage',
        'storage_type',
        'rear_cameras',
        'front_camera_mp',
        'camera_features',
        'video_recording_4k',
        'video_recording_fps',
        'battery_capacity_mah',
        'charging_speed',
        'wireless_charging',
        'reverse_charging',
        'charging_port',
        'network_support',
        'dual_sim',
        'esim_support',
        'wifi_6',
        'bluetooth',
        'bluetooth_version',
        'nfc',
        'infrared',
        'biometric_features',
        'face_unlock',
        'fingerprint_scanner',
        'fingerprint_location',
        'dimensions',
        'weight_grams',
        'build_material',
        'color',
        'available_colors',
        'water_resistance',
        'headphone_jack',
        'speakers',
        'noise_cancellation',
        'sensors',
        'special_features',
        'gaming_mode',
        'cooling_system',
        'category_id',
        'warranty_months',
        'warranty_type',
        'origin_country',
        'condition',
        'release_date',
        'unlocked',
        'compatible_carriers',
        'box_contents',
        'charger_included',
        'earphones_included',
        'images',
        'videos',
        'user_manual',
        'comparison_charts',
        'status',
        'featured',
        'bestseller',
        'new_arrival',
        'limited_edition',
        'flagship',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'screen_size' => 'decimal:1',
        'weight_grams' => 'decimal:1',
        'storage_options' => 'array',
        'rear_cameras' => 'array',
        'camera_features' => 'array',
        'network_support' => 'array',
        'biometric_features' => 'array',
        'available_colors' => 'array',
        'speakers' => 'array',
        'sensors' => 'array',
        'special_features' => 'array',
        'compatible_carriers' => 'array',
        'box_contents' => 'array',
        'images' => 'array',
        'videos' => 'array',
        'comparison_charts' => 'array',
        'hdr_support' => 'boolean',
        'expandable_storage' => 'boolean',
        'video_recording_4k' => 'boolean',
        'wireless_charging' => 'boolean',
        'reverse_charging' => 'boolean',
        'dual_sim' => 'boolean',
        'esim_support' => 'boolean',
        'wifi_6' => 'boolean',
        'bluetooth' => 'boolean',
        'nfc' => 'boolean',
        'infrared' => 'boolean',
        'face_unlock' => 'boolean',
        'fingerprint_scanner' => 'boolean',
        'headphone_jack' => 'boolean',
        'noise_cancellation' => 'boolean',
        'gaming_mode' => 'boolean',
        'unlocked' => 'boolean',
        'charger_included' => 'boolean',
        'earphones_included' => 'boolean',
        'featured' => 'boolean',
        'bestseller' => 'boolean',
        'new_arrival' => 'boolean',
        'limited_edition' => 'boolean',
        'flagship' => 'boolean',
        'release_date' => 'date',
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
        return is_array($images) && count($images) > 0 ? $images[0] : '/images/placeholder-phone.jpg';
    }

    public function getStorageDisplayAttribute()
    {
        return $this->storage_gb . 'GB';
    }

    public function getRamDisplayAttribute()
    {
        return $this->ram_gb . 'GB RAM';
    }

    public function getScreenDisplayAttribute()
    {
        return $this->screen_size . '" ' . $this->screen_technology;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByBrand($query, $brand)
    {
        return $query->where('brand', $brand);
    }

    public function scopeByDeviceType($query, $type)
    {
        return $query->where('device_type', $type);
    }

    public function scopeByOS($query, $os)
    {
        return $query->where('operating_system', $os);
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeByRAM($query, $ram)
    {
        return $query->where('ram_gb', $ram);
    }

    public function scopeByStorage($query, $storage)
    {
        return $query->where('storage_gb', $storage);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeFlagship($query)
    {
        return $query->where('flagship', true);
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

    public function has5G()
    {
        return in_array('5G', $this->network_support ?? []);
    }

    public function hasWirelessCharging()
    {
        return $this->wireless_charging;
    }

    public function hasHeadphoneJack()
    {
        return $this->headphone_jack;
    }
}