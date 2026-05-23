<?php

declare(strict_types=1);

namespace App\Modules\Cart\Services;

use App\Modules\Cart\Models\Coupon;
use Illuminate\Support\Facades\Cache;

class PromoCodeService
{
    private const CACHE_PREFIX = 'promo:';
    private const CACHE_TTL = 300;

    public function validate(string $code): ?array
    {
        $key = self::CACHE_PREFIX . strtoupper($code);

        return Cache::remember($key, self::CACHE_TTL, function () use ($code) {
            $coupon = Coupon::where('code', strtoupper($code))->first();

            if (!$coupon || !$coupon->isValid()) {
                return null;
            }

            return [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'description' => $coupon->description,
                'type' => $coupon->type,
                'value' => (float) $coupon->value,
                'min_order_amount' => (float) $coupon->min_order_amount,
                'max_discount_amount' => $coupon->max_discount_amount ? (float) $coupon->max_discount_amount : null,
            ];
        });
    }

    public function canApply(string $code, int $userId, float $orderAmount): array
{
    $coupon = Coupon::where('code', strtoupper($code))->first();

    if (!$coupon) {
        return ['valid' => false, 'message' => 'Invalid promo code.'];
    }
    if (!$coupon->is_active) {
        return ['valid' => false, 'message' => 'This code is no longer active.'];
    }
    if ($coupon->starts_at && $coupon->starts_at->isFuture()) {
        return ['valid' => false, 'message' => 'This code is not yet valid.'];
    }
    if ($coupon->expires_at && $coupon->expires_at->isPast()) {
        return ['valid' => false, 'message' => 'This code has expired.'];
    }
    if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
        return ['valid' => false, 'message' => 'This code has reached its usage limit.'];
    }
    if (!$coupon->meetsMinOrder($orderAmount)) {
        return [
            'valid' => false, 
            'message' => 'Minimum order of ₱' . number_format((float) $coupon->min_order_amount, 2) . ' required. Your order: ₱' . number_format($orderAmount, 2)
        ];
    }
    if (!$coupon->canBeUsedBy($userId)) {
        return ['valid' => false, 'message' => 'You have already used this code.'];
    }

    return [
        'valid' => true,
        'discount_type' => $coupon->type,
        'discount_value' => (float) $coupon->value,
        'description' => $coupon->description,
        'message' => 'Promo code applied!',
    ];
}

    public function recordUsage(int $couponId, int $userId, float $discountAmount, ?int $orderId = null): void
    {
        $coupon = Coupon::findOrFail($couponId);
        
        $coupon->usages()->create([
            'user_id' => $userId,
            'order_id' => $orderId,
            'discount_amount' => $discountAmount,
        ]);

        $coupon->incrementUsage();
        Cache::forget(self::CACHE_PREFIX . $coupon->code);
    }
}