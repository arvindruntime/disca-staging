@extends('layouts.master')

@section('content')
    <div class="di__form_heading d-flex flex-wrap justify-content-between align-items-center border-bottom-0">
        <h5 class="mb-0 text-black">Forum Boards</h5>
        <a href="{{ route('admin.forum.board.add') }}" class="btn fw-bold px-4 lh-1">Add New Board</a>
    </div>
    <div class="px-1 px-xl-5 mx-2">
        <form action="">
            <div class="di__form di__space-table">
                <div class="row gy-3 gy-md-4 gx-5 align-items-end">
                    <div class="col-12 mt-0">
                        {{-- <div class="mt-4"> --}}
                            <table class="table text-xs text-nowrap di__admin-forum_table di__head-radius"
                                id="di__admin-forum_table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="fw-smedium secondry-color">Board Name</th>
                                        <th scope="col" class="fw-smedium secondry-color">Description</th>
                                        <th scope="col" class="fw-smedium secondry-color">Members</th>
                                        <th scope="col" class="fw-smedium secondry-color">Since</th>
                                        <th scope="col" class="fw-smedium secondry-color">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center">
                                                Loading...
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        var tabel;
        table = $("#di__admin-forum_table").DataTable({
            // searching: false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.forum.board.list') }}",
            columns: [{
                    data: 'board_name'
                },
                {
                    data: 'discription',
                    orderable: false
                },
                {
                    data: 'memberCount',
                    orderable: false
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'id',
                    orderable: false
                },
            ],
            columnDefs: [{
                    width: "15%",
                    targets: 0
                },
                {
                    width: "48%",
                    targets: 1
                },
                {
                    width: "10%",
                    targets: 2
                },
                {
                    width: "20%",
                    targets: 3
                },
                {
                    width: "7%",
                    targets: 4
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
                $('td:eq(4)', row).html(`
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
                                href="{{ route('admin.forum.board') }}/edit/${data.url}"><span><img
                                        src="{{ asset('images/icon/edit-comment') }}.svg"
                                        alt="" class="in-svg"></span>Edit</a></li>
                        <li class="p-0"><button
                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                data-id="${data.id}" type="button" id="delete-group"><span><img
                                        src="{{ asset('images/icon/delete.svg') }}"
                                        alt="" class="in-svg"></span>Delete</button></li>
                    </ul>
                </div>`);
            }
        });
        $(document).on("click", "#delete-group", function(e) {
            e.preventDefault();
            const id = $(this).attr("data-id");
            console.log({
                id
            })
            $.ajax({
                url: `{{ url('api/v1/board/${id}') }}`,
                type: "DELETE",
                headers: {
                    "Authorization": "Bearer {{ Auth::user()->token }}"
                },
                success: function(data) {
                    toastr.success(data.message)
                    table.ajax.reload();
                },
                error: function(response) {
                    toastr.error(response.responseJSON.message);
                }
            })
        })
    </script>
@endsection
