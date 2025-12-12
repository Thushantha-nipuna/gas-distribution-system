<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GRNItem extends Model
{
    use HasFactory;

    protected $table = 'grn_items';

    protected $fillable = [
        'grn_id',
        'gas_type',
        'ordered_qty',
        'received_qty',
        'short_supply',
        'damaged',
    ];

    public function grn()
    {
        return $this->belongsTo(GRN::class, 'grn_id'); 
    }
}