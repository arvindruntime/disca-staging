@extends('layouts.master')

@section('content')
    <div class="di__form_heading d-flex flex-wrap justify-content-between align-items-center border-bottom-0">
        <h5 class="mb-0 text-black">Forum Topics</h5>
        <div class="di__table_search">
            <input class="form-control lh-1" id="di-search" type="search" aria-label="Search" placeholder="Search">
        </div>
        <a href="{{ route('admin.forum.topics.add') }}" class="btn fw-bold px-4 lh-1">Add New Topic</a>
    </div>
    <div class="px-1 px-xl-5 mx-2">
        <form action="">
            <div class="di__form di__space-table">
                <div class="row gy-3 gy-md-4 gx-5 align-items-end">
                    <div class="col-12 mt-0">
                        <table class="table text-xs text-nowrap di__forum-topic_table di__head-radius"
                            id="di__forum-topic_table">
                            <thead>
                                <tr>
                                    <th scope="col" class="fw-smedium secondry-color">Topics</th>
                                    <th scope="col" class="fw-smedium secondry-color">Publish By</th>
                                    <th scope="col" class="fw-smedium secondry-color">Boards</th>
                                    <th scope="col" class="fw-smedium secondry-color">Replies</th>
                                    <th scope="col" class="fw-smedium secondry-color">Since</th>
                                    <th scope="col" class="fw-smedium secondry-color">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="6">
                                        Loading...
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        var tabel;

        table = $("#di__forum-topic_table").DataTable({
            // searching: false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.forum.topics.list') }}",
            columns: [{
                    data: 'title'
                },
                {
                    data: 'user',
                    orderable: false,
                },
                {
                    data: 'board',
                    orderable: false
                },
                {
                    data: 'replies',
                    orderable: false,
                },
                {
                    data: 'created_at',
                    orderable: true,
                },
                {
                    data: 'id',
                    orderable: false
                },
            ],
            ordering: true,
            autoWidth: false,
            scrollX: true,
            scroller: true,
            language: {
                search: "",
                searchPlaceholder: "Search",
                info: "",
                lengthMenu: "Showing result: _MENU_",
            },
            dom: "<'row'<'col-sm-12'tr>>" + "<'row mt-3'<'col-sm-4'l><'col-sm-8'p>>",
            rowCallback: function(row, data) {
                $('td:eq(5)', row).html(`
                <div class="btn-group di__option_block">
                    <a href="javascript:void(0)" class="dropdown-toggle di__btn-rotate"
                        type="button" id="defaultDropdown" data-bs-toggle="dropdown"
                        data-bs-auto-close="true" aria-expanded="false">
                        <img src="{{ asset('images/icon/options.svg') }}" alt=""
                            class="in-svg">
                    </a>
                    <ul class="dropdown-menu border-0 mt-3" aria-labelledby="defaultDropdown">
                        <li class="p-0"><a
                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                href="{{ route('admin.forum.topics') }}/view/${data.id}"><span><img
                                        src="{{ asset('images/icon/view') }}.svg"
                                        alt="" class="in-svg"></span>View</a></li>
                        <li class="p-0"><a
                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                href="{{ route('admin.forum.topics') }}/edit/${data.id}"><span><img
                                        src="{{ asset('images/icon/edit-comment') }}.svg"
                                        alt="" class="in-svg"></span>Edit</a></li>
                        <li class="p-0"><button
                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                data-id="${data.id}" type="button" id="delete-topic"><span><img
                                        src="{{ asset('images/icon/delete.svg') }}"
                                        alt="" class="in-svg"></span>Delete</button></li>
                    </ul>
                </div>`);
                $('td:eq(3)', row).html(
                    `<div class="d-inline-flex gap-1 align-items-center"><span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt="" /></span><span class="basic-text color-text fw-medium mb-0">${data.replies}</span></div> `
                );
            }
        });
        $(document).on("keyup", '#di-search', function() {
            console.log({
                table
            })
            table.search($(this).val()).draw();
        })
        $(document).on("click", "#delete-topic", function(e) {
            e.preventDefault();
            const id = $(this).attr("data-id");
            console.log({
                id
            })
            $.ajax({
                url: `{{ url('api/v1/delete_topic/${id}') }}`,
                type: "GET",
                headers: {
                    "Authorization": "Bearer {{ Auth::user()->token }}"
                },
                success: function(data) {
                    toastr.success(data.message);
                    table.ajax.reload();
                },
                error: function(data) {
                    toastr.error(data.message);
                }
            })
        })
    </script>
@endsection
