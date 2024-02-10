@extends('layouts.master')

@section('content')
    <div class="di__dashboard_main mt-4 pt-3">
        <div class="px-1 px-xl-5 mx-2">
            <div class="di__form di__postcodes_list">
                <div class="row gy-3 gy-md-4 gx-5 align-items-end">
                    <div class="col-12 mt-5 mb-1 mb-lg-3">
                        <div class="d-flex gap-2 justify-content-between flex-wrap align-items-center mb-5">
                            <h5 class="mb-0">Website Pages</h5>
                            <div class="d-flex gap-2 gap-xl-4 flex-wrap">
                                <div class="di__table_search">
                                    <input class="form-control lh-1" id="di-search" type="search" aria-label="Search"
                                        placeholder="Search">
                                </div>
                                <a href="{{ route('admin.pages.add') }}" class="btn lh-1">Add Page</a>
                            </div>
                        </div>
                        <table class="table text-xs text-nowrap align-middle di__post_group mb-0" id="web-pages-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="fw-smedium">Page Title</th>
                                    <th scope="col" class="fw-smedium">Date Published</th>
                                    <th scope="col" class="fw-smedium">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row"><span class="primary-color fw-medium">South Devon</span>
                                    </th>
                                    <td>
                                        <span class="color-text">71 members</span>
                                    </td>
                                    <td>
                                        <a href="postcode-view.html"
                                            class="btn text-white py-2 px-4 me-3 text-tiny lh-1 rounded-3 di__status--completed bg-opacity-10">View</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        let table;

        table = $('#web-pages-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.pages.list') }}",
            columns: [{
                    data: 'title'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'slug',
                    orderable: false
                },
            ],
            columnDefs: [{
                    "width": "50%",
                    "targets": 0
                },
                {
                    "width": "25%",
                    "targets": 1
                },
                {
                    "width": "25%",
                    "targets": 2
                }
            ],
            "ordering": true,
            "autoWidth": false,
            scrollX: true,
            scroller: true,
            "language": {
                "lengthMenu": "Showing result: _MENU_",
            },
            dom: "<'row'<'col-sm-12'>tr>" + "<'row mt-3'<'col-sm-4'l><'col-sm-8'p>>",
            rowCallback: function(row, data) {
                $('td:eq(2)', row).html(`
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
                                href="{{ route('admin.pages') }}/${data.slug}"><span><img
                                        src="{{ asset('images/icon/edit-comment') }}.svg"
                                        alt="" class="in-svg"></span>Edit</a></li>
                        <li class="p-0"><button
                                class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                data-id="${data.slug}" type="button" id="delete-page"><span><img
                                        src="{{ asset('images/icon/delete.svg') }}"
                                        alt="" class="in-svg"></span>Delete</button></li>
                    </ul>
                </div>`);
            }
        });
        $(document).on("keyup", '#di-search', function() {
            console.log({
                table
            })
            table.search($(this).val()).draw();
        })
        $(document).on("click", "#delete-page", function(e) {
            e.preventDefault();
            const id = $(this).attr("data-id");
            $.ajax({
                url: `{{ url('api/v1/pages/${id}') }}`,
                type: "DELETE",
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
