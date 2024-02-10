<div class="di__header">
    <div class="di__toogle-sidebar d-lg-none">
    <p class="text-small mb-0 text-white fw-medium">MENU</p>
    </div>
    <div class="di__dashboard_search d-none d-lg-block">
    <input class="form-control" id="di-search" type="search" aria-label="Search" placeholder="Search">
    </div>
    <div class="di__dashboard_logo">
    @if(auth()->check() && auth()->user()->user_type == 1)
        <img src="{{ asset('images/Logo.svg') }}" alt="" width="156">
    @elseif(auth()->check() && auth()->user()->user_type == 3)
        <img src="{{ asset('images/infra-logo.svg') }}" alt="" width="156">
    @endif
    </div>
    <div class="d-flex align-items-center gap-3">
    <div class="position-relative">
        <div class="p-2 rounded rounded-circle bg-opacity-75 bg-light cursor-pointer di-search_icon d-lg-none ">
        <img src="{{ asset('images/icon/search.svg') }}" alt="">
        </div>
        <div class="di__dashboard_search di__dashboard_search--mobile d-none">
        <input class="form-control" id="di-search" type="search" aria-label="Search" placeholder="Search">
        </div>
    </div>
    <div class="di__notification di__notification--new">
        <img src="{{ asset('images/icon/Notification.svg') }}" alt="" class="cursor-pointer">
        <div class="di__notification_pannel">
        <div class="di__notification_heder d-flex align-items-end justify-content-between">
            <p class="text-md mb-0 flex-grow-1">Notification</p>
            <div class="close me-2"><img src="{{ asset('images/icon/close.svg') }}" alt=""></div>
        </div>
        <div class="di__notification_content">
            <div class="di__notification_message di__notification_message--new d-flex align-items-center">
            <div class="di__notification_image me-3 w-auto">
                <img src="{{ asset('images/icon/user_img.png') }}" alt="" width="48" height="48"
                class="rounded-circle bg-primary">
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
                <img src="{{ asset('images/icon/user_img.png') }}" alt="" width="48" height="48"
                class="rounded-circle bg-primary">
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
</div>
