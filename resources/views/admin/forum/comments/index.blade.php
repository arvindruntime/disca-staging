@extends('layouts.master')

@section('content')
    <div class="di__dashboard_main mt-4 pt-3">
        <div class="di__form_heading d-flex justify-content-between flex-wrap gap-2 align-items-center border-bottom-0">
            <h5 class="mb-0 text-black">Topic Comments</h5>
            <div class="di__table_search">
                <input class="form-control lh-1" id="di-search" type="search" aria-label="Search" placeholder="Search">
            </div>
        </div>
        <div class="px-1 px-xl-5 mx-2">
            <form action="">
                <div class="di__form di__space-table">
                    <div class="row gy-3 gy-md-4 gx-5 align-items-end">
                        <div class="col-12 mt-0">
                            <table class="table text-nowrap align-middle di__comment_table di__head-radius"
                                id="di__comment_table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="fw-smedium secondry-color"><input
                                                class="form-check-input me-2 bg-transparent" type="checkbox" value=""
                                                id="tnc-checkbox">Client</th>
                                        <th scope="col" class="fw-smedium secondry-color">Comments</th>
                                        <th scope="col" class="fw-smedium secondry-color">Topic Discuss</th>
                                        <th scope="col" class="fw-smedium secondry-color">Since</th>
                                        <th scope="col" class="fw-smedium secondry-color">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
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
    </div>
@endsection
@section('js')
    <script>
        var tabel;

        table = $("#di__comment_table").DataTable({
            // searching: false,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.forum.comments.list') }}",
            columns: [{
                    data: 'user',
                    orderable: false,
                },
                {
                    data: 'comment_text',
                    // orderable: false
                },
                {
                    data: 'topic',
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
                $('td:eq(0)', row).html(`
                <div class="d-flex align-items-center">
                    <input class="form-check-input me-2 bg-transparent" type="checkbox"
                        value="" id="tnc-checkbox">
                    <div class="d-flex align-items-center">
                        <div class="img-wrapper me-2">
                            <img src="${data.profile ? data.profile: "{{ asset('/images/icon/user_img.png') }}"}" alt="" width="42"
                                height="42" class="rounded-circle bg-primary">
                        </div>
                        <div>
                            <p class="fw-smedium mb-0">${data.user}</p>
                            <p class="text-tiny primary-color mb-0 lh-1">${data.email}</p>
                        </div>
                    </div>
                </div>`);
                $('td:eq(4)', row).html(
                    `<div class="btn-group di__option_block">
                        <a href="javascript:void(0)" class="dropdown-toggle di__btn-rotate"
                            type="button" id="defaultDropdown" data-bs-toggle="dropdown"
                            data-bs-auto-close="true" aria-expanded="false">
                            <img src="{{ asset('/images/icon/options.svg') }}" alt="" class="in-svg">
                        </a>
                        <ul class="dropdown-menu border-0 mt-3" aria-labelledby="defaultDropdown">
                            <li class="p-0"><a
                                    class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                    href="{{ route('admin.forum.comments') }}/edit/${data.id}"><span><img
                                            src="{{ asset('/images/icon/edit-comment.svg') }}" alt=""
                                            class="in-svg"></span>Edit</a></li>
                            <li class="p-0"><button onclick="deleteComment(${data.id},${data.topic_id})"
                                    class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2">
                                    <span><img src="{{ asset('/images/icon/delete.svg') }}"
                                            alt="" class="in-svg"></span>Delete</button></li>
                        </ul>
                    </div>`
                );
            }
        });
        $(document).on("keyup", '#di-search', function() {
            console.log({
                table
            })
            table.search($(this).val()).draw();
        })

        const deleteComment = (id,topic_id) => {
            $.ajax({
                type: "DELETE",
                url: `{{ url('api/v1/topic') }}/${topic_id}/topic_comment/${id}`,
                headers: {
                    "Authorization": "Bearer {{ Auth::user()->token }}"
                },
                success: function(response) {
                    table.ajax.reload();
                },
                error: function(response) {}
            });
        }
    </script>
@endsection
