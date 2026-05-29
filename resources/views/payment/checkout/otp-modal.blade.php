<div class="modal fade" id="otpModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter OTP</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="otpForm">
                    @csrf
                    <div class="form-group">
                        <label>Enter OTP sent to your email/phone</label>
                        <input type="text" 
                               class="form-control" 
                               name="otp" 
                               maxlength="6" 
                               required>
                        <small class="text-muted">OTP expires in 5 minutes</small>
                    </div>
                    <button type="submit" class="btn btn-success">Confirm Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#otpForm').on('submit', function(e) {
    e.preventDefault();
    const otp = $('input[name="otp"]').val();
    
    $.post('{{ route("checkout.process-wallet") }}', {
        order_id: {{ $order->id }},
        amount: {{ $order->total }},
        pin: sessionStorage.getItem('temp_pin'), // Retrieve stored PIN
        otp: otp,
        _token: '{{ csrf_token() }}'
    })
    .done(function(response) {
        $('#otpModal').modal('hide');
        alert('Payment successful!');
        window.location.href = '/order/confirmation';
    })
    .fail(function(response) {
        alert('Payment failed: ' + response.responseJSON.error);
    });
});
</script>