<aside class="p-3 bg-white di__dashboard-sidebar min-vh-100">
    <div class="d-flex align-items-center di__user di__user_status di__user_status--live">
        <a href="#" class="d-block">
            <div class="d-flex align-items-center text-decoration-none ms-3 ">
                <div class="img-wrapper me-2">
                    <img src="{{ isset(auth()->user()->profile_image_url) ? auth()->user()->profile_image_url : asset('images/icon/user_img.png') }}"
                        alt="" width="55" height="55" class="rounded-circle bg-primary">
                </div>
                <p class="mb-0 tertiary-color">
                    <strong>{{ auth()->user()->name }}</strong>
                </p>
            </div>
        </a>
    </div>
    @if (request()->is('forum/*'))
        @include('layouts.sidebar.menu.forum-link')
    @elseif (request()->is('admin/*'))
        @include('layouts.sidebar.menu.admin-link')
    @endif
    <hr class="bg-grey opacity-100">
    <div class="d-flex align-items-center justify-content-center gap-3 mt-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn di__sidebar-btn text-xs fw-medium lh-base">Logout</button>
        </form>
        @if(auth()->user()->user_type == 1)
            <a href="{{ route('admin.profile') }}" class="btn di__sidebar-btn text-xs fw-medium lh-base"><img
                    src="{{ asset('images/icon/border-user.svg') }}" alt="" height="15" width="15"
                    class="me-1">Account</a>
        @elseif(auth()->user()->user_type == 3)
            <a href="{{ route('forum.profile') }}" class="btn di__sidebar-btn text-xs fw-medium lh-base"><img
                src="{{ asset('images/icon/border-user.svg') }}" alt="" height="15" width="15"
                class="me-1">Account</a>
        @endif
    </div>
</aside>
