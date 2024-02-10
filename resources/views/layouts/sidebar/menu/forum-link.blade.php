<ul class="nav nav-pills flex-column mt-3 px-1">
    <li class="nav-item">
        <a href="{{ route('forum.user.dashboard') }}"
            class="nav-link mb-1 fw-medium tertiary-color mb-1 {{ request()->routeIs('forum.user.dashboard') ? 'active' : '' }}"
            aria-current="page">
            Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('forum.user.chat') }}"
            class="nav-link mb-1 fw-medium tertiary-color mb-1 {{ request()->routeIs('forum.user.chat') ? 'active' : '' }}"
            aria-current="page">
            Live Chat
        </a>
    </li>
    <li class="inner-dropdown">
        <a href="{{ route('forum.user.discussion') }}"
            class="nav-link text-xs fw-medium tertiary-color mb-1 {{ request()->routeIs('forum.user.discussion') ? 'active' : '' }}">
            Discussion Board
        </a>
        <span class="d-inline-block dropdown-arrow"><img src="{{ asset('images/icon/right-arrow.svg') }}" alt=""
                class="in-svg"></span>
        <ul class="ps-4">
            @foreach($boardTopics as $value)
            <li>
                <a href="{{ route('forum.user.topics', ['slug' => $value->url]) }}"
                    class="nav-link text-xs fw-medium tertiary-color mb-1">
                    {{ $value->board_name }}
                </a>
            </li>
            @endforeach
        </ul>
    </li>
    <li>
        <a href="{{ route('forum.user.add-topic') }}"
            class="nav-link text-xs fw-medium tertiary-color mb-1 {{ request()->routeIs('forum.user.add-topic') ? 'active' : '' }}">
            Add new topic
        </a>
    </li>
</ul>
<hr class="bg-grey opacity-100">
<ul class="nav nav-pills flex-column mt-4 px-1">
    <li class="nav-item">
        <p class="primary-color text-xs fw-medium mb-3 ms-2 ps-1">
            Topics Following
        </p>
    </li>
    @foreach ($forumTopics as $followingTopic)
            <li>
                @if($followingTopic->topic)
                    <a href="{{ route('forum.user.topic-detail', ['id' => $followingTopic->topic_id]) }}" class="nav-link text-xs fw-medium tertiary-color mb-1">
                        {{ $followingTopic->topic->title }}
                    </a>
                @else
                    <span class="nav-link text-xs fw-medium tertiary-color mb-1">Topic Not Available</span>
                @endif
            </li>
    @endforeach
</ul>
