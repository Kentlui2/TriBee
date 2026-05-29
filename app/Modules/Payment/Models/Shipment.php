<?php

declare(strict_types=1);

namespace App\Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $table = 'shipments';
    
    protected $fillable = [
        'order_id',
        'address',
        'zip_code',
        'courier',
        'tracking_no',
        'status',
        'shipping_cost',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}