@extends('layouts.auth.app')

@section('content')
    <main>
        <div class="di__login_container mb-5 mx-auto">
            <div class="di__logo">
                <img src="{{ asset('images/Logo.svg') }}" alt="" class="mx-auto">
            </div>
            <form method="POST" id="forgot_password_form">
                @csrf
                <div class="di__login-card di__forget-card mx-3">
                    <h4 class="text-center primary-color mt-0">
                        Forgot Password
                    </h4>
                    <div class="row g-4">
                        <div class="col-12">
                            <span class="text-success" id="email-success"></span>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label mb-2">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="" aria-label="email"
                                id="email" required>
                            <span class="text-danger" id="email-error"></span>
                        </div>
                        <div class="col-12">
                            <button type="button" id="forgot_password" class="btn w-100 text-white mt-3">Continue</button>
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
<script>

    $(document).ready(function() {
        $(document).on('click', '#forgot_password', function() {
            if($("#email").val() == ""){
                $('#email-error').text("Please enter email address");
                return false;
            }
            $("#email-error").html('');
            if ($('#email').val() != '') {
                $.ajax({
                    url: '{{ route('forget.password.post') }}',
                    type: 'POST',
                    data: $("#forgot_password_form").serialize(),
                    success: function(response) {
                        if (response.status === 200) {
                            $('#email-success').text(response.message);
                            window.location.href = "{{ route('verifyOtp')}}";
                        } else {
                            $('#email-error').text(response.message);
                        }
                    },
                    error: function(xhr, status, error) {}
                });
            }
        });
    });
</script>
