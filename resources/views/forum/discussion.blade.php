@extends('layouts.master')
@section('content')

@foreach ($forum as $value)

<div class="di__dashboard_main mt-5 pt-3">
    <div class="row">
        <div class="col-12">
            <h2 class="primary-color">
                {{ $value->board_name }}
            </h2>
            <div class="d-flex align-items-center justify-content-between di__discussion_card">
                <div class="d-flex align-items-center gap-4 flex-wrap flex-md-nowrap">
                <div class="di__discussion_img">
                    <img src="{{ asset('images/hands.jpg') }}" alt="">
                </div>
                <div class="di__discussion_text">
                    <p class="h7 mb-0 fw-smedium me-2">{!! $value->discription !!}</p>
                </div>
                </div>
                <div class="di_discussion_stats">
                <p class="basic-text tertiary-color fw-medium text-nowrap"><span class="primary-color di__width me-2 me-xl-5">Topics:</span>{{ $value->topic_count }}</p>
                <p class="basic-text tertiary-color fw-medium text-nowrap"><span class="primary-color di__width me-2 me-xl-5">Replies:</span>{{ $value->topic_reply_count }}</p>
                <p class="basic-text tertiary-color fw-medium text-nowrap"><span class="primary-color di__width me-2 me-xl-5">Freshness:</span>{{ $value->creted_date }}</p>
                <p class="basic-text tertiary-color fw-medium text-nowrap"><span class="primary-color di__width mb-0 me-2 me-xl-5">Voices:</span>{{ $value->voices }}</p>
                </div>
            </div>

            <div class="mt-4 di__discussion_table table-responsive px-xl-4">
                <table class="table align-middle text-nowrap">
                <thead>
                    <tr>
                    <th scope="col" class="fw-smedium" width="30%">Publish By</th>
                    <th scope="col" class="fw-smedium" width="38%">Topic</th>
                    <th scope="col" class="fw-smedium" width="15%">Replies</th>
                    <th scope="col" class="fw-smedium" width="17%">Since</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($value['topic_detailes'] as $topic)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                <div class="img-wrapper me-2">
                                    <img src="{{ $topic['user']['profile_image_url'] ?? asset('images/icon/table-user.png') }}" alt="" width="60" height="60"
                                    class="rounded-circle">
                                </div>
                                <div class="ps-1">
                                    <p class="fw-smedium primary-color text-xs mb-1">{{ $topic['user']['name'] }}</p>
                                    <p class="text-small fst-italic tertiary-color mb-0 lh-1">Publisher</p>
                                </div>
                                </div>
                            </td>
                            <td>
                                <div class="di__text_width">
                                <p class="color-text fw-medium text-xs mb-0">{{ $topic['title'] }}</p>
                                </div>
                            </td>
                            <td>
                                <p class="basic-text color-text fw-normal mb-0">
                                    {{ $topic['repilies'] }}
                                </p>
                            </td>
                            <td>
                                <p class="basic-text color-text fw-normal mb-0">
                                    {{ $topic['created_at'] }}
                                </p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex gap-4 align-items-center mt-3 mt-md-5 flex-wrap px-xl-4">
                <a href="{{ route('forum.user.topics', ['slug' => $value->url ]) }}" class="btn text-white lh-1 text-md">See All Topics</a>
                <a href="{{ route('forum.user.add-topic') }}" class="btn btn-bordered lh-1 text-md">Add New Topic</a>
                @if($value['is_following'])
                <a href="javascript:void(0)" class="unfollow-board text-decoration-underline primary-color fw-smedium lh-1 text-md" data-board-id="{{ $value->id }}">Unfollow The Board</a>
                @else
                <a href="javascript:void(0)" class="follow-board text-decoration-underline primary-color fw-smedium lh-1 text-md" data-board-id="{{ $value->id }}">Follow The Board</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        let _token = $("meta[name=csrf-token]").attr("content");

        $('.follow-board').click(function() {
            var url = "{{route('follow.board')}}";
            var boardId = $(this).data('board-id');

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    board_id: boardId,
                    _token: _token,
                },
                headers: {
                    "Authorization" : "Bearer {{ Auth::user()->token; }}"
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.error) {
                        return false;
                    } else if (data.status == "200") {

                    }
                    window.location.reload();
                }
            });
        });

        $('.unfollow-board').click(function() {
            var url = "{{route('unfollow.board')}}";
            var boardId = $(this).data('board-id');

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    board_id: boardId,
                    _token: _token,
                },
                headers: {
                    "Authorization" : "Bearer {{ Auth::user()->token; }}"
                },
                dataType: 'JSON',
                success: function(data) {
                    if (data.error) {
                        return false;
                    } else if (data.status == "200") {

                    }
                    window.location.reload();
                }
            });
        });
    });
</script>

<div class="d-flex justify-content-end mt-3">
    {{$forum->links("pagination::bootstrap-4")}}
</div>
@endsection
