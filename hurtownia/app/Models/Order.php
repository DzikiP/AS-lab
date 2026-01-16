<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'status_id',
        'created_by',
        'updated_by',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (Auth::check()) {
                $order->created_by = Auth::id();
                $order->updated_by = Auth::id();
            }
        });

        static::updating(function ($order) {
            if (Auth::check()) {
                $order->updated_by = Auth::id();
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price');
    }

    public function getTotalPriceAttribute(): float
    {
        return $this->products->sum(function ($product) {
            return $product->cena * $product->pivot->quantity;
        });
    }
}
