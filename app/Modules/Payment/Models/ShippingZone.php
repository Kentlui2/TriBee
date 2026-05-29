<?php

declare(strict_types=1);

namespace App\Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $table = 'shipping_zones';
    
    protected $fillable = [
        'zone_name',
        'zip_code_pattern',
        'flat_rate',
        'estimated_days',
    ];

    protected $casts = [
        'flat_rate' => 'decimal:2',
        'estimated_days' => 'integer',
    ];
}