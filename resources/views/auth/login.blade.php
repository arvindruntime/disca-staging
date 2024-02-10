@extends('layouts.auth.app')

@section('content')
    <main>
        <div class="di__login_container mb-5 mx-auto">
            <div class="di__logo">
                <img src="{{ asset('images/Logo.svg') }}" alt="" class="mx-auto">
            </div>
            <form id="loginForm" name="loginForm" method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                @csrf
                <div class="di__login-card mx-3">
                    <h4 class="text-center primary-color mt-0">
                        Welcome Back
                    </h4>
                    @if ($errors->has('loginError'))
                        <div class="alert alert-danger">
                            {{ $errors->first('loginError') }}
                        </div>
                    @endif
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="email" class="form-label mb-2">Email</label>
                            <input id="email" type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" autocomplete="email" autofocus=""
                                placeholder="E-mail Address">
                            <span class="text-danger" id="email-error"></span>
                            @error('email')
                                <span class="text-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label mb-2">Password</label>
                            <span class="position-relative">
                                <input id="password" type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" aria-label="password"
                                    placeholder="Password">
                                    <div class="di__password_toggle">
                                        <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                                        <img src="{{ asset('images/icon/pass-view.svg') }}" alt="" class="di__password_hide">
                                    </div>
                            </span>
                            @error('password')
                                <span class="text-danger" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                            <span class="text-danger" id="password-error"></span>
                        </div>
                        <div class="col-12 m-0">
                            <a href="{{ route('password.request') }}" class="d-inline-block text-small mt-2">Forgot your
                                password?</a>
                        </div>
                        <div class="col-12">
                            <button type="submit" id="login" class="btn w-100 text-white mt-3">Login</button>
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
                                Don't have an account?
                                <a href="{{ route('proffesional-care') }}" class="primary-color fw-medium">Register</a>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            /* Password show hide js*/
            $('.di__password_view, .di__password_hide').click(function() {
                var passwordInput = $(this).closest('.position-relative').find('#password');
                var currentType = passwordInput.attr('type');
                var newType = (currentType === 'password') ? 'text' : 'password';
                passwordInput.attr('type', newType);
            });
            $('.di__password_toggle img').click(function() {
                // Toggle the 'active' class on the parent div
                $(this).parent('.di__password_toggle').toggleClass('active');
            });
        });
    
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            submitHandler: function(form) { // ONLY FOR DEMO
                $("#loginForm").submit();
            },
        });
    </script>
@endsection

