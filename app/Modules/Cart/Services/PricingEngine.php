<?php

declare(strict_types=1);

namespace App\Modules\Cart\Services;

class PricingEngine
{
    private const TAX_RATE = 0.12;
    private const BULK_THRESHOLD = 1000;
    private const BULK_DISCOUNT_RATE = 0.05;
    private const LOYALTY_DISCOUNT_RATE = 0.02;
    private const MAX_DISCOUNT_CAP = 0.30;

    /**
     * Get full pricing breakdown (called by CartController)
     */
    public function getBreakdown(
        float $subtotal,
        ?string $promoCode = null,
        bool $isLoyalCustomer = false
    ): array {
        $bulkDiscount = $this->calculateBulkDiscount($subtotal);
        $loyaltyDiscount = $this->calculateLoyaltyDiscount($subtotal, $isLoyalCustomer);
        $promoDiscount = $this->calculatePromoDiscount($subtotal, $promoCode);

        $totalDiscount = $bulkDiscount + $loyaltyDiscount + $promoDiscount;
        $maxAllowed = $subtotal * self::MAX_DISCOUNT_CAP;
        $totalDiscount = min($totalDiscount, $maxAllowed);

        $taxableAmount = $subtotal - $totalDiscount;
        $tax = $taxableAmount * self::TAX_RATE;
        $total = $taxableAmount + $tax;

        return [
            'subtotal'     => round($subtotal, 2),
            'discounts'    => [
                'bulk'    => round($bulkDiscount, 2),
                'loyalty' => round($loyaltyDiscount, 2),
                'promo'   => round($promoDiscount, 2),
                'total'   => round($totalDiscount, 2),
            ],
            'tax' => [
                'rate'   => '12%',
                'amount' => round($tax, 2),
            ],
            'total'        => round($total, 2),
            'savings'      => round($totalDiscount, 2),
            'has_discounts' => $totalDiscount > 0,
        ];
    }

    /**
     * Get total only (called by CartService)
     */
    public function calculateTotal(
        float $subtotal,
        ?string $promoCode = null,
        bool $isLoyalCustomer = false
    ): float {
        $breakdown = $this->getBreakdown($subtotal, $promoCode, $isLoyalCustomer);
        return $breakdown['total'];
    }

    /**
     * 5% discount if subtotal >= ₱1,000
     */
    public function calculateBulkDiscount(float $subtotal): float
    {
        return $subtotal >= self::BULK_THRESHOLD 
            ? round($subtotal * self::BULK_DISCOUNT_RATE, 2) 
            : 0;
    }

    /**
     * 2% loyalty discount for customers with 5+ orders
     */
    public function calculateLoyaltyDiscount(float $subtotal, bool $isLoyalCustomer): float
    {
        return $isLoyalCustomer 
            ? round($subtotal * self::LOYALTY_DISCOUNT_RATE, 2) 
            : 0;
    }

    /**
     * Promo code discount
     */
    public function calculatePromoDiscount(float $subtotal, ?string $promoCode): float
    {
        if (!$promoCode) {
            return 0;
        }

        $promoService = app(PromoCodeService::class);
        $promo = $promoService->validate($promoCode);

        if (!$promo) {
            return 0;
        }

        return match ($promo['type']) {
            'percentage' => round($subtotal * ($promo['value'] / 100), 2),
            'fixed'      => min((float) $promo['value'], $subtotal),
            default      => 0,
        };
    }

    /**
     * Calculate tax on an amount
     */
    public function calculateTax(float $amount): float
    {
        return round($amount * self::TAX_RATE, 2);
    }

    /**
     * Check if user is loyal (5+ delivered orders)
     */
    public function isLoyalCustomer(int $userId): bool
    {
        return \App\Modules\Orders\Models\Order::where('user_id', $userId)
            ->where('status', 'delivered')
            ->count() >= 5;
    }
}