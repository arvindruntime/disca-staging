@extends('layouts.auth.app')

@section('content')

    <main>
        <div class="di__login_container mb-5 mx-auto">
            <div class="di__logo">
                <img src="{{ asset('images/Logo.svg') }}" alt="" class="mx-auto">
            </div>
            <form method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
                @csrf
                <input type="hidden" name="email" value="<?= $email ?>" />
                <input type="hidden" name="otp" id="otp" value="" />
                <div class="di__login-card di__forget-card mx-3">
                    <h4 class="text-center primary-color mt-0">Verification Code</h4>
                    <p class="text-xs text-center tertiary-color">
                        Enter the 6-digit confirmation code you've just received on your emaill address.
                    </p>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="col-12">
                                <span class="text-success" id="otp-success"></span>
                                <span class="text-danger" id="otp-error"></span>
                            </div>
                            <div class="di__otp inputs d-flex flex-row justify-content-center mt-2 gap-3 mx-auto">
                                <input class="text-center form-control rounded" type="text" id="digit1" name="digit1"
                                    data-next="digit2" placeholder="-" maxlength="1" onkeyup="GanrateOTP()" />
                                <input class="text-center form-control rounded" type="text" id="digit2" name="digit2"
                                    data-next="digit3" data-previous="digit1" placeholder="-" maxlength="1" onkeyup="GanrateOTP()"/>
                                <input class="text-center form-control rounded" type="text" id="digit3" name="digit3"
                                    data-next="digit4" data-previous="digit2" placeholder="-" maxlength="1" onkeyup="GanrateOTP()" />
                                <input class="text-center form-control rounded" type="text" id="digit4" name="digit4"
                                    data-next="digit5" data-previous="digit3" placeholder="-" maxlength="1" onkeyup="GanrateOTP()" />
                                <input class="text-center form-control rounded" type="text" id="digit5" name="digit5"
                                    data-next="digit6" data-previous="digit4" placeholder="-" maxlength="1" onkeyup="GanrateOTP()" />
                                <input class="text-center form-control rounded" type="text" id="digit6" name="digit6"
                                    data-previous="digit5" placeholder="-" maxlength="1" onkeyup="GanrateOTP()" />
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn w-100 text-white mt-3" onclick="VerifyCodeSubmit()">Verify Code</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>

    function GanrateOTP(){
        var otp = $("#digit1").val()+$("#digit2").val()+$("#digit3").val()+$("#digit4").val()+$("#digit5").val()+$("#digit6").val();
        $("#otp").val(otp);
    }

    function VerifyCodeSubmit () {
        $('#otp-error').text('');
        $('#otp-success').text('');

        if($("#digit1").val() == "" || $("#digit2").val() == "" || $("#digit3").val() == "" || $("#digit4").val() == "" || $("#digit5").val() == "" || $("#digit6").val() == ""){
            $('#otp-error').text('Please enter valid OTP.');
            return false
        }

        $.ajax({
            url: '{{ url('api/v1/verify_otp') }}',
            type: 'POST',
            data: $(".digit-group").serialize(),
            success: function(response) {
                if (response.status === 200) {
                    $('#otp-success').text(response.message);
                    window.location.href = response.data.reset_url;
                } else {
                    $('#otp-error').text(response.message);
                }
            },
            error: function(xhr, status, error) {}
        });
    }
</script>
