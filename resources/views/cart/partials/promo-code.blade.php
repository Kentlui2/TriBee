<div x-data="promoCode()" class="bg-white rounded-3xl p-8 border border-gray-200 shadow-sm">
    <h3 class="text-lg font-bold text-neutral-800 mb-4">Have a Promo Code?</h3>
    
    <div class="flex gap-2">
        <input type="text" x-model="code" @keyup.enter="apply()" placeholder="Enter code" 
               class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-2xl text-sm text-neutral-800 placeholder-gray-400 focus:border-orange-500 focus:ring-orange-500 transition-colors"
               :class="{ 'border-green-500 bg-green-50': success, 'border-red-500 bg-red-50': error }">
        <button @click="apply()" :disabled="loading || !code"
                class="px-6 py-3 bg-neutral-800 text-white font-medium rounded-2xl hover:bg-neutral-900 disabled:opacity-50 disabled:cursor-not-allowed text-sm transition-colors">
            <span x-show="!loading">Apply</span>
            <span x-show="loading" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Checking...
            </span>
        </button>
    </div>

    <div class="mt-2 flex flex-wrap gap-2">
        <span class="text-xs text-gray-400">Try:</span>
        <button @click="code = 'WELCOME10'; apply()" class="text-xs text-orange-500 hover:text-orange-600 font-medium">WELCOME10</button>
        <button @click="code = 'SAVE500'; apply()" class="text-xs text-orange-500 hover:text-orange-600 font-medium">SAVE500</button>
        <button @click="code = 'FLASH20'; apply()" class="text-xs text-orange-500 hover:text-orange-600 font-medium">FLASH20</button>
    </div>

    <div x-show="message" class="mt-3">
        <p x-text="message" class="text-sm font-medium" :class="{ 'text-green-600': success, 'text-red-600': error }"></p>
    </div>

    <div x-show="applied" x-transition class="mt-4 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-neutral-800 text-sm" x-text="applied.code"></p>
                    <p class="text-xs text-gray-600 mt-0.5" x-text="applied.description"></p>
                </div>
            </div>
            <button @click="remove()" class="text-red-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-xl transition-colors">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <script>
        function promoCode() {
            return {
                code: '', loading: false, success: false, error: false, message: '', applied: null,
                async apply() {
                    if (!this.code.trim()) return;
                    this.loading = true; this.reset();
                    try {
                        const response = await fetch('/cart/promo/apply', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ code: this.code.trim().toUpperCase() })
                        });
                        const data = await response.json();
                        if (response.ok && data.valid) {
                            this.success = true; this.message = '✓ Promo code applied!';
                            this.applied = { code: this.code.trim().toUpperCase(), description: data.description || 'Discount applied' };
                            window.dispatchEvent(new CustomEvent('promo-applied', { detail: { discount: data.discount_value, type: data.discount_type } }));
                        } else {
                            this.error = true; this.message = data.message || 'Invalid promo code';
                        }
                    } catch (error) {
                        this.error = true; this.message = 'Error applying code. Try again.';
                    } finally { this.loading = false; }
                },
                remove() { this.applied = null; this.code = ''; this.reset(); window.dispatchEvent(new CustomEvent('promo-removed')); },
                reset() { this.success = false; this.error = false; this.message = ''; }
            }
        }
    </script>
</div>