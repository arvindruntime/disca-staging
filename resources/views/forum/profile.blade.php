@extends('layouts.master')
@section('content')

<div class="di__dashboard_main mt-4 pt-3">
    <div class="di__form_heading">
      <h5 class="mb-0 text-black">Forum Account Details</h5>
    </div>
    <div class="px-1 px-xl-5 mx-2">
      <form id="forum-profile-form">
        <div class="di__form">
          <div class="row gy-3 gy-md-4 gx-5">
            <div class="col-12">
              <div class="d-flex gap-4 align-items-center">
                  <span class="position-relative"><input type="file" id="image" name="image"
                          class="w-100 opacity-0 z-1 h-100 position-absolute cursor-pointer"><span
                          class="d-block"><img src="{{ asset('images/icon/camera.svg') }}" alt=""
                              class="in-svg"></span></span>
                  <span>
                    @if(Auth()->user()->profile_image_url)
                      <img src="{{ Auth()->user()->profile_image_url }}" id="profile-img" alt="" width="127" height="127" class="bg-primary rounded-circle">
                    @else
                      <img src="{{ asset('images/icon/user_img.png') }}" id="profile-img" alt="" width="127" height="127" class="bg-primary rounded-circle">
                    @endif
                  </span>
                  <input type="hidden" name="remove_img">
                  <span id="remove_img" style="cursor: pointer"><img src="{{ asset('images/icon/delete.svg') }}"
                          alt="" width="22"></span>
              </div>
            </div>
            <div class="col-12 col-md-6 me-0 me-md-2">
              <label for="first-name" class="form-label">Name</label>
              <input type="text" class="form-control" placeholder="Name" value="{{ auth()->user()->name }}" name="name" aria-label="First name" id="first-name">
            </div>
            <div class="col-12 col-md-6">
              <label for="first-name" class="form-label">Username</label>
              <input type="text" class="form-control" placeholder="Username" value="{{ auth()->user()->username }}" name="username" aria-label="First name"
                id="first-name">
            </div>
            <div class="col-12 col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" placeholder="Email" value="{{ auth()->user()->email }}" name="email" aria-label="email" id="email">
            </div>
            <div class="col-12">
              <div class="row gy-3 gy-md-4 gx-5 align-items-end">
                <div class="col-12 col-md-6">
                  <label for="inputaddress" class="form-label">Address</label>
                  <input type="text" class="form-control" placeholder="Street" value="{{ auth()->user()->street }}" name="street" aria-label="Street"
                    id="inputaddress">
                </div>
                <div class="col-12 col-md-6">
                  <input type="text" class="form-control" placeholder="City/Town" value="{{ auth()->user()->city }}" name="city" aria-label="City"
                    id="inputaddress">
                </div>
                <div class="col-12 col-md-6">
                  <select id="" name="country_id" class="form-select di__select">
                      @foreach ($countries as $country)
                          <option value="{{ $country->id }}" @if(auth()->user()->country_id == $country->id) selected @endif>{{ $country->country_name }}</option>
                      @endforeach
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <input type="text" class="form-control" placeholder="Post Code" value="{{ auth()->user()->post_code }}" name="post_code" aria-label="Post"
                    id="inputaddress">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <label for="email" class="form-label">Company</label>
              <input type="text" class="form-control" placeholder="Company" value="{{ auth()->user()->company }}" aria-label="email" id="email">
            </div>
            <div class="col-12 col-md-6">
              <label for="mobile" class="form-label">Mobile Number</label>
              <div class="row gy-4 gx-3">
                <div class="col di__telephone">
                  <select id="" name="dial_code" class="form-select di__telephone--select">
                      @foreach ($countries as $country)
                          <option value="{{ $country->dial_code }}" @if(auth()->user()->dial_code == $country->dial_code) selected @endif>
                              {{ $country->dial_code }} {{ $country->country_code }}
                          </option>
                      @endforeach
                  </select>
                </div>
                <div class="col">
                    <input type="text" value="{{ auth()->user()->mobile_no }}" name="mobile_no"
                        class="form-control" placeholder="123466899" aria-label="Mobile Number"
                        id="mobile_no">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <label for="email" class="form-label">Which part of the Sector do you represents?</label>
              <input type="text" class="form-control" placeholder="Sector" value="{{ auth()->user()->sectore }}" name="sectore" aria-label="email" id="email">
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="di__form_heading border-top border-bottom-0 mt-5">
      <h5 class="mb-0 text-black">Forum Boards</h5>
    </div>
    <div class="px-1 px-xl-5 mx-2">
      <div class="di__form">
        <div class="row gy-3 gy-md-4 gx-5 align-items-end">
          <div class="col-12">
            <div class="di__forum_board_list di__light-bg">
              <div class="ps-md-4 ps-2">
                <p class="primary-color text-xs fw-smedium py-3 mb-0">
                  Care Home Private
                </p>
              </div>
              <div class="ps-md-4 ps-2 border-top">
                <p class="primary-color text-xs fw-smedium py-3 mb-0">
                  Care Homes
                </p>
              </div>
              <div class="ps-md-4 ps-2 border-top">
                <p class="primary-color text-xs fw-smedium py-3 mb-0">
                  Domiciliary Care
                </p>
              </div>
              <div class="ps-md-4 ps-2 border-top">
                <p class="primary-color text-xs fw-smedium py-3 mb-0">
                  Domiciliary Care Private
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="di__form_heading border-top border-bottom-0 mt-5">
      <h5 class="mb-0 text-black">Reset Password</h5>
    </div>
    <div class="px-1 px-xl-5 mx-2">
      <div class="di__form">
        <form id="reset-password">
          <div class="row gy-3 gy-md-4 gx-5 align-items-end">
            <div class="col-12 col-md-6">
              <label for="password" class="form-label mb-2">Current Password</label>
              <span class="position-relative">
                <input type="password" name="old_password" class="form-control password" placeholder="" aria-label="password">
                <div class="di__password_toggle">
                  <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                  <img src="{{ asset('images/icon/pass-view.svg') }}" alt="" class="di__password_hide">
              </div>
              </span>
              <div class="old_password error-message"></div>
            </div>
            <div class="col-12 col-md-6">
              <label for="password" class="form-label mb-2">New Password</label>
              <span class="position-relative">
                <input type="password" name="password" id="password" class="form-control password" placeholder="" aria-label="password">
                <div class="di__password_toggle">
                  <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                  <img src="{{ asset('images/icon/pass-view.svg') }}" alt="" class="di__password_hide">
              </div>
              </span>
              <div class="password error-message"></div>
            </div>
            <div class="col-12 col-md-6">
              <label for="password" class="form-label mb-2">Confirm New Password</label>
              <span class="position-relative">
                <input type="password" name="password_confirm" class="form-control password" placeholder="" aria-label="password">
                <div class="di__password_toggle">
                  <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                  <img src="{{ asset('images/icon/pass-view.svg') }}" alt="" class="di__password_hide">
              </div>
              </span>
              <div class="password_confirm error-message"></div>
            </div>
            <div class="col-12">
              <button id="reset" type="button" class="btn btn-grey tertiary-color">Reset
                Password</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="di__form_heading border-top border-bottom-0 mt-5 pb-3 mb-0">
      <h5 class="mb-0 text-black">Enable 2-Factor Authentication</h5>
    </div>
    <div class="px-1 px-xl-5 mx-2">
      <div class="di__form">
        <div class="row gy-3 gy-md-4 gx-5 align-items-end">
          <div class="col-12 col-md-6">
            <label for="password" class="form-label mb-2">Current Password</label>
            <span class="position-relative">
              <input type="password" class="form-control password" placeholder="" aria-label="password">
              <div class="di__password_toggle">
                <img src="{{ asset('images/icon/eye-slash.svg') }}" alt="" class="di__password_view">
                <img src="{{ asset('images/icon/pass-view.svg') }}" alt="" class="di__password_hide">
            </div>
            </span>
          </div>
          <div class="col-12">
            <a href="" class="btn btn-light primary-color">Enable</a>
          </div>
        </div>
      </div>
    </div>
    <div class="di__form_heading border-top border-bottom-0 mt-5 pb-3 mb-0">
      <h5 class="mb-4 text-black">Notifications</h5>
    </div>
    <div class="px-1 px-xl-5 mx-2 pb-3">
      <div class="di__form">
        <div class="row gy-3 gy-md-4 gx-5 align-items-end">
          <div class="col-12 col-md-9">
            <div class="d-flex justify-content-between align-items-center border-bottom border-1 pb-3">
              <label for="password" class="form-label mb-0">Email notifications</label>
              <span class="di__custom_toggle d-flex">
                <input type="checkbox" id="email_status" name="email_status"
                    {{ auth()->user()->email_status ? 'checked' : '' }} /><label
                    for="email_status"></label>
              </span>
            </div>
          </div>
          <div class="col-12 col-md-9">
            <div class="d-flex justify-content-between align-items-center border-bottom border-1 pb-3">
              <label for="password" class="form-label mb-0">Mobile app</label>
              <span class="di__custom_toggle d-flex">
                <input type="checkbox" id="notification_status" name="notification_status"
                      {{ auth()->user()->notification_status ? 'checked' : '' }} /><label
                      for="notification_status"></label>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="di__form_heading border-top border-bottom-0 mt-5  pb-3 mb-0">
    </div>
    <div class="px-1 px-xl-5 mx-2">
      <button type="button" id="submit" class="btn">Save Changes</button>
    </div>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function() {
          $('.select2box').select2();

          $("#country_id").select2({
              placeholder: function() {
                  $(this).data('placeholder');
              }
          })
    });
    const callback = () => {
        // window.location.reload();
    }
    $("#reset-password").validate({
        rules: {
            old_password: {
                required: true,
            },
            password: {
                required: true,
                minlength: 5,
            },
            password_confirm: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            }
        },
        messages: {
            password_confirm: {
                equalTo: "Password does not match",
                required: "Please enter your password",
            },
            password: {
                required: "Please enter your password",
                minlength: "Password must be at"
            },
            old_password: "Please enter your old password"
        },
        showErrors: function(errorMap, errorList) {
            if (Object.entries(errorMap).length) {
                for (let [key, message] of Object.entries(errorMap)) {
                    if (key == "members[]") {
                        key = "members";
                    }
                    $(`.${key}`).html(message);
                }
            } else {
                $(".error-message").each(function(index, el) {
                    $(el).html("");
                })
            }
        }
    });

    $(document).on("click", "#submit", function(event) {
        const formData = new FormData(document.getElementById("forum-profile-form"))

        $.ajax({
            type: "POST",
            url: "{{ url('api/v1/update_profile') }}",
            data: formData,
            headers: {
                "Authorization": "Bearer {{ Auth::user()->token }}"
            },
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                toastr.success(    
                  response.message,
                  "", 
                  {
                      onHidden: callback,
                      onCloseClick: callback,
                      "timeOut": "3000"
                  })
            },
            error: function(response) {
              toastr.error(response.responseJSON.message);
            }
        });
    })

    $(document).on("click", "#reset", function(event) {
        const formData = new FormData(document.getElementById("reset-password"))
        if ($("#reset-password").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/v1/change_password') }}",
                data: formData,
                headers: {
                    "Authorization": "Bearer {{ Auth::user()->token }}"
                },
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(    
                      response.message,
                      "", 
                      {
                          onHidden: callback,
                          onCloseClick: callback,
                          "timeOut": "3000"
                      })
                    $("#reset-password").trigger('reset');
                },
                error: function(response) {
                  toastr.error(response.responseJSON.message);
                }
            });
        }
    })
    $(document).on("change", "input[name='image']", function(event) {
        const url = URL.createObjectURL(event.target.files[0]);
        $("#profile-img").attr("src", url)
    })

    $(document).on("change", "input[name='email_status']", function(event) {
        let {
            checked
        } = event.target
        $.ajax({
            type: "POST",
            url: "{{ url('api/v1/change_email_status') }}",
            data: {
                email_status: checked ? 1 : 0,
                user_id: "{{ auth()->user()->id }}",
            },
            headers: {
                "Authorization": "Bearer {{ Auth::user()->token }}"
            },
            success: function(response) {
                toastr.success(response.message,"", {
                  onHidden: callback,
                  onCloseClick: callback,
                  "timeOut": "3000"
                })
            },
            error: function(response) {
                toastr.error(response.message);
            }
        });
    })

    $(document).on("change", "input[name='notification_status']", function(event) {
        let {
            checked
        } = event.target
        $.ajax({
            type: "POST",
            url: "{{ url('api/v1/change_notification_status') }}",
            data: {
                notification_status: checked ? 1 : 0,
                user_id: "{{ auth()->user()->id }}",
            },
            headers: {
                "Authorization": "Bearer {{ Auth::user()->token }}"
            },
            success: function(response) {
              toastr.success(    
              response.message,
              "", 
              {
                  onHidden: callback,
                  onCloseClick: callback,
                  "timeOut": "3000"
              })
            },
            error: function(response) {
                toastr.error(response.responseJSON.message)
            }
        });
    })

    $(document).on("click", "#remove_img", function(event) {
        $("input[name='remove_img']").val("true");
        $("#profile-img").attr("src", "{{ asset('images/icon/user_img.png') }}");
    })
</script>
@endsection