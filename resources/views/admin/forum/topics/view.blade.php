@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="mb-3 mb-lg-5">
                <h5 class="fw-smedium">
                    Topic Details
                </h5>
            </div>
        </div>
        {{-- @dd($topic) --}}
        <div class="col-12 mb-4 mb-lg-5">
            <div class="di__topic-wrapper di__forum-bg d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex gap-3 align-items-center flex-wrap">
                    <div class="img-wrapper">
                        <img src="{{ asset($topic->user->profile_image_url ? $topic->user->profile_image_url : '/images/icon/user_img.png') }}"
                            alt class="di__status--completed bg-opacity-100 rounded-circle" width="140" height="140">
                    </div>
                    <div class="di__topic-details">
                        <h2 class="mb-0 lh-1 secondry-color">
                            {{ $topic->user->name }}
                        </h2>
                        <a href="mailto:{{ $topic->user->email }}" class="mb-2 primary-color">
                            {{ $topic->user->email }}
                        </a>
                        <p class="color-text lh-1 mb-3 text-md fw-smedium">
                            {{ $topic->board->board_name }}
                        </p>
                        <div class="d-flex gap-3 gap-xl-4 flex-wrap">
                            <div class="d-flex gap-2">
                                <img src="{{ asset('/images/icon/user-curve.svg') }}" alt>
                                <span class="color-text fw-medium">Customers</span>
                            </div>
                            <div class="d-flex gap-2">
                                <img src="{{ asset('/images/icon/location.svg') }}" alt>
                                <span class="color-text fw-medium">Bideford,xyz</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="di__count-box bg-white p-3">
                    <div class="d-flex gap-3 align-items-center mb-3 pb-0 pb-xl-2">
                        <img src="{{ asset('/images/icon/message-red.svg') }}" alt class="in-svg">
                        <p class="mb-0 color-text">
                            {{ $topic->topic_comment_count }} (Comments)
                        </p>
                    </div>
                    <div class="d-flex gap-3 align-items-center mb-3 pb-0 pb-xl-2">
                        <img src="{{ asset('/images/icon/group.svg') }}" alt class="in-svg">
                        <p class="mb-0 color-text">
                            {{ $topic->followers_count }} (Following)
                        </p>
                    </div>
                    <div class="d-flex gap-3 align-items-center">
                        <img src="{{ asset('/images/icon/time.svg') }}" alt class="in-svg">
                        <p class="mb-0 color-text">
                            {{ $topic->creted_date }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="di__open-forum align-items-lg-start d-flex gap-3 gap-lg-5 flex-wrap flex-lg-nowrap ">
                <div class="di__forum-message di__forum-bg">
                    <div class="d-flex align-items-end justify-content-between flex-wrap mb-3 gap-2">
                        <h4 class="primary-color fw-bold mb-0">
                            {{ $topic->title }}
                        </h4>
                        {{-- <div class="di__red_link">
                            <a class="d-inline-flex align-items-center gap-2 text-small" href="edit-topic.html"><span><img
                                        src="{{ asset('/images/icon/edit-comment.svg') }}" alt class="in-svg"></span>Edit</a>
                        </div> --}}
                    </div>
                    <p class="color-text mb-0">
                        {!! $topic->description !!}
                    </p>
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
                            <input type="file" id="attachment" class="w-100 opacity-0 z-1 h-100 position-absolute"><span
                                class="di__clip me-2"><img src="{{ asset('images/icon/clip.svg') }}" alt=""
                                    class="in-svg"></span>Attach File
                        </span>
                        <button type="button" id="comment" class="btn text-md fw-smedium">Send Reply</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <a href="#!" class="btn text-md lh-1 fw-smedium">Printout the
                Discusssion</a>
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

            if(!editor.data.get())
            {
                alert("Please Enter Comment!");
            }
            else if(editor.data.get()) {
                    comment(editor.data.get(), "", "", "", $("#attachment")?.[0]?.files[0]);
                    editor.data.set('');
                }
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
                    alert(response.message);
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
