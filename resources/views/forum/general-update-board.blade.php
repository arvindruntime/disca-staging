@extends('layouts.master')
@section('content')

<div class="di__dashboard_main mt-5 pt-3">
    <div class="row">
      <div class="col-12">
        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
          <h2 class="primary-color mb-0">
            Board: General Update Board
          </h2>
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="" class="btn btn-light primary-color lh-1">Sort By</a>
            <a href="" class="btn btn-light primary-color lh-1">Popular</a>
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
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="img-wrapper me-2">
                      <img src="{{ asset('images/icon/table-user.png') }}" alt="" width="70" height="70"
                        class="rounded-circle">
                    </div>
                    <div>
                      <div class="di__text_width">
                        <p class="color-text fw-medium text-xs mb-0 lh-1">Dr. Savannah Nguyen added new topics on health, regarding the symptoms.</p>
                      </div>
                      <p class="fw-medium primary-color text-tiny mt-1 mb-0">Dr. Savannah Nguyen</p>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__message_icon"><img src="{{ asset('images/icon/message-red.svg') }}" alt=""></span><span class="basic-text color-text fw-normal mb-0">37</span>
                  </div>
                </td>
                <td>
                  <div class="d-inline-flex gap-1 align-items-center">
                    <span class="di__eye_icon"><a href="topic-detail/1"><img src="{{ asset('images/icon/eye-red.svg') }}" alt=""></a></span><span class="basic-text color-text fw-normal mb-0">2.5k</span>
                  </div>
                </td>
                <td>
                  <p class="basic-text color-text fw-normal mb-0">
                    30 Jan, 2023
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>

@endsection