<div class="modal fade" id="pinModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter PIN</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pinForm">
                    @csrf
                    <div class="form-group">
                        <label>Enter your 6-digit PIN</label>
                        <input type="password" 
                               class="form-control" 
                               name="pin" 
                               maxlength="6" 
                               pattern="\d{6}"
                               required>
                    </div>
                    <button type="submit" class="btn btn-primary">Verify PIN</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#pinForm').on('submit', function(e) {
    e.preventDefault();
    const pin = $('input[name="pin"]').val();
    
    // Store PIN temporarily or send to backend to generate OTP
    $.post('/generate-otp', { pin: pin, _token: '{{ csrf_token() }}' })
        .done(function() {
            $('#pinModal').modal('hide');
            $('#otpModal').modal('show');
        })
        .fail(function() {
            alert('Invalid PIN');
        });
});
</script>