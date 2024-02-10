@extends('layouts.auth.app')

@section('content')
<main>
    <div class="di__login_container mb-5 mx-auto">
        <div class="di__logo">
            <img src="{{ asset('images/Logo.svg') }}" alt="" class="mx-auto">
        </div>
        <form action="POST" id="ResetPasswordForm">
            @csrf
            <div class="di__login-card mx-3">
                <input type="hidden" name="token" value="{{ $token ? $token : '' }}">
                <input type="hidden" name="userName" value="{{ $userName ? $userName : '' }}">
                <input type="hidden" name="email" value="{{ $email ? $email : '' }}">
                <h4 class="text-center primary-color mt-0">
                    Reset Password
                </h4>
                <div class="row g-4">
                    <div class="col-12">
                        <span class="text-success" id="reset-success"></span>
                        <span class="text-danger" id="reset-error"></span>
                    </div>
                    <div class="col-12">
                        <label for="password" class="form-label mb-2">New Password</label>
                        <span class="position-relative">
                            <input type="password" name="password" class="form-control" placeholder="" aria-label="password" id="password">
                            <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                        </span>
                        <span class="text-danger" id="password-error"></span>
                    </div>
                    <div class="col-12">
                        <label for="confirm_password" class="form-label mb-2">Confirm New Password</label>
                        <span class="position-relative">
                            <input type="password" name="confirm_password" class="form-control" placeholder="" aria-label="password" id="confirm_password">
                            <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                        </span>
                        <span class="text-danger" id="confirm-password-error"></span>
                    </div>                    
                    <div class="col-12">
                        <button type="button" id="reset_password" class="btn w-100 text-white mt-3">Reset</button>
                    </div>
                    <div class="col-12">
                        <div class="di__seperator">
                            <p class="d-inline-block m-0">
                                or
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center mb-1">
                            Remember your password?
                            <a href="{{ route('login') }}" class="primary-color fw-medium">Try Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function() {
    $(document).on('click', '#reset_password', function() {
        var email = $("input[name='email']").val();
        var username = $("input[name='userName']").val();
        var token = $("input[name='token']").val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
    
        $('#password-error').text('');
        $('#confirm-password-error').text('');

        if(password == ""){
            $('#password-error').text('Please enter password');
            return false;
        }

        if(confirm_password == ""){
            $('#confirm-password-error').text('Please enter confirm password');
            return false;
        }

        if(password != confirm_password){
            $('#confirm-password-error').text('The password confirmation does not match.');
            return false;
        }

        $.ajax({
            url: "{{ route('reset.password.post') }}",
            type: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                email: email,
                token: token,
                password: password,
                password_confirmation: confirm_password,
            },
            success: function(response) {

                if (response.status === 200) {
                    // alert(response.message);
                    // Redirect or perform any other desired action after successful password reset.
                    $('#reset-success').text(response.message);
                    window.location.href = "{{ route('login')}}";
                } else {
                    $('#reset-error').text(response.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX request errors (e.g., network issues, server errors, etc.).
                console.log(xhr, status, error);
            }
        });
    });

});
</script>