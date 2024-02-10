<ul class="nav nav-pills flex-column mt-3 px-1">
    <li class="nav-item">
        <a href="{{ route('admin.users') }}"
            class="nav-link mb-1 fw-medium tertiary-color {{ request()->routeIs('admin.users') ? 'active' : '' }}"
            aria-current="page">
            User Management
        </a>
    </li>
    <li class="inner-dropdown">
        <a href="javascript:void(0)"
            class="nav-link text-xs fw-medium tertiary-color mb-1 {{ Str::of(request()->getRequestUri())->whenContains("admin/forum", function (Stringable $string) {
                return 'active';
            }) }}">
            Forum
        </a>
        <span class="d-inline-block dropdown-arrow"><img src="{{ asset('images/icon/right-arrow.svg') }}" alt=""
                class="in-svg"></span>
        <ul class="ps-4">
            <li>
                <a href="{{ route('admin.forum.board') }}"
                    class="nav-link text-xs fw-medium tertiary-color mb-1 {{ request()->routeIs('admin.forum.board*') ? 'active' : '' }}">
                    Board
                </a>
            </li>
            <li>
                <a href="{{ route('admin.forum.topics') }}"
                    class="nav-link text-xs fw-medium tertiary-color mb-1 {{ request()->routeIs('admin.forum.topics*') ? 'active' : '' }}">
                    Topics
                </a>
            </li>
            <li>
                <a href="{{ route('admin.forum.comments') }}" class="nav-link text-xs fw-medium tertiary-color mb-1">
                    Comments
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a href="postcode-groups.html" class="nav-link text-xs fw-medium tertiary-color mb-1">
            Postcodes Groups
        </a>
    </li>
    <li class="inner-dropdown">
        <a href="{{ route('admin.pages') }}"
            class="nav-link text-xs fw-medium tertiary-color mb-1 {{ Str::of(request()->getRequestUri())->whenContains("admin/pages", function (Stringable $string) {
                return 'active';
            }) }}">
            Website Pages
        </a>
        <span class="d-inline-block dropdown-arrow"><img src="{{ asset('images/icon/right-arrow.svg') }}"
                alt="" class="in-svg"></span>
        <ul class="ps-4">
            @foreach ($pages as $page)
                <li>
                    <a href="{{ route('admin.pages') . '/' . $page->permalink }}"
                        class="nav-link text-xs fw-medium tertiary-color mb-1 {{ Str::of(request()->getRequestUri())->whenContains($page->permalink, function (Stringable $string) {
                            return 'active';
                        }) }}">
                        {{ $page->title }}
                    </a>
                </li>
            @endforeach
            {{-- <li>
                <a href="privacy-policy.html" class="nav-link text-xs fw-medium tertiary-color mb-1">
                    Cookies Policy
                </a>
            </li>
            <li>
                <a href="privacy-policy.html" class="nav-link text-xs fw-medium tertiary-color mb-1">
                    Terms & Conditions
                </a>
            </li> --}}
        </ul>
    </li>
    <li>
        <a href="export.html" class="nav-link text-xs fw-medium tertiary-color mb-1">
            Export
        </a>
    </li>
</ul>
