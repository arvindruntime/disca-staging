@extends('layouts.master')
@section('content')

  <div class="di__dashboard_main mt-4 pt-3">
    <div class="row">
      <div class="col-12">
        <div class="di__chat__mobile d-inline-flex d-lg-none cursor-pointer">
          <img src="{{ asset('images/icon/contact.svg') }}" alt="">
        </div>
        <div class="position-relative">
          <div class="di__chat d-flex gap-4">
            <div class="di__chat-list">
              <div class="chat_header">
                <form action="#" role="search">
                  <div class="di__dash-search d-flex align-items-center gap-3">
                    <input class="form-control bg-white" id="di-search" type="search" aria-label="Search"
                      placeholder="Search">
                    <img src="{{ asset('images/icon/group-msg.svg') }}" alt="" class="in-svg cursor-pointer">
                  </div>
                </form>
              </div>
              <div class="contacts_body di__custom_scroll">
                <ul class="contacts" id="contact-list">
                  <li class="chat-group d-flex justify-content-between active" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between">
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png')}}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between">
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between">
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="chat-group d-flex justify-content-between" >
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar di__user_status di__user_status--live">
                        <div class="img-wrapper">
                          <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" class="rounded-circle bg-primary" width="39" height="39">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name">
                          <p class="mb-0 fw-smedium">Tom Jones</p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0 text-tiny color-text">hi, what’s up.......</p>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            
            <div class="di__chat-main card border-0">
              <div class="di__chat-header p-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <div class="d-flex gap-2 gap-lg-3 align-items-center">
                    <div class="contact-avatar di__user_status di__user_status--live">
                      <div class="img-wrapper">
                        <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" width="52" height="52" class="rounded-circle bg-primary">
                      </div>
                    </div>
                    <div class="contacts__about">
                      <div class="contact__name">
                        <p class="mb-0 h4 fw-smedium">Tom Jones</p>
                      </div>
                      <div class="contact__msg">
                        <p class="mb-0">Doctor</p>
                      </div>
                    </div>
                  </div>
                  <div class="di__message_count">
                    <p class="tertiary-color mb-0 fw-medium mx-0 mx-sm-2 mt-2 mt-lg-0">
                      66 Messages
                    </p>
                  </div>
                </div>
              </div>
              <div class="di__chat-body card-body p-0">
                <div class="chat-history-main di__custom_scroll">
                  <div class="chat-history">
                    <ul>
                      <li class="clearfix">
                        <div class="message user-message">
                          <div class="d-flex justify-content-start mb-2 chat_box position-relative">
                            <div class="d-flex align-items-start gap-3">
                              <div class="contact-avatar">
                                <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" width="45" height="45" class="rounded-circle bg-primary">
                              </div>
                              <div class="msg_container">
                                  <p class="mb-0">Hiiii.................</p>
                              </div>
                                
                            </div><span class="di__chat_time text-tiny mb-0">14:30</span>
                          </div>
                        </div>
                      </li>
                      <li class="clearfix">
                        <div class="message user-message">
                          <div class="d-flex justify-content-start mb-2 chat_box position-relative">
                            <div class="d-flex align-items-start gap-3">
                              <div class="contact-avatar">
                                <img src="{{ asset('images/icon/user_img.png') }}" alt="avatar" width="45" height="45" class="rounded-circle bg-primary">
                              </div>
                              <div class="msg_container">
                                  <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                              </div>
                            </div>
                            <span class="di__chat_time text-tiny mb-0">14:30</span>
                          </div>
                        </div>
                      </li>
                      <li class="di__chat_date">
                        <div class="d-flex justify-content-center align-items-center di__speratror">
                          <p class="mb-0">22 Jan, 2023 </p>
                        </div>
                      </li>
                      <li class="clearfix">
                        <div class="message reply-message">
                          <div class="d-flex justify-content-end mb-2 chat_box position-relative">
                            <div class="d-flex align-items-start gap-3">
                              <div class="msg_container">
                                  <p class="mb-0">Hi mate....</p>
                              </div>
                            </div>
                            <span class="di__chat_time text-tiny mb-0">14:30</span>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="di__chat-footer card-footer border-0">
                <div class="input-group mb-0">
                  <div class="d-inline-flex align-items-center justify-content-center position-relative bg-primary di__chat_upload">
                    <span class="position-absolute top-50 start-50 translate-middle">
                      <img class="in-svg" src="{{ asset('images/icon/clip.svg') }}" alt="">
                    </span>
                    <input type="file">
                  </div>
                  <input class="form-control shadow-none bg-white" id="send" type="text" placeholder="Type a message here..." aria-label="Recipient's username" aria-describedby="button-addon2">
                  <div class="d-flex gap-4 align-items-center">
                    <button class="btn rounded-0 h-100" id="button-addon2" type="button"> <img
                        class="in-svg" src="{{ asset('images/icon/plane.svg') }}" alt=""></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection