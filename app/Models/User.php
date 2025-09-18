<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'avatar',
        'password',
        'role',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime'
    ];

    // Relationship với orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relationship với carts
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relationship với reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scope cho active users
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope cho customers
    public function scopeCustomers($query)
    {
        return $query->where('role', 'customer');
    }

    // Scope cho admins
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    // Get full name
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name) ?: $this->name;
    }
}
