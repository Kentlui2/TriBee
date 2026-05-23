<?php

declare(strict_types=1);

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'type', 'value',
        'min_order_amount', 'max_discount_amount',
        'usage_limit', 'used_count', 'per_user_limit',
        'starts_at', 'expires_at', 'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && $this->starts_at->isFuture()) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    public function canBeUsedBy(int $userId): bool
    {
        $count = $this->usages()->where('user_id', $userId)->count();
        return $count < $this->per_user_limit;
    }

    public function meetsMinOrder(float $amount): bool
{
    return $amount >= (float) $this->min_order_amount;
}

public function calculateDiscount(float $subtotal): float
{
    $discount = match ($this->type) {
        'percentage' => $subtotal * ((float) $this->value / 100),
        'fixed' => (float) $this->value,
        default => 0,
    };

    if ($this->max_discount_amount) {
        $discount = min($discount, (float) $this->max_discount_amount);
    }

    return min($discount, $subtotal);
}

    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }
}