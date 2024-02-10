@extends('layouts.auth.customer.app')
<link rel="stylesheet" href="{{ asset('css/user/css/dashboard.css') }}">
@section('content')
    <div class="di__dashboard-content flex-grow-1">
        <div class="di__header">
        <div class="di__toogle-sidebar d-lg-none">
            <p class="text-small mb-0 text-white fw-medium">MENU</p>
        </div>
        <div class="di__dashboard_logo">
            <img src="{{ asset('images/Logo.svg') }}" alt="" width="156">
        </div>
        <div class="cursor-pointer. di__notification di__notification--new">
            <img src="{{ asset('images/icon/Notification.svg') }}" alt="">
            <div class="di__notification_pannel">
            <div class="di__notification_heder d-flex align-items-end justify-content-between">
                <p class="text-md mb-0 flex-grow-1">Notification</p>
                <div class="close me-2"><img src="{{ asset('images/icon/close.svg') }}" alt=""></div>
            </div>
            <div class="di__notification_content">
                <div class="di__notification_message di__notification_message--new d-flex align-items-center">
                <div class="di__notification_image me-3 w-auto">
                    <img src="{{ asset('images/icon/user_img.png') }}" alt="" width="48" height="48" class="rounded-circle bg-primary">
                </div>
                <div class="flex-grow-1">
                    <p class="di__notification_text mb-0">
                    <strong class="fw-smedium">Tom Jones</strong> reply to your comment 
                    </p>
                    <span class="di__notification_time d-block">
                    3 min ago
                    </span>
                </div>
                </div>
                <div class="di__notification_message d-flex align-items-center">
                <div class="di__notification_image me-3 w-auto">
                    <img src="{{ asset('images/icon/user_img.png') }}" alt="" width="48" height="48" class="rounded-circle bg-primary">
                </div>
                <div class="flex-grow-1">
                    <p class="di__notification_text mb-0">
                    <strong class="fw-smedium">Tom Jones</strong> reply to your comment reply to your comment
                    </p>
                    <span class="di__notification_time d-block">
                    3 min ago
                    </span>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="di__dashboard_main mt-4 pt-3">
        <div class="di__mainbox di__arror-show">
            <div class="di__main-container centralized">
            <div class="di__main-circle">
                <div class="di__inner centralized">
                <img src="{{ asset('images/icon/user_apply.svg') }}" alt="">
                </div>
            </div>
            <div class="di__bubble-container centralized blue-dark1 active" style="transform: rotate(10deg);">
                <div class="di__pointer centralized">
                <div class="di__arrow"></div>
                </div>
                <div class="di__bubble centralized addiction" style="transform: rotate(-10deg);">
                <a href="" class="di__inner centralized">
                    <p class="fw-bold">Apply<br> for Care</p>
                </a>
                </div>
            </div>
            <div class="di__bubble-container centralized blue-dark" style="transform: rotate(85deg);">
                <div class="di__pointer centralized">
                <div class="di__arrow"></div>
                </div>
                <div class="di__bubble centralized wellness" style="transform: rotate(-85deg);">
                <a href="" class="di__inner centralized">
                    <p class="fw-bold">Care Package</p>
                </a>
                </div>
            </div>
            <div class="di__bubble-container centralized black" style="transform: rotate(160deg);">
                <div class="di__pointer centralized">
                <div class="di__arrow"></div>

                </div>
                <div class="di__bubble centralized nationwide" style="transform: rotate(-160deg);">
                <a href="" class="di__inner centralized">
                    <p class="fw-bold">GP</p>
                </a>
                </div>
            </div>
            <div class="di__bubble-container centralized green" style="transform: rotate(230deg);">
                <div class="di__pointer centralized">
                <div class="di__arrow"></div>
                </div>
                <div class="di__bubble centralized national" style="transform: rotate(-230deg);">
                <a href="" class="di__inner centralized">
                    <p class="fw-bold">Pharmacy</p>
                </a>
                </div>
            </div>
            <div class="di__bubble-container centralized orange" style="transform: rotate(300deg); ">
                <div class="di__pointer centralized">
                <div class="di__arrow"></div>
                </div>
                <div class="di__bubble centralized national-services" style="transform: rotate(-300deg);">
                <a href="" class="di__inner centralized">
                    <p class="fw-bold">Power of Attorney</p>
                </a>
                </div>
            </div>
            </div>
        </div>
        <!-- end desktop -->

        <!-- mobile -->
        <div class="mobile-box">
            <div class="circle-box">
            <img src="{{ asset('images/icon/user_apply.svg')}}" alt="">
            </div>
            <div class="di__accordion">
            <a href="" class="di__accordion__header di__accordion-1 active">
                <p class="mb-0">Apply for Care</p>
            </a>
            <a href="" class="di__accordion__header di__accordion-2">
                <p class="mb-0">Care Package</p>
            </a>
            <a href="" class="di__accordion__header di__accordion-3">
                <p class="mb-0">GP</p>
            </a>
            <a href="" class="di__accordion__header di__accordion-4">
                <p class="mb-0">Pharmacy</p>
            </a>
            <a href="" class="di__accordion__header di__accordion-5">
                <p class="mb-0">Power of Attorney</p>
            </a>
            </div>
        </div>
        </div>
    </div>

@endsection