<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'delivery_route_id',
        'order_number',
        'total_amount',
        'status',
        'is_urgent',
        'order_date',
    ];

    protected $casts = [
        'order_date' => 'date',
        'is_urgent' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deliveryRoute()
    {
        return $this->belongsTo(DeliveryRoute::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}