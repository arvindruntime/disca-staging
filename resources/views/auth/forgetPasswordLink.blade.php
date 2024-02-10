@extends('layouts.app')
@section('content')
<header class="header-logo">
    <div class="container-fluid">
        <div class="row">
            <div class="col"> <a class="lm-logo" href="{{config('app.url')}}/"><img src="{{ asset('assets/images/logo.svg') }}" alt=""></a>
            </div>
        </div>
    </div>
</header>
<main class="main-content" id="main">
    <section class="hero">
        <div class="hero--inner">
            <div class="container">
                <div class="row reset">
                    <div class="col col-lg-7 mx-auto">
                        <div class="login--box">
                            <div class="shape-3"> <img class="in-svg" src="{{ asset('assets/images/logo-shape.png') }}" alt="">
                            </div>
                            <div class="login-title">
                                <h2>Reset Password</h2>
                                <p class="fw-normal">We'll send you an email where you can reset your password or
                                    sign in immediately with a magic link.</p>
                            </div>
                            <div class="login-form">
                                <form action="{{ route('reset.password.post') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="hidden" name="userName" value="{{ $userName }}">
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <div class="col">
                                            <div class="form-input"> <input id="email" type="email" placeholder="Email Address" class="form-control" name="email" value="{{ $email }}" autocomplete="email" id="email" disabled readonly=true> 
                                                <span><img class="in-svg" src="{{ asset('assets/images/mail.svg')}}" alt=""></span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-input"> <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password"> 
                                                <span><img class="in-svg" src="{{ asset('assets/images/lock.svg')}}" alt=""></span>
                                                @error('password')
                                                    <div class="invalid-feedback position-absolute" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-input"> <input id="password_confirmation" type="password" placeholder="Confirm Password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="new-password">
                                                <span><img class="in-svg" src="{{ asset('assets/images/lock.svg')}}" alt=""></span>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback position-absolute" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class=""> <button class="btn btn-primary"
                                                    type="submit">Save</button></div>
                                        </div>
                                        {{--<div class="col">
                                            <div class="form-help">
                                                <p>Need Help? <a href="{{ route('contact.support') }}"> Contact Support</a></p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-privacy">
                                                <p>You agree to the <a href="{{ route('terms.conditions') }}"> PEEQ Terms </a> and <a
                                                        href="{{ route('privacy.policy') }}">Privacy Policy </a>Copyright ©2023 PEEQ.</p>
                                            </div>
                                        </div> --}}
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
