@extends('layouts.master')

@section('content')
    <div class="px-1 px-xl-5 mx-2">
        <div class="di__form">
            <div class="row gy-3 gy-md-4 gx-5 align-items-end">
                <div class="col-12">
                    <div class="mt-4 di__provider_message">
                        <div class="btn-group di__filter_main d-inline-block text-start position-relative">
                            <a href="javascript:void(0)"
                                class="form-control dropdown-toggle cursor-pointer d-flex align-items-center gap-2"
                                type="button" id="filterDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true"
                                aria-expanded="false">
                                <p class="mb-0 text-small">Filters</p>
                                <span><img src="{{ asset('images/icon/filter.svg') }}" alt=""></span>
                            </a>
                            <div class="dropdown-menu di__filter_options mt-2" aria-labelledby="filterDropdown">
                                <p class="color-text mb-2 ms-2 ps-1 text-small">
                                    Filter By:
                                </p>
                                <ul class="list-unstyled m-0">
                                    <li>
                                        <a href="javascript:void(0)" class="mb-0 text-tiny">
                                            Customer
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="mb-0 text-tiny">
                                            Provider
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="mb-0 text-tiny">
                                            Forum
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" class="mb-0 text-tiny">
                                            Provider, Forum
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <table class="table text-xs text-nowrap align-middle di__super_table">
                            <thead>
                                <tr>
                                    <th scope="col" class="fw-smedium secondry-color" width="7%"><input
                                            class="form-check-input me-1" type="checkbox" value=""
                                            id="tnc-checkbox">ID
                                    </th>
                                    <th scope="col" class="fw-smedium secondry-color" width="22%">User</th>
                                    <th scope="col" class="fw-smedium secondry-color" width="17%">NHS</th>
                                    <th scope="col" class="fw-smedium secondry-color" width="19%">Status</th>
                                    <th scope="col" class="fw-smedium secondry-color" width="19%">User Type</th>
                                    <th scope="col" class="fw-smedium secondry-color" width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" class="fw-medium"><input class="form-check-input me-1"
                                            type="checkbox" value="" id="tnc-checkbox"><span
                                            class="color-text">A121</span>
                                    </th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="img-wrapper me-2">
                                                <img src="{{ asset('images/icon/user_img.png') }}" alt=""
                                                    width="43" height="43"
                                                    class="rounded-circle di__status--completed bg-opacity-100">
                                            </div>
                                            <div>
                                                <p class="fw-smedium mb-0">David Jones</p>
                                                <p class="text-tiny primary-color mb-0 lh-1">hello@tomjones.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <span class="color-text">485 777 3456</span>
                                    </td>
                                    <td>
                                        <div
                                            class="fw-smedium d-inline-block py-2 px-2 text-center me-3 text-tiny di__status di__status--rejected lh-1 bg-opacity-10 rounded-3">
                                            New Request</div>
                                    </td>
                                    <td>
                                        <span class="fw-medium color-text">Customer</span>
                                    </td>
                                    <td>
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
                                                        href="admin-provider.html"><span><img
                                                                src="{{ asset('images/icon/view.svg') }}" alt=""
                                                                class="in-svg"></span>View details</a></li>
                                                <li class="p-0"><a
                                                        class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                                        href="#"><span><img
                                                                src="{{ asset('images/icon/delete.svg') }}" alt=""
                                                                class="in-svg"></span>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="fw-medium"><input class="form-check-input me-1"
                                            type="checkbox" value="" id="tnc-checkbox"><span
                                            class="color-text">A121</span>
                                    </th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="img-wrapper me-2">
                                                <img src="{{ asset('images/icon/user_img.png') }}" alt=""
                                                    width="43" height="43"
                                                    class="rounded-circle di__status--completed bg-opacity-100">
                                            </div>
                                            <div>
                                                <p class="fw-smedium mb-0">David Jones</p>
                                                <p class="text-tiny primary-color mb-0 lh-1">hello@tomjones.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <span class="color-text">485 777 3456</span>
                                    </td>
                                    <td>
                                        <div
                                            class="fw-smedium d-inline-block py-2 px-2 text-center me-3 text-tiny di__status di__status--completed lh-1 bg-opacity-10 rounded-3">
                                            Approved</div>
                                    </td>
                                    <td>
                                        <span class="fw-medium color-text">Provider</span>
                                    </td>
                                    <td>
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
                                                        href="admin-provider.html"><span><img
                                                                src="{{ asset('images/icon/view.svg') }}" alt=""
                                                                class="in-svg"></span>View details</a></li>
                                                <li class="p-0"><a
                                                        class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                                        href="#"><span><img
                                                                src="{{ asset('images/icon/delete.svg') }}" alt=""
                                                                class="in-svg"></span>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="fw-medium"><input class="form-check-input me-1"
                                            type="checkbox" value="" id="tnc-checkbox"><span
                                            class="color-text">A121</span>
                                    </th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="img-wrapper me-2">
                                                <img src="{{ asset('images/icon/user_img.png') }}" alt=""
                                                    width="43" height="43"
                                                    class="rounded-circle di__status--completed bg-opacity-100">
                                            </div>
                                            <div>
                                                <p class="fw-smedium mb-0">David Jones</p>
                                                <p class="text-tiny primary-color mb-0 lh-1">hello@tomjones.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <span class="color-text">485 777 3456</span>
                                    </td>
                                    <td>
                                        <div
                                            class="fw-smedium d-inline-block py-2 px-2 text-center me-3 text-tiny di__status di__status--rejected  lh-1 bg-opacity-10 rounded-3">
                                            Deleted</div>
                                    </td>
                                    <td>
                                        <span class="fw-medium color-text">Forum</span>
                                    </td>
                                    <td>
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
                                                        href="admin-provider.html"><span><img
                                                                src="{{ asset('images/icon/view.svg') }}" alt=""
                                                                class="in-svg"></span>View details</a></li>
                                                <li class="p-0"><a
                                                        class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                                        href="#"><span><img
                                                                src="{{ asset('images/icon/delete.svg') }}"
                                                                alt="" class="in-svg"></span>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="fw-medium"><input class="form-check-input me-1"
                                            type="checkbox" value="" id="tnc-checkbox"><span
                                            class="color-text">A121</span>
                                    </th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="img-wrapper me-2">
                                                <img src="{{ asset('images/icon/user_img.png') }}" alt=""
                                                    width="43" height="43"
                                                    class="rounded-circle di__status--completed bg-opacity-100">
                                            </div>
                                            <div>
                                                <p class="fw-smedium mb-0">David Jones</p>
                                                <p class="text-tiny primary-color mb-0 lh-1">hello@tomjones.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <span class="color-text">485 777 3456</span>
                                    </td>
                                    <td>
                                        <div
                                            class="fw-smedium d-inline-block py-2 px-2 text-center me-3 text-tiny di__status di__status--pending  lh-1 bg-opacity-10 rounded-3">
                                            Pending</div>
                                    </td>
                                    <td>
                                        <span class="fw-medium color-text">Customer</span>
                                    </td>
                                    <td>
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
                                                        href="admin-provider.html"><span><img
                                                                src="{{ asset('images/icon/view.svg') }}" alt=""
                                                                class="in-svg"></span>View details</a></li>
                                                <li class="p-0"><a
                                                        class="dropdown-item d-inline-flex align-items-center gap-2 text-tiny py-2"
                                                        href="#"><span><img
                                                                src="{{ asset('images/icon/delete.svg') }}"
                                                                alt="" class="in-svg"></span>Delete</a></li>
                                            </ul>
                                        </div>
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
