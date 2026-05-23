<div x-data="priceSummary()" x-init="init()"
     @promo-applied.window="applyPromo($event.detail)"
     @promo-removed.window="removePromo()"
     class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
    
    <h2 class="text-lg font-bold text-neutral-800 mb-6">Order Summary</h2>
    
    <div class="space-y-4">
        <div class="flex justify-between text-sm">
            <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') ?? 0 }} items)</span>
            <span class="font-semibold text-neutral-800">₱<span x-text="formatPrice(subtotal)"></span></span>
        </div>
        <div x-show="promoDiscount > 0" x-transition class="flex justify-between text-sm text-green-600">
            <span>Promo Discount</span>
            <span class="font-semibold">-₱<span x-text="formatPrice(promoDiscount)"></span></span>
        </div>
        <div x-show="subtotal >= 1000" class="flex justify-between text-sm text-blue-600">
            <span>Bulk Discount (5%)</span>
            <span class="font-semibold">-₱<span x-text="formatPrice(subtotal * 0.05)"></span></span>
        </div>
        <div class="flex justify-between text-sm">
            <span class="text-gray-600">VAT (12%)</span>
            <span class="font-semibold text-neutral-800">₱<span x-text="formatPrice(tax)"></span></span>
        </div>
        <div class="border-t-2 border-gray-100 pt-4 flex justify-between">
            <span class="text-base font-bold text-neutral-800">Total</span>
            <div class="text-right">
                <span class="text-2xl font-bold text-neutral-800">₱<span x-text="formatPrice(total)"></span></span>
                <div x-show="savings > 0" class="text-xs text-green-600 font-medium mt-1">🎉 You save ₱<span x-text="formatPrice(savings)"></span>!</div>
            </div>
        </div>
    </div>

    <div x-show="subtotal < 2000" class="mt-6">
        <div class="flex justify-between text-xs text-gray-500 mb-2">
            <span>Free shipping at ₱2,000</span>
            <span x-text="'₱' + formatPrice(2000 - subtotal) + ' to go'"></span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-2 rounded-full transition-all duration-500"
                 :style="'width: ' + Math.min((subtotal / 2000) * 100, 100) + '%'"></div>
        </div>
    </div>

    <script>
        function priceSummary() {
            return {
                subtotal: {{ $subtotal ?? 0 }}, promoDiscount: 0, tax: 0, total: 0, savings: 0,
                init() { this.calculate(); },
                calculate() {
                    const afterBulk = this.subtotal >= 1000 ? this.subtotal * 0.95 : this.subtotal;
                    const afterPromo = afterBulk - this.promoDiscount;
                    this.tax = Math.max(0, afterPromo) * 0.12;
                    this.total = Math.max(0, afterPromo + this.tax);
                    this.savings = (this.subtotal - afterBulk) + this.promoDiscount;
                },
                applyPromo(detail) {
                    this.promoDiscount = detail.type === 'percentage' ? this.subtotal * (detail.discount / 100) : Math.min(detail.discount, this.subtotal);
                    this.calculate();
                },
                removePromo() { this.promoDiscount = 0; this.calculate(); },
                formatPrice(val) { return parseFloat(val).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
            }
        }
    </script>
</div>