@extends('layouts.master')
@section('content')
{{-- <style type="text/css">
.status-circle {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: grey;
    border: 2px solid white;
    bottom: 10px;
    right: 10px;
    position: absolute;
}
.status-circle.online {
    background-color: #4cd137;
}</style> --}}
<div class="di__dashboard_main mt-4 pt-3">
    <div class="row">
      <div class="col-12">
        <div class="di__chat__mobile d-inline-flex d-lg-none cursor-pointer">
          <img src="{{asset('images/icon/contact.svg')}}" alt="">
        </div>
        <div class="position-relative">
          <div class="di__chat d-flex gap-4 lm__chat">
            <div class="di__chat-list lm__chat-list">
              <div class="chat_header">
                <form action="#" role="search">
                  <div class="di__dash-search d-flex align-items-center gap-3">
                    <input class="form-control bg-white" id="search" type="search" aria-label="Search"
                      placeholder="Search">
                    <img src="{{asset('images/icon/group-msg.svg')}}" alt="" class="in-svg group_btn cursor-pointer">
                  </div>
                </form>
              </div>
              
              <div class="contacts_body di__custom_scroll">
                <ul class="contacts" id="contact-list">
                    @include('forum.chat.chat_users_xhr')
                    {{-- <span class="d-none no_records_found">
                        <li class="active"><div class="text-center bd-highlight" style="color: white">{{ __('No Record Found') }}</div></li>
                    </span> --}}
                </ul>
              </div>
            </div>
            
            <div class="lm__chat-main di__chat-main card border-0">
                <div class="di__chat-header p-3 msg_head">
                  <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex gap-2 gap-lg-3 align-items-center">
                      <div class="contact-avatar chat_list status-circle">
                        {{-- di__user_status di__user_status--live --}}
                        <div class="img-wrapper">
                          <img id="chat_user_profile" src="{{asset('images/icon/user_img.png')}}" alt="avatar" width="52" height="52" class="rounded-circle bg-primary">
                        </div>
                      </div>
                      <div class="contacts__about">
                        <div class="contact__name add_group_user_btn">
                          <p class="mb-0 h4 fw-smedium" id="chat_user_name"></p>
                        </div>
                        <div class="contact__msg">
                          <p class="mb-0" id="user_type"></p>
                        </div>
                      </div>
                    </div>
                    <div class="di__message_count d-flex gap-1">
                      <p class="mb-0 tertiary-color fw-medium mx-0 mt-2 mt-lg-0 message_count"> </p> 
                      <p class="mb-0 tertiary-color fw-medium mx-0 mt-2 mt-lg-0"> Messages</p> 
                    </div>
                  </div>
                </div>
                <div class="lm__chat-body di__chat-body card-body p-0">
                  <div class="chat-history-main di__custom_scroll">
                    <div class="chat-history">
                      <ul class="msg_card_body" id="msg_card_body">
                        {{-- @include('forum.chat.messages_xhr')                         --}}
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="di__chat-footer card-footer border-0">
                  <div class="input-group mb-0">
                    <div class="d-inline-flex align-items-center justify-content-center position-relative bg-primary di__chat_upload">
                      <span class="position-absolute top-50 start-50 translate-middle">
                        <img class="in-svg" src="{{asset('images/icon/clip.svg')}}" alt="">
                      </span>
                      <input type="file" id="imageUpload" multiple="">
                    </div>
                    <input class="form-control shadow-none bg-white" id="message" type="text" placeholder="Type a message here..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="d-flex gap-4 align-items-center">
                      <button class="btn rounded-0 h-100 send_btn" id="button-addon2" type="button"> <img
                          class="in-svg" src="{{asset('images/icon/plane.svg')}}" alt=""></button>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
        </div>
      </div>
    </div>
  </div>
  
  
  <div id="group_modal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" >New Group</h4>
                <a href="javascript:void(0)" type="" class="close" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                <form name="create_grp" id="create_grp" method="post">
                    @csrf
                    <p class="label-control">Group Name</p>
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id; }}">
                    <input type="text" name="group_name" id="group_name" placeholder="Group Name" class="form-control" required>
                    <br>
                    <h2>Contacts</h2>
                    <ui class="contacts list-unstyled" id="contact-list">
                    @include('forum.chat.chat_user_list')
                        {{-- <span class="d-none no_records_found">
                            <li class="active"><div class="text-center bd-highlight" style="color: white">{{ __('No Record Found') }}</div></li>
                        </span> --}}
                    </ui>

                    <input type="submit" class="btn w-100" name="create_new_group" id="create_new_group" value="Create">
                </form>
            </div>
        </div>
    </div>
