@extends('layouts.master')

@section('content')
    <div class="di__form_heading border-bottom-0">
        <h5 class="mb-0 text-black">@if(isset($board)) Edit @else Add New  @endisset Board</h5>
    </div>
    <div class="px-1 px-xl-5 mx-2">
        <div class="di__form">
            <form method="POST" id="addBoardForm" enctype="multipart/form-data">
                <div class="row gy-3 gy-md-4 gx-5 align-items-end">
                    <div class="col-12">
                        <label for="board-name" class="form-label">Board Name<span class="text-danger">*</span></label>
                        <input type="text" name="board_name" required
                            class="form-control @error('board_name') error @enderror" placeholder="" aria-label="Street"
                            id="board-name" value="{{ isset($board->board_name) ? $board->board_name : '' }}">
                        <div class="board_name error-message">@error('board_name') {{ $message }} @enderror</div>
                    </div>
                    <div class="col-12">
                        <label for="link" class="form-label">Permalink/Slug<span class="text-danger">*</span></label>
                        <input type="text" name="url" required class="form-control @error('url') error @enderror"
                            placeholder="" aria-label="Street" id="link"
                            value="{{ isset($board->url) ? $board->url : '' }}">
                        <div class="url error-message">@error('url')
                            {{ $message }}
                        @enderror</div>
                    </div>
                    <div class="col-12">
                        <label for="first-name" class="form-label">Description<span class="text-danger">*</span></label>
                        <div class="di__editor di__editor-bg">
                            <textarea name="discription" id="editor">{!! isset($board->discription) ? $board->discription : '' !!}</textarea>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            @isset($board->id)
                                <input type="hidden" name="id" value="{{ $board->id }}">
                            @endisset
                        </div>
                        <div class="discription error-message">@error('discription')
                            {{ $message }}
                        @enderror</div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-3 mt-4 mb-3">
                            <div class="di__image_upload {{ isset($board->image_url) ? '' : 'd-none' }}">
                                <img src="{{ isset($board->image_url) ? $board->image_url : asset('images/upload-placeholder.png') }}"
                                    class="di__image" alt="">
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="btn btn-bordered text-white h5 lh-1 mb-0 position-relative">
                                <input type="file" name="image" accept="image/png, image/jpg, image/jpeg"
                                    class="w-100 opacity-0 z-1 h-100 position-absolute cursor-pointer @error('image') error @enderror">
                                <img src="{{ asset('images/icon/upload.svg') }}" alt="" class="in-svg me-2">Upload
                            </div>
                            <p class="text-xs tertiary-color mb-0">
                                Please upload image of Board<span class="text-danger">*</span>
                            </p>
                        </div>
                        <div class="image error-message">
                            @error('image') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="col-12 mt-3 mt-xl-5">
                        <div class="d-flex justify-content-between flex-wrap">
                            <p class="secondry-color fw-smedium text-xs">
                                Select Members<span class="text-danger">*</span>
                            </p>
                            <div class="text-small mb-1">
                                <input class="form-check-input" type="checkbox" onchange="SelectAll()" value="" id="select-all">
                                <label class="form-check-label secondry-color fw-smedium text-xs text-nowrap" 
                                    for="select-all">
                                    Select All
                                </label>
                            </div>
                        </div>
                        <div class="members error-message">@error('members') $message @enderror</div>
                        <div class="di__multiselect-box di__member_select">
                            <div class="mb-3">
                                <input type="text" class="form-control bg-white" placeholder="Type name" name="username" id="myInputTextField"
                                    aria-label="Street" id="link">
                            </div>
                            <ul class="list-unstyled di__custom_scroll mb-0">
                                <table id="di__members" class="di__forum-topic_table">
                                    {{-- @foreach ($forumUsers as $user) --}}
                                        {{-- <tr>
                                            <td>
                                                <li>
                                                    <div class="d-flex align-items-center gap-3 mt-10 mb-10">
                                                        <input class="form-check-input bg-transparent"
                                                            name="members[]" type="checkbox" value="{{ $user->id }}"
                                                            id="forum-board-1"
                                                            @isset($board->members)
                                                                @foreach ($board->members as $member)
                                                                    @if ($member->id === $user->id)
                                                                        checked
                                                                    @endif
                                                                @endforeach
                                                            @endisset
                                                            >
                                                    </div>
                                                </li>
                                            </td>
                                            <td>
                                                
                                            </td>
                                        </tr> --}}
                                    {{-- @endforeach --}}
                                </table>
                                {{-- <div class="error"></div> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" id="submit" class="btn text-white h5 lh-1 mt-5 mb-0">@if(isset($board)) Edit @else Add  @endisset Board</button>
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
            $.validator.addMethod("noDots", function(value, element) {
                return this.optional(element) || !value.includes('.');
            }, "Dots are not allowed in the slug.");
            $("#addBoardForm").validate({
                rules: {
                    board_name: {
                        required: true,
                    },
                    url: {
                        required: true,
                        noDots: true,
                    },
                    image: {
                        required: "{{ isset($board->image)}}" == "1" ? false: true,
                    },
                    discription: {
                        required: true,
                    },
                    'members[]': {
                        required: true,
                    }
                },
                messages: {
                    board_name: "Please enter board name",
                    url: {
                        required: "Please enter url"
                    },
                    image: "Please add image",
                    discription: {
                        required: "Please enter description"
                    },
                    'members[]': "Please select members",
                },
                showErrors: function(errorMap, errorList) {
                    if(Object.entries(errorMap).length){
                        for(let [key,message] of Object.entries(errorMap)) {
                            if(key == "members[]"){
                                key = "members";
                            }
                            $(`.${key}`).html(message);
                        }
                    }else{
                        $(".error-message").each(function(index,el){
                            $(el).html("");
                        })
                    }
                }
            })
            $(document).on("click", "#submit", function(event) {
                const data = editor.data.get()
                console.log(data)
                console.log(data.length)
                if (data.length === 0) {
                    $("#addBoardForm").validate().showErrors({
                        discription: "Please enter description"
                    });
                }
                // $('input[name="discription"]').val(data)
                const formData =  new FormData(document.getElementById("addBoardForm"))

                formData.append('discription', data);

                const callback = () => {
                    window.location.href = '{{ route("admin.forum.board") }}'
                }
                if ($("#addBoardForm").valid()) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/v1/board') }}/{{ isset($board->id) ? $board->id : ''}}",
                        data:formData,
                        headers: {
                            "Authorization" : "Bearer {{ Auth::user()->token; }}"
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            toastr.success(
                                "{{ isset($board->id) ? 'Board saved successfully' : 'Board created successfully'}}",
                                "", {
                                    onHidden: callback,
                                    onCloseClick: callback,
                                    "timeOut": "3000"
                                })
                        },
                        error: function (response){
                            toastr.error(response.responseJSON.message);
                        }
                    });
                }
            })
            $(document).on("change", "input[name='image']", function(event) {
                const url = URL.createObjectURL(event.target.files[0]);
                $(".di__image_upload").removeClass("d-none")
                $(".di__image").attr("src", url)
            })
            // $(document).on("change", "#select-all", function(event) {
            //     const {
            //         checked
            //     } = event.target
            //     if (checked) {
            //         $("input[name='members[]']").attr("checked", true);
            //     } else {
            //         $("input[name='members[]']").removeAttr("checked");
            //     }
            // })
            let table = $("#di__members").DataTable({
                ordering: false,
                autoWidth: true,
                scrollX: false,
                language: {
                    search: "",
                    searchPlaceholder: "",
                    info: "",
                    infoEmpty: "No Record Found",
                    infoFiltered: "",
                    lengthMenu: "",
                },
                responsive: true,
                searching: true,
                columnDefs: [{
                    width: "20%",
                    targets: 0
                },
                {
                    width: "60%",
                    targets: 1
                }],
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.forum.board.members.list',['board_id' => isset($board->id) ? $board->id : '']) }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name',
                        orderable: false,
                    }
                ],
                rowCallback: function(row, data) {
                    $('td:eq(0)', row).html(`<li>
                                                <div class="d-flex align-items-center gap-3 mt-10 mb-10">
                                                    <input class="form-check-input bg-transparent"
                                                        name="members[]" type="checkbox" value="${data.id}"
                                                        id="forum-board-${data.id}" onchange=selectUser(); ${data.checked}
                                                        >
                                                </div>
                                            </li>`);
                    $('td:eq(1)', row).html(
                        `<li>
                            <div class="d-flex align-items-center gap-3 mt-10 mb-10">
                                <label
                                    class="d-inline-flex align-items-center gap-3 form-check-label primary-color fw-smedium text-xs text-nowrap"
                                    for="forum-board-1">
                                    <div class="img-wrapper">
                                        <img src="${data.image}"
                                            alt="" width="42" height="42"
                                            class="rounded-circle di__status--completed bg-opacity-100">
                                    </div>
                                    
                                    ${data.name}
                                </label>
                            </div>
                        </li>`
                    );
                },
                dom: "<'row'<'col-sm-12'tr>>" + "<'row mt-3'<'col-sm-4'l><'col-sm-8'p>>",
            });
            $('#myInputTextField').keyup(function(){
                var search_val = $(this).val().toLowerCase();
                var matchingRows = 0;

                $('#di__members tbody tr').each(function(){
                    var username = $(this).find('td:eq(1)').text().toLowerCase();

                    if(username.includes(search_val)){
                        $(this).show();
                        matchingRows++;
                    } else {
                        $(this).hide();
                    }
                });

                // Check if there are no matching rows
                if (matchingRows === 0) {
                    $('#di__members tbody').append('<tr><td colspan="2">No Record Found</td></tr>');
                } else {
                    // Remove the "No Record Found" message if it was previously added
                    $('#di__members tbody tr:has(td:contains("No Record Found"))').remove();
                }
            });


            
        })
        function selectUser() {

            var userCheckboxes = document.getElementsByName("members[]");

            var selectAllCheckbox = document.getElementById("select-all");

            var allChecked = true;
            for (var i = 0; i < userCheckboxes.length; i++) {
                // console.log("Checking : " + userCheckboxes[i].checked);
                if (!userCheckboxes[i].checked) {
                allChecked = false;
                break;
                }else{
                    userCheckboxes[i].checked = true
                }
            }

            selectAllCheckbox.checked = allChecked;
        }
        function SelectAll() {
                var selectAllCheckbox = document.getElementById('select-all');
                var checkboxes = document.getElementsByName("members[]");

                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });

                if (!selectAllCheckbox.checked) {
                    checkboxes.forEach(function (checkbox) {
                        if (checkbox.id !== 'select-all') {
                            checkbox.checked = false;
                            checkbox.removeAttribute('checked');
                        }
                    });
                }
            }
    </script>
@endsection
