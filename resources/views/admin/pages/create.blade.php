@extends('layouts.master')

@section('content')
    <div class="di__dashboard_main mt-5 pt-3">
        <div class="di__forum_add_topic">
            <div class="row gy-4">
                <div class="col-12">
                    <h5 class="mb-0">
                        {{ isset($page) ? $page->title : 'Add Page' }}
                    </h5>
                </div>
                <form method="POST" id="addPageForm" enctype="multipart/form-data">
                    <div class="col-12">
                        <label for="page-name" class="form-label">Page Tile</label><span class="text-danger">*</span>
                        <input type="text" name="title" class="form-control" placeholder="Privacy Policy"
                            aria-label="Page name" id="page-name" value="{{ isset($page) ? $page->title : '' }}">
                        <div class="title error-message"></div>
                    </div>
                    <div class="col-12">
                        <label for="link-name" class="form-label">Permalink/URL</label><span class="text-danger">*</span>
                        <input type="text" name="permalink" class="form-control" placeholder="www.website.com/page"
                            aria-label="link name" id="link-name" value="{{ isset($page) ? $page->permalink : '' }}">
                        <div class="permalink error-message"></div>
                    </div>
                    <div class="col-12">
                        <label for="first-name" class="form-label">Content of your page</label><span
                            class="text-danger">*</span>
                        <div class="di__editor di__editor-bg">
                            <textarea name="content" id="editor">{!! isset($page) ? $page->content : '' !!}</textarea>
                            {{-- <input type="hidden" name="content"> --}}
                        </div>
                        <div class="content error-message">
                            @error('content')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mt-4 d-flex gap-3 flex-wrap">
                            <button id="submit" type="button" class="btn text-md fw-smedium lh-1 px-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(async () => {
            jQuery.validator.addMethod("alphanumeric", function(value, element) {
                return this.optional(element) || /^[a-z0-9](?!.*?[^\na-z0-9]{2}).*?[a-z0-9]$/gmi.test(value);
            })
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
            $("#addPageForm").validate({
                rules: {
                    title: {
                        required: true,
                        alphanumeric: true
                    },
                    permalink: {
                        required: true,
                        alphanumeric: true
                    },
                    content: {
                        required: true,
                    }
                },
                messages: {
                    title: {
                        required: "Please enter page title",
                        alphanumeric: "Please enter valid page title"
                    },
                    permalink: {
                        required: "Please enter permalink/url",
                        url: "Please enter valid permalink/url",
                        alphanumeric: "Please enter valid permalink"
                    },
                    content: {
                        required: "Please enter content of the page",
                    },
                },
                showErrors: function(errorMap, errorList) {
                    if (Object.entries(errorMap).length) {
                        for (let [key, message] of Object.entries(errorMap)) {
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
                if (data.length === 0) {
                    $("#addPageForm").validate().showErrors({
                        content: "Please enter content of the page"
                    });
                }

                // $('input[name="content"]').val(data)
                const formData = new FormData(document.getElementById("addPageForm"))

                formData.append('content', data);

                const callback = () => {
                    window.location.href = '{{ route('admin.pages') }}'
                }
                if ($("#addPageForm").valid()) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/v1/pages') }}/{{ isset($page) ? $page->permalink : '' }}",
                        data: formData,
                        headers: {
                            "Authorization": "Bearer {{ Auth::user()->token }}"
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            toastr.success(
                                "{{ isset($page) ? 'Saved page successfully' : 'Added page successfully' }}",
                                "", {
                                    onHidden: callback,
                                    onCloseClick: callback,
                                    "timeOut": "3000"
                                })
                        },
                        error: function(response) {
                            toastr.error(response.responseJSON.message);
                        }
                    });
                }
            })
        })
    </script>
@endsection
