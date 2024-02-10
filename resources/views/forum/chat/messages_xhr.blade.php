@php $chat_date = ''; @endphp
@foreach ($chatMemberLists as $msg)

@if ($msg->message != '')
@if ($msg->from == Auth::user()->id)
     {{-- $(".msg_card_body").prepend($.tmpl($("#jsSelfTemplate").html(), lstRows)); --}}
     
     
     <li class="clearfix">
      <div class="message reply-message">
        <div class="d-flex justify-content-end mb-2 chat_box position-relative">
          <div class="d-flex align-items-start gap-3">
            <div class="msg_container">
                <p class="mb-0">{{ $msg->message }}</p>
            </div>
          </div>
          <span class="di__chat_time text-tiny mb-0 lst_ur_msg_dt">{{ $msg->display_time }}</span>
        </div>
      </div>
    </li>
    
        
@else
     {{-- $(".msg_card_body").prepend($.tmpl($("#jsUserTemplate").html(), lstRows)); --}}
    
     <li class="clearfix">
      <div class="message user-message">
        <div class="d-flex justify-content-start mb-2 chat_box position-relative">
          <div class="d-flex align-items-start gap-3">
            <div class="contact-avatar">
              <img src="{{asset('images/icon/user_img.png')}}" alt="avatar" width="45" height="45" class="rounded-circle bg-primary">
            </div>
            <div class="msg_container">
                <p class="mb-0">{{ $msg->message ?? '' }}</p>
            </div>
              
          </div><span class="di__chat_time text-tiny mb-0">{{ $msg->display_time ?? '' }}</span>
        </div>
      </div>
    </li> 
     
@endif
@endif

@endforeach