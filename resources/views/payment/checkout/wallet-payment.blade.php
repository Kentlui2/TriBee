@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Checkout - Wallet Payment</h4>
                </div>
                <div class="card-body">
                    <div class="order-summary mb-4">
                        <h5>Order Summary</h5>
                        <p>Order #: {{ $order->id }}</p>
                        <p>Total Amount: ₱{{ number_format($order->total, 2) }}</p>
                        <p>Wallet Balance: ₱{{ number_format($wallet->balance ?? 0, 2) }}</p>
                    </div>

                    @if(($wallet->balance ?? 0) >= $order->total)
                        <div class="payment-options">
                            <button class="btn btn-primary" id="payWithWalletBtn">
                                Pay with Wallet
                            </button>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            Insufficient balance. Please top up your wallet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include modals -->
@include('payment.checkout.pin-modal')
@include('payment.checkout.otp-modal')

<script>
document.getElementById('payWithWalletBtn')?.addEventListener('click', function() {
    // Show PIN modal first
    $('#pinModal').modal('show');
});
</script>
@endsection