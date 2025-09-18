<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationship với parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship với child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relationship với products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scope cho active categories
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope cho parent categories (top level)
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }
}
