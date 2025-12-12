<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',
        'driver_name',
        'assistant_name',
        'route_date',
        'planned_start_time',
        'actual_start_time',
        'planned_end_time',
        'actual_end_time',
    ];

    protected $casts = [
        'route_date' => 'date',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}