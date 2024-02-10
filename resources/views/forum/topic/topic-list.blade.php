@extends('layouts.master')
@section('content')
    <div class="di__dashboard_main mt-5 pt-3">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                    <h2 class="primary-color mb-0">
                        Board: {{ $board->board_name }}
                    </h2>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <label class="btn btn-light primary-color lh-1">Sort By</label>
                        <input type="checkbox" name="sortBy" class="d-none" id="sortBy" />
                        <label class="btn btn-light primary-color lh-1" for="sortBy" id="sortBy-label">Popular</label>
                    </div>
                </div>
                <div class="mt-4 di__discussion_table di__forum_topic">
                    <table class="table align-middle text-nowrap di__user_table" id="board-topics-table">
                        <thead>
                            <tr>
                                <th scope="col" class="fw-smedium" width="45%"></th>
                                <th scope="col" class="fw-smedium" width="18%"></th>
                                <th scope="col" class="fw-smedium" width="18%"></th>
                                <th scope="col" class="fw-smedium" width="19%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center">
                                    Loading...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let table;
        let sortBy = "topic_views";
        table = $('#board-topics-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/forum/board-topics/list/' . $board->id) }}" + "?sortBy=" + sortBy,
            columns: [{
                    data: 'title',
                    name: 'title',
                    orderable: false
                },
                {
                    data: 'topic_views',
                    name: 'topic_views',
                    orderable: false
                },
                {
                    data: 'replies',
                    name: 'replies',
                    orderable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
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
            "ordering": false,
            "autoWidth": false,
            scrollX: true,
            scroller: true,
            "language": {
                "info": "",
                "lengthMenu": "Showing result: _MENU_",
            },
            dom: "<'row'<'col-sm-12'>tr>" + "<'row mt-3'<'col-sm-4'l><'col-sm-8'p>>",
            rowCallback: function(row, data) {
                $(row).on("click", function(event) {
                    window.location.href = `{{ url('forum/board-topic') }}/${data.id}`
                })
                $('td:eq(0)', row).html(`
                <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                        <img src="${data.user.profile_image_url ? data.user.profile_image_url : "{{ asset('images/icon/table-user.png') }}"}" alt=""
                            width="70" height="70" class="rounded-circle">
                    </div>
                    <div>
                        <div class="di__text_width">
                            <p class="color-text fw-medium text-xs mb-0 lh-1">${data.user.name} added
                                new topic ${data.title}</p>
                        </div>
                        <p class="fw-medium primary-color text-tiny mt-1 mb-0">${data.user.name}</p>
                    </div>
                </div>`);
                $('td:eq(1)', row).html(`
                <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}"
                            alt=""></span><span
                        class="basic-text color-text fw-normal mb-0">${data.replies}</span>
                </div>`);
                $('td:eq(2)', row).html(`<div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="#"><img
                                src="{{ asset('images/icon/eye-red.svg') }}"
                                alt=""></a></span><span
                        class="basic-text color-text fw-normal mb-0">${data.topic_views}</span>
                </div>`);
                $('td:eq(3)', row).html(`
                <p class="basic-text color-text fw-normal mb-0">
                    ${data.created_at}
                </p>`);
            }
        });
        $(document).on("change", '#sortBy', function(event) {
            const {
                checked
            } = event.target
            if (checked) {
                $("#sortBy-label").html("Popular")
                sortBy = "topic_views"
            } else {
                $("#sortBy-label").html("Latest")
                sortBy = "created_at"
            }
            table.ajax.url("{{ url('/forum/board-topics/list/' . $board->id) }}" + "?sortBy=" + sortBy).draw();

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
