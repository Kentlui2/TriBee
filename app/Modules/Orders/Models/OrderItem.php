<?php

declare(strict_types=1);

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'price', 'quantity', 'subtotal'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}