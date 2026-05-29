<?php

namespace App\Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'address',
        'courier',
        'tracking_no',
        'status',
    ];

    // Status values: pending, shipped, delivered

    // Relationship to Order (G4's model)
    public function order()
    {
        return $this->belongsTo(
            \App\Modules\Orders\Models\Order::class
        );
    }
}