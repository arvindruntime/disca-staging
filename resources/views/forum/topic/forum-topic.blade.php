@extends('layouts.master')
@section('content')
    {{-- @dd($topic) --}}
    <div class="di__dashboard_main mt-5 pt-3">
        <div class="row">
            <div class="col-12">
                <div class="mb-5">
                    <h4 class="primary-color">
                        {{-- @dd($topic) --}}
                        {{ $topic->title }}
                    </h4>
                    <p class="color-text text fw-medium d-inline-block mb-0">
                        {{ $topic->board->board_name }} | {{ $topic->creted_date }} |
                        <span class="primary-color fw-smedium d-inline-block">
                            By {{ $topic->user->name }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="di__open-forum align-items-lg-start d-flex gap-3 gap-lg-5 flex-wrap flex-lg-nowrap ">
                    <div class="col-8">
                        <div class="di__forum-message di__forum-bg">
                            {!! $topic->description !!}
                            <div class="text-end">
                                <a href="javascript:void(0)" onclick="showAttechments()"
                                    class="primary-color d-inline-flex text-md align-items-center fw-smedium"><span
                                        class="di__clip me-2"><img src="{{ asset('images/icon/clip.svg') }}" alt=""
                                            class="in-svg"></span>Show Attachment</a>
                            </div>
                            <div class="attechments d-none" id="attechments">
                                @foreach ($topic->attachments_url as $image)
                                    <img src="{{ $image }}">
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="di__verticle_stats di__forum-bg">
                            <div class="d-flex align-items-center">
                                <div class="di__stats_img">
                                    <img src="{{ asset(isset($topic->user->profile_image_url) ? $topic->user->profile_image_url : 'images/icon/user_img.png') }}"
                                        alt="" class="tertiary-bg rounded-circle" width="97" height="97">
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 primary-color fw-smedium">
                                        {{ $topic->user->name }}
                                    </h6>
                                    <p class="mb-0 color-text">
                                        (@username)
                                    </p>
                                </div>
                            </div>
                            <div class="">
                                <a href="javascript:void(0)" id="follow-topic"
                                    class="btn {{ $topic->is_following ? 'btn-bordered' : '' }} text-md w-100 fw-medium lh-base my-4">{{ $topic->is_following ? 'Unfollow This Topic' : 'Follow This Topic' }}
                                </a>
                            </div>
                            <div class="di_discussion_stats mt-4">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="tertiary-color d-inline-flex align-items-center fw-medium"><span
                                                class="me-2 di__forum-icon"><img
                                                    src="{{ asset('images/icon/message.svg') }}"
                                                    alt=""></span>Views:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-end color-text">{{ $topic->topic_views }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="tertiary-color d-inline-flex align-items-center fw-medium"><span
                                                class="me-2 di__forum-icon"><img src="{{ asset('images/icon/group.svg') }}"
                                                    alt=""></span>Replies:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-end color-text">{{ $topic->topic_reply_count }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="tertiary-color d-inline-flex align-items-center fw-medium"><span
                                                class="me-2 di__forum-icon"><img src="{{ asset('images/icon/time.svg') }}"
                                                    alt=""></span>Freshness:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-end color-text">{{ $topic->creted_date }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="tertiary-color d-inline-flex align-items-center fw-medium"><span
                                                class="me-2 di__forum-icon"><img
                                                    src="{{ asset('images/icon/add-people.svg') }}"
                                                    alt=""></span>Voices:</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-end color-text">{{ $topic->voices }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="di__option_block di__comment_block di__forum-bg mt-3 mt-lg-5">
                    <h5 class="fw-bold primary-color">Topic Discussion</h5>
                    <div id="comments-section">

                    </div>
                    <div class="mt-5">
                        <h5 class="fw-bold">Leave a Reply</h5>
                    </div>
                    <div>
                        <div class="di__editor">
                            <div id="editor"></div>
                        </div>
                        <div class="mt-4 d-flex gap-3 flex-wrap">
                            <span
                                class="primary-color btn btn-bordered d-inline-flex text-md align-items-center fw-smedium position-relative">
                                <input type="file" id="attachment"
                                    class="w-100 opacity-0 z-1 h-100 position-absolute"><span class="di__clip me-2"><img
                                        src="{{ asset('images/icon/clip.svg') }}" alt=""
                                        class="in-svg"></span>Attach File
                            </span>
                            <button type="button" id="comment" class="btn text-md fw-smedium">Send Reply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const editors = {};
        $(document).ready(async () => {
            const editor = await makeEditor('editor')
            refresh();
            $(document).on("click", "#comment", () => {
                console.log({
                    editor
                })
                if (editor.data.get()) {
                    comment(editor.data.get(), "", "", "", $("#attachment")?.[0]?.files[0]);
                    editor.data.set('');
                }
            })
            $("#follow-topic").on("click", function(e) {
                $.ajax({
                    type: "POST",
                    url: `{{ url('api/v1/') }}/{{ $topic->is_following ? 'unfollow_topic' : 'follow_topic' }}`,
                    data: {
                        topic_id: "{{ $topic->id }}",
                        user_id: "{{ auth()->user()->id }}"
                    },
                    headers: {
                        "Authorization": "Bearer {{ Auth::user()->token }}"
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(response) {}
                });
            })
        })

        const makeEditor = async (id) => {
            return await ClassicEditor.create(document.querySelector(
                "#" + id), {
                toolbar: [
                    "bold",
                    "italic",
                    "underline",
                    "bulletedList",
                    "outdent",
                    "indent",
                ],
            }).then((editor) => {
                return editor
            }).catch((error) => {
                console.log(error);
            });
        }
        const showEditor = (comment_id) => {
            $("#comment-editor-" + comment_id).removeClass("d-none")
        }
        const hideEditor = (comment_id) => {
            $("#comment-editor-" + comment_id).addClass("d-none")
        }
        const showEditBox = (textbox_id, editBox_id) => {
            $("#" + textbox_id).addClass("d-none")
            $("#" + editBox_id).removeClass("d-none")
        }
        const hideEditBox = (textbox_id, editBox_id) => {
            $("#" + textbox_id).removeClass("d-none")
            $("#" + editBox_id).addClass("d-none")
        }

        const reply = (comment_id, attachment_id) => {
            const editor = editors[`editor_${comment_id}`];
            if (editor.data.get()) {
                comment(editor.data.get(), comment_id, '', '', $("#" + attachment_id)?.[0]?.files?.[0]);
            }
        }

        const onSave = (textBox_id, comment_id, commented_by, attachment_id) => {
            const editor = editors[textBox_id];
            if (editor.data.get()) {
                comment(editor.data.get(), '', comment_id, commented_by, $("#" + attachment_id)?.[0]?.files?.[0]);
            }
        }

        const comment = (comment, parent_id = '', id = '', commented_by = '', image = '') => {
            const formData = new FormData();
            formData.append('comment_text', comment);
            formData.append('forum_board_id', "{{ $topic->forum_board_id }}");
            formData.append('parent_id', parent_id);
            formData.append('commented_by', commented_by);
            formData.append('id', id);
            formData.append('image', image);
            $.ajax({
                type: "POST",
                url: `{{ url('api/v1/topic') }}/{{ $topic->id }}/topic_comment`,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    "Authorization": "Bearer {{ Auth::user()->token }}"
                },
                success: function(response) {
                    refresh();
                },
                error: function(response) {}
            });
        }
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
        const deleteComment = (id) => {
            $.ajax({
                type: "DELETE",
                url: `{{ url('api/v1/topic') }}/{{ $topic->id }}/topic_comment/${id}`,
                headers: {
                    "Authorization": "Bearer {{ Auth::user()->token }}"
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(response) {}
            });
        }
        const likeComment = (id) => {
            $.ajax({
                type: "POST",
                url: `{{ url('api/v1/topic_comment_like') }}`,
                headers: {
                    "Authorization": "Bearer {{ Auth::user()->token }}"
                },
                data: {
                    topic_id: '{{ $topic->id }}',
                    topic_comment_id: id
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(response) {}
            });
        }
        const showAttechments = () => {
            if ($("#attechments").hasClass('d-none')) {
                $("#attechments").removeClass("d-none");
            } else {
                $("#attechments").addClass("d-none");
            }
        }
        const refresh = () => {
            $.ajax({
                type: "get",
                url: `{{ route('forum.topics.refresh', ['id' => $topic->id]) }}`,
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    "Authorization": "Bearer {{ Auth::user()->token }}"
                },
                success: function(response) {
                    const {
                        topic
                    } = response.data;
                    $("#comments-section").html(response.data.view)
                    topic.comment.forEach(async (comment) => {
                        editors[`editor_${comment.id}`] = await makeEditor(
                            `editor-${comment.id}`);
                        editors[`comment_edit_${comment.id}`] = await makeEditor(
                            `comment-edit-${comment.id}`);
                        comment?.replies?.forEach(async (reply) => {
                            editors[`reply_edit_${reply.id}`] =
                                await makeEditor(
                                    `reply-edit-${reply.id}`)
                        })
                    })
                    img2svg();
                },
                error: function(response) {}
            });
        }
    </script>
@endsection
