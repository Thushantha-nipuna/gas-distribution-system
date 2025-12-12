<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'contact',
        'address',
        'credit_limit',
        'balance',
        'price_2_8kg',
        'price_5kg',
        'price_12_5kg',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}