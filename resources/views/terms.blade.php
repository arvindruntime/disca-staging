@extends('layouts.app')

@section('content')
    <main class="main-content" id="main">
        <section class="section di__form-section">
            <div class="container">
                <div class="di__bg_section overlay-bg"
                    style="background: url({{ asset('images/professional-reg.jpg') }}) center 54%/cover no-repeat;">
                    <div class="position-relative">
                        <h1 class="color-light m0">
                            {{ $page->title }}
                        </h1>
                    </div>
                </div>
                <div class="di__form__wrapper mb-5 pb-0 pb-md-5">
                    <h5 class="mt-5 mb-4">Welcome to Care Bubble</h5>
                    <div class="color-text text-xs">
                        <p class="fw-medium mb-4">
                            {{ $page->title }}
                        </p>
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
