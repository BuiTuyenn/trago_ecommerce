<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BrowseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_name',
        'product_slug',
        'product_price',
        'product_image',
        'view_count',
        'last_viewed_at'
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'view_count' => 'integer',
        'last_viewed_at' => 'datetime'
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

    // Scope để lấy history của user
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope để lấy history của session
    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    // Record product view
    public static function recordView(Product $product)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $history = self::where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->where('product_id', $product->id)
            ->first();

        if ($history) {
            // Update existing record
            $history->update([
                'view_count' => $history->view_count + 1,
                'last_viewed_at' => now()
            ]);
        } else {
            // Create new record
            self::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'product_price' => $product->effective_price,
                'product_image' => $product->image,
                'view_count' => 1,
                'last_viewed_at' => now()
            ]);
        }
    }

    // Get recent browsed products
    public static function getRecentProducts($limit = 10)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $query = self::with('product')
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->orderBy('last_viewed_at', 'desc')
            ->limit($limit);

        return $query->get();
    }

    // Clean old history (older than 30 days)
    public static function cleanOldHistory()
    {
        self::where('last_viewed_at', '<', now()->subDays(30))->delete();
    }
}