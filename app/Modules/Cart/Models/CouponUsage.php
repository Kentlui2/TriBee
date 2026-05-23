<?php

declare(strict_types=1);

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponUsage extends Model
{
    protected $table = 'coupon_usages';

    protected $fillable = ['coupon_id', 'user_id', 'order_id', 'discount_amount'];

    protected $casts = ['discount_amount' => 'decimal:2'];

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Auth\Models\User::class);
    }
}