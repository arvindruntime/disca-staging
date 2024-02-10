@extends('layouts.app')

@section('content')

<main class="main-content" id="main">
    <section class="section di__form-section">
        <div class="container">
            <div class="di__bg_section overlay-bg" style="background: url({{ asset('images/professional-reg.jpg') }}) center 54%/cover no-repeat;">
                <div class="position-relative">
                    <h1 class="color-light m0">
                        Professionals Registrarion
                    </h1>
                </div>
            </div>
            <div class="di__form__wrapper mb-5 pb-0 pb-md-5">
                <form id="RegisterForm">
                    @csrf
                    <input type="hidden" name="account_type" id="account_type" value="1" />
                    <div class="di__form_heading">
                        <h5 class="mb-0 text-black">Please fill out the following details:</h5>
                    </div>
                    <div class="di__form">
                        <div class="row gy-3 gy-md-4 gx-5">
                            <div class="col-12 m-0">
                                <span class="text-success" id="register-success"></span>
                                <span class="text-error" id="register-error"></span>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="account-apply" class="form-label">Account Apply For*</label>
                                <select id="account-apply di__select" class="form-select di__select" name="user_type">
                                    <!--<option value="2">Provider</option>
                                    <option>Provider & Forum</option>-->
                                    <option value="3">Forum</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">Name*</label>
                                <input type="text" class="form-control" placeholder="Name" aria-label="name" id="name" name="name">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="company" class="form-label">Name of Company Lead*</label>
                                <input type="text" class="form-control" placeholder="Company Lead Name" aria-label="company" id="company" name="company_lead">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="organization" class="form-label">Organisation*</label>
                                <input type="text" class="form-control" placeholder="Organisation Name" aria-label="Organisation" id="Organisation" name="organization">
                            </div>
                            <div class="col-12">
                                <div class="row gy-3 gy-md-4 gx-5 align-items-end">
                                    <div class="col-12 col-md-6">
                                        <label for="inputaddress" class="form-label">Contact Address*</label>
                                        <input type="text" class="form-control" placeholder="Street" aria-label="Street" id="Street" name="street">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control" placeholder="City/Town" aria-label="City" id="City" name="city">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select id="" data-placeholder="Please select a country" class="form-select di__select" name="country_id">
                                            <option></option>   
                                            @foreach ($countries as $key => $value )
                                                <option value="{{ $value->dial_code }}">{{ $value->country_name }}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" class="form-control" placeholder="Post Code" aria-label="post_code" id="post_code" name="post_code">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control" placeholder="Email" aria-label="email" id="email" name="email">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label">Phone*</label>
                                <div class="row gy-4 gx-3">
                                    <div class="col di__telephone">
                                        <select id="phone" class="form-select di__telephone--select" name="phone_dial_code">
                                            <option value="{{ $value->dial_code=+44}}" selected>{{ $value->country_code='GB'." ".$value->dial_code=+44}}</option>
                                            @foreach ($countries as $key => $value )    
                                                <option value="{{ $value->dial_code }}">{{ $value->country_code." ".$value->dial_code }}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="123466899" aria-label="Telephone" id="telephone" name="phone_no">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="mobile" class="form-label">Mobile Number*</label>
                                <div class="row gy-4 gx-3">
                                    <div class="col di__telephone">
                                        <select id="mobiler" class="form-select di__telephone--select" name="dial_code">
                                            <option value="{{ $value->dial_code=+44}}" selected>{{ $value->country_code='GB'." ".$value->dial_code=+44}}</option>
                                            @foreach ($countries as $key => $value )
                                                <option value="{{ $value->dial_code }}">{{ $value->country_code." ".$value->dial_code }}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" placeholder="123466899" aria-label="Mobile Number" id="mobile-number" name="mobile_no">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="website" class="form-label">Website*</label>
                                <input type="url" class="form-control" placeholder="Website" aria-label="Website" id="website" name="website">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label mb-2">Password*</label>
                                <span class="position-relative">
                                    <input type="password" class="form-control password" placeholder="" aria-label="password" id="password" name="password">
                                    <div class="di__password_toggle">
                                        <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                                        <img src="{{ asset('images/icon/pass-view.svg') }}" alt="" class="di__password_hide">
                                    </div>
                                </span>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label mb-2">Confirm Password*</label>
                                <span class="position-relative">
                                    <input type="password" class="form-control password" placeholder="" aria-label="password_confirmation" id="password_confirmation" name="password_confirmation">
                                    <div class="di__password_toggle">
                                        <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                                        <img src="{{ asset('images/icon/pass-view.svg') }}" alt="" class="di__password_hide">
                                    </div>
                                </span>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="website" class="form-label">Which part of the Sector do you represents*</label>
                                <input type="text" class="form-control" placeholder="Sector" aria-label="sector" id="sector" name="sectore">
                            </div>
                        </div>
                    </div>
                    <div class="di__form">
                        <div class="row gy-3 gy-md-4 gx-5">
                            <div class="col-12 mt-5">
                                <input class="form-check-input mb-1" type="checkbox" value="1" id="tnc-checkbox" name="terms_and_condition">
                                <label class="form-check-label tertiary-color text mb-1" for="tnc-checkbox">
                                    Data sharing agreement and terms and conditions digital sign off
                                </label>
                                <p class="tertiary-color">(care home process – description or care required and start date of care required- in hospital y/n, number of rooms required)</p>
                            </div>
                            <div class="col-12">
                                <button type="button" id="RegisterBtn" class="btn text-white" >Register</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>


@endsection
