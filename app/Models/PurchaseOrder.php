<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'po_number',
        'total_amount',
        'status',
        'order_date',
    ];

    protected $casts = [
        'order_date' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(SupplierPayment::class);
    }

    public function grns()
    {
        return $this->hasMany(GRN::class);
    }

    // Cal tot paid amount
    public function totalPaid()
    {
        return $this->payments()->sum('amount');
    }

    // Cal balance due
    public function balanceDue()
    {
        return $this->total_amount - $this->totalPaid();
    }
}