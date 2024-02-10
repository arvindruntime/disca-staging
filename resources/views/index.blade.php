@extends('layouts.app')

@section('content')
<main class="main-content" id="main">
    <section class="section di__hero_section background-cover overlay-bg" style="background-image: url({{ asset('images/hero-section.jpg') }});">
        <div class="container">
            <div class="di__hero_inner">
                <h1 class="color-light fw-regular text-center m0">
                    Applying <br>for <span class="fw-bold">Private Care Made Easier</span>
                </h1>
            </div>
        </div>
    </section>
    <section class="section di__logo_slider">
        <div class="container">
            <div class="di__swiper_logo bg-light">
                <div class="swiper logo-slider">
                    <div class="swiper-wrapper align-items-center">
                        <div class="swiper-slide">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/unicare.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/Quality_care_logo.png') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/time.png') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/Axe_Valley_Logo.png') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/care-plus.png') }}" alt="">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="img-wrapper">
                                <img src="{{ asset('images/carelogo.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-2">
        <div class="container">
            <div class="di__content-wrapper">
                <p class="h1 primary-color text-center">
                    Some Heading    
                </p>
                <p class="text-md color-text text-center">
                    Devon Integrated Social Care Alliance has been set up to support care providers in Devon to work collaboratively and support each other, share ideas, resources and create a positive culture of best practice.
                </p>
                <p class="text-md color-text text-center mb-0">
                    Skills for Care would like to show our support for this project. We believe that supporting care providers to work collaboratively in this way, will benefit and support our social care leaders, the workforce and the wider Integrated Care System in Devon. We hope this collaborative work will contribute to improving the care and the lives of the people who need care and support in Devon. To find out more about us visit Skills for Care.
                </p>
            </div>
            <div class="di__register d-flex">
                <div class="overlay-bg di__register_inner" style="background: url({{ asset('images/private-care.jpg') }}) center/cover no-repeat;">
                    <div class="relative text-center">
                        <a href="" class="h1 color-light m0">
                            Applying for <br>Private Care
                        </a>
                    </div>
                </div>
                <div class="overlay-bg di__register_inner" style="background: url({{ asset('images/professional-reg.jpg') }}) center/cover no-repeat;">
                    <div class="relative text-center">
                        <a href="{{ route('proffesional-care') }}" class="h1 color-light m0">
                            Professionals Registration
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>    
</main>
@endsection