</div>
            
            
            
   
        
    <script id="jsUserTemplate" type="text/x-jQuery-tmpl">
        <div class="d-flex justify-content-start mb-4 chat_box">
            <div class="img_cont_msg">
                <img src="${profile_photo_path}" class="rounded-circle user_img_msg">
            </div>
            <div class="msg_cotainer">
                <p>${message}</p>
            </div>
            <div class="send_msg_time">
                <span class="msg_time">${time}</span>
            </div>
        </div>
    </script>

    <script id="jsSelfTemplate" type="text/x-jQuery-tmpl">
        <div class="d-flex justify-content-end mb-4 chat_box">
            
            <div class="msg_container">
                <div class="d-flex align-items-end gap-2">
                    <p class="mb-0">${message}</p>
                    <span class="text-sm-10 mb-0">${time}</span>
                </div>
            </div>

        </div>
    </script>
    
    <script id="jsSelfImageTemplate" type="text/x-jQuery-tmpl">
      <div class="d-flex justify-content-end mb-4 chat_box" style="align-items: start;">
          <div class="msg_cotainer chat_image_block" style="padding: 0;">
              <a href="${message}" target="_blank">
                  <p><img class="chat_image" src="${message}"></img></p>
              </a>
          </div>
          <div class="send_msg_time">
          <span class="msg_time">${time}</span>
          </div>
      </div>
  </script>

  <script id="jsSelfVideoTemplate" type="text/x-jQuery-tmpl">
    <div class="d-flex justify-content-end mb-4 chat_box" style="align-items: start;">
        <div class="msg_cotainer" style="padding: 0;">
            <a href="${message}" target="_blank">
                <span><video class="chat_image" src="${message}" controls crossorigin></video></span>
            </a>
        </div>
        <div class="send_msg_time">
        {{-- <span class="msg_time">${time}</span> --}}
        </div>
    </div>
</script>
  
  <script id="jsSelfAudioTemplate" type="text/x-jQuery-tmpl">
    <div class="d-flex justify-content-end mb-4 chat_box" style="align-items: start;">
        <div class="msg_cotainer_audio" style="padding: 0;">
            <a href="${message}" target="_blank">
                <span><audio class="" src="${message}" controls crossorigin></audio></span>
            </a>
        </div>
        <div class="send_msg_time">
        {{-- <span class="msg_time">${time}</span> --}}
        </div>
    </div>
</script>
    
    <script id="jsSelfDocumentTemplate" type="text/x-jQuery-tmpl">
      <div class="d-flex justify-content-end mb-4 chat_box" style="align-items: start;">
          <div class="msg_cotainer">
              <a href="${message}" target="_blank">
                  <p class="d-flex mx-3"><i class="fas fa-download"></i><span class="name">${document_name}</span></p>
              </a>
          </div>
          <div class="send_msg_time">
          <span class="msg_time">${time}</span>
          </div>
      </div>
  </script>
    
      {{-- <script type="text/javascript" src="{{ asset('assets/js/jquery.tmpl.js') }}"></script> --}}
    
{{-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
<script src="https://cdn.socket.io/4.1.1/socket.io.min.js" integrity="sha384-cdrFIqe3RasCMNE0jeFG9xJHog/tgOVC1E9Lzve8LQN1g5WUHo0Kvk1mawWjxX7a" crossorigin="anonymous"></script>

{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.tmpl/1.0.0/jquery.tmpl.min.js"></script> --}}

<script>
    const all_users = @json($users);
    const users = @json($users);
    // console.log(users);
    var groups = @json($groups);
    const from_user = @json(Auth::user());
    console.log("AD: ",users);
    const chat_user_route = "{{ route('chat.message', ':id') }}";
    
    const chat_store_media = "{{ route('chat.storeMedia') }}";
    
    const encode_string_url = "{{ route('chat.encodestring') }}";
    const decode_string_url = "{{ route('chat.decodestring') }}";
    const today = new moment();
    const just_now_message =  today.format("HH:mm");
    // const socket_host = "{{ env('CHAT_HOST'  ) }}:{{ env('CHAT_PORT') }}";
    const csrf_token = "{{ csrf_token() }}";
        
    const get_groups_route = "{{ route('all.groups') }}";
    const create_group_chat = "{{ route('chat.creategroup') }}";
    const chat_group_route = "{{ route('group.chat', ':id') }}";
    const delete_grp_url = "{{ route('chat.deletegroup') }}";
    
    const add_new_member = "{{ route('chat.joinmember') }}";
    const remove_member = "{{ route('chat.removemember') }}";
    const update_group = "{{ route('chat.updategroup') }}";
    const leave_group_url = "{{ route('chat.leavegroup') }}";
    const default_img_url = "{{ asset('images/icon/user_img.png') }}";
</script>
<script src="{{ asset('js/chat-socket.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.tmpl.js') }}"></script>
<script>
    
</script>
@endsection