@extends('layouts.master')
@section('content')
    <div class="di__dashboard_main mt-5 pt-3">
        <div class="di__forum_add_topic">
        <form method="POST" enctype="multipart/form-data" id="createTopicForm">
            <div class="row gy-4">
                <div class="col-12">
                    <h5 class="mb-0 text-black">
                        {{ isset($topic) ? 'Edit' : 'Add New' }} Topic
                    </h5>
                </div>
                <div class="col-12">
                    <label for="first-name" class="form-label">Enter Title of your Topic</label>
                    <input type="text" name="title" class="form-control @error('title') error @enderror"
                        placeholder="Topic title" aria-label="First name" id="first-name"
                        value="{{ isset($topic) ? $topic->title : '' }}">
                    <div class="title error-message">
                        @error('title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <label for="first-name" class="form-label">Content about your Topic</label>
                    <div class="di__editor di__editor-bg">
                        <div id="editor">{!! isset($topic) ? $topic->description : '' !!}</div>
                        <input type="hidden" name="description">
                    </div>
                    <div class="description error-message">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <label for="inputcare" class="form-label">Select your Board</label>
                    <select name="forum_board_id" class="form-select di__select" id="inputcare">
                        <option value="">Select your Board</option>
                        @foreach ($boards as $board)
                            <option value="{{ $board->id }}"
                                {{ isset($topic) && $topic->forum_board_id == $board->id ? 'selected' : '' }}>
                                {{ $board->board_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="forum_board_id error-message mt-1">
                    @error('forum_board_id')
                        {{ $message }}
                    @enderror
                </div>
                <div class="col-12">
                    {{-- <div class="image error-message">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </div> --}}
                    <div class="mt-4 d-flex gap-3 flex-wrap">
                        <span
                            class="primary-color btn btn-bordered d-inline-flex text-md align-items-center fw-smedium position-relative">
                            <input type="file" name="image[]" class="w-100 opacity-0 z-1 h-100 position-absolute"
                                multiple />
                            <span class="di__clip me-2">
                                <img src="{{ asset('images/icon/clip.svg') }}" alt="" class="in-svg">
                            </span>
                            Attach File
                        </span>
                        <Button type="button" id="submit"
                            class="btn text-md fw-smedium">{{ isset($topic) ? 'Save' : 'Publish' }} Topic</Button>
                    </div>
                    <div class="image error-message">
                        @error('image')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </form>
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

            $("#createTopicForm").validate({
                rules: {
                    title: {
                        required: true,
                    },
                    "image[]": {
                        required: "{{ isset($topic) }}" == "1" ? false : true,
                    },
                    description: {
                        required: true,
                    },
                    forum_board_id: {
                        required: true,
                    }
                },
                messages: {
                    title: "Please enter topic title",
                    image: "Please add Image",
                    description: "Please enter description",
                    'forum_board_id': "Please select board",
                },
                showErrors: function(errorMap, errorList) {
                    console.log({
                        errorMap,
                        errorList
                    })
                    if (Object.entries(errorMap).length) {
                        for (let [key, message] of Object.entries(errorMap)) {
                            if (key == "image[]") {
                                key = "image"
                            }
                            $(`.${key}`).html(message);
                        }
                    } else {
                        $(".error-message").each(function(index, el) {
                            $(el).html("");
                        })
                    }
                }
            })
            $(document).on("click", "#submit", function(event) {
                const data = editor.data.get()
                $('input[name="description"]').val(data)
                const formData = new FormData(document.getElementById("createTopicForm"))
                const callback = () => {
                    if ("{{ isset($topic) }}" == "1" ||
                        "{{ request()->routeIs('admin.forum.topics.add') }}" == "1") {
                        window.location.href = '{{ route('admin.forum.topics') }}'
                    } else {
                        window.location.reload()
                    }
                }
                if ($("#createTopicForm").valid()) {
                    $("#submit").attr("disabled", true)
                    $.ajax({
                        type: "POST",
                        url: "{{ url(isset($topic) ? 'api/v1/update_topic/' . $topic->id : 'api/v1/store_topic') }}",
                        data: formData,
                        headers: {
                            "Authorization": "Bearer {{ Auth::user()->token }}"
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            toastr.success(
                                "{{ isset($topic) ? 'Topic saved' : 'Topic created' }} successfully",
                                "", {
                                    onHidden: callback,
                                    onCloseClick: callback,
                                    "timeOut": "3000"
                                })
                        },
                        error: function(response) {
                            $("#submit").removeAttr("disabled")
                            toastr.error(response.responseJSON.message);
                        }
                    });
                }
            })
            // $(document).on("change", "input[name='image']", function(event) {
            //     const url = URL.createObjectURL(event.target.files[0]);
            //     $(".di__image_upload").removeClass("d-none")
            //     $(".di__image").attr("src", url)
            // })
        })
    </script>
@endsection
