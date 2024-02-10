<header class="header" id="main-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center di__header_inner">
            <div>
                <a href="">
                    <img src="{{ asset('images/infra-logo.svg') }}" alt="" class="in-svg">
                </a>
            </div>
            <div class="di__main-logo mr-0 me-lg-5">
                <a href="" class="d-block">
                    <img src="{{ asset('images/Logo.svg') }}" alt="">
                </a>
            </div>
            <div>
                <?php
                $isLoggedIn = auth()->check();
                $userName = $isLoggedIn ? auth()->user()->name : null;
                ?>
                @if($isLoggedIn)
                <div>
                    <span>{{ $userName }}</span>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-flex di__account">
                    <p class="m0 text-md">Logout</p>
                    <span><img src="{{ asset('images/icon/user.svg') }}" alt="" class="in-svg"></span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @else
                <a href="{{route('login')}}" class="d-flex di__account">
                    <p class="m0 text-md">Login</p>
                    <span><img src="{{ asset('images/icon/user.svg') }}" alt="" class="in-svg"></span>
                </a>
                @endif
            </div>
        </div>
    </div>
</header>