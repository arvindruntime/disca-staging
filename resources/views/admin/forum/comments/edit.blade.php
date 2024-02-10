@extends('layouts.master')

@section('content')
    <div class="di__dashboard_main mt-5 pt-3">
        <div class="di__forum_add_topic">
            <div class="row gy-4">
                <div class="col-12">
                    <h5 class="mb-0">
                        Edit Comments
                    </h5>
                </div>
                {{-- @dd($comment) --}}
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <div class="img-wrapper me-2">
                            <img src="{{ isset($comment->user->profile_image_url) ? $comment->user->profile_image_url : asset('/images/icon/user_img.png') }}"
                                alt="" width="68" height="68" class="rounded-circle bg-primary">
                        </div>
                        <div>
                            <p class="fw-smedium mb-0 h5">{{ $comment->user->name }}</p>
                            <p class="basic-text primary-color mb-0 lh-base">{{ $comment->user->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row gy-0 gy-lg-2">
                        <div class="col-auto col-lg-1">
                            <p class="fw-normal di__comment-width lh-base text-md mb-0">
                                Topic:
                            </p>
                        </div>
                        <div class="col-11">
                            <p class=" lh-base mb-0 text-md fw-smedium">
                                {{ $comment->topic->title }}
                            </p>
                        </div>
                        <div class="col-auto col-lg-1">
                            <p class="fw-normal di__comment-width lh-base text-md mb-0 mt-2 mt-lg-0">
                                Board:
                            </p>
                        </div>
                        <div class="col-11">
                            <p class="mb-0 lh-base text-md fw-smedium">
                                {{ $comment->topic->board->board_name }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="first-name" class="form-label">Edit Comments</label>
                    <div class="di__editor di__editor-bg">
                        <div id="editor">{!! $comment->comment_text !!}</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3 mt-4 mb-3">
                        @foreach ($comment->attachments as $attachment)
                            <div class="di__image_upload attachment-image-{{ $attachment->id }}">
                                <button onclick="deleteAttachment('{{ $attachment->id }}')"
                                    style="position: absolute;
                                    width: max-content;
                                    background-color: aliceblue;"
                                    class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"><span><img
                                            src="{{ asset('images/icon/delete.svg') }}" alt=""
                                            class="in-svg"></span>Delete</button>
                                @switch($attachment->mimeType)
                                    @case('image/jpeg')
                                    @case('image/jpg')

                                    @case('image/png')
                                        <img class="di__image" src="{{ $attachment->attachment_url }}">
                                    @break

                                    @case('video/mp4')
                                    @case('video/mpeg')

                                    @case('video/webm')
                                        <video class="di__image" src="{{ $attachment->attachment_url }}" controls>
                                        @break

                                        @default
                                            <img class="di__image" src="{{ asset('images/icon/file.svg') }}">
                                        @break
                                    @endswitch
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 d-flex gap-3 flex-wrap">
                        <span
                            class="primary-color btn btn-bordered lh-1 d-inline-flex text-md align-items-center fw-smedium position-relative"><input
                                id="attachment" type="file" class="w-100 opacity-0 z-1 h-100 position-absolute"><span
                                class="di__clip me-2"><img src="{{ asset('/images/icon/clip.svg') }}" alt=""
                                    class="in-svg"></span>Attach File</span>
                        <button id="save" class="btn text-md fw-smedium lh-1">Save Comment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(async () => {
            const editor = await ClassicEditor.create(document.querySelector("#editor"), {
                toolbar: [
                    "bold",
                    "italic",
                    "underline",
                    "bulletedList",
                    "outdent",
                    "indent",
                ],
            }).catch((error) => {
                console.log(error);
            });

            $(document).on("click", "#save", function(e) {
                const comment = editor.data.get();
                const formData = new FormData();
                formData.append('comment_text', comment);
                formData.append('image', $("#attachment")?.[0]?.files[0]);
                formData.append('forum_board_id', "{{ $comment->topic->forum_board_id }}");
                formData.append('id', '{{ $comment->id }}');
                $.ajax({
                    type: "POST",
                    url: `{{ url('api/v1/topic') }}/{{ $comment->topic->id }}/topic_comment`,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        "Authorization": "Bearer {{ Auth::user()->token }}"
                    },
                    success: function(response) {
                        window.location.href = '{{ route('admin.forum.comments') }}';
                    },
                    error: function(response) {}
                });
            })
        })

        const deleteAttachment = (id) => {
            if (window.confirm('Are you sure you want to delete this')) {
                $.ajax({
                    type: "DELETE",
                    url: `{{ url('api/v1/attechment') }}/${id}`,
                    headers: {
                        "Authorization": "Bearer {{ Auth::user()->token }}"
                    },
                    success: function(response) {
                        console.log({
                            attechment: $("#attachment" + id)
                        })
                        $(".attachment-image-" + id).each((index, el) => {
                            console.log({
                                el,
                                here: "here"
                            })
                            $(el).remove();
                        })
                        toastr.success(response.message);
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.message);
                    }
                });
            }
        }
    </script>
@endsection
