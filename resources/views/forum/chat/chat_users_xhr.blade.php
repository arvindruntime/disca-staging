@php $auth_user = Auth::user(); @endphp

@forelse ($chat_usr_grps as $key => $chat_usr_grp)
@if ($chat_usr_grp->is_group == 0)

{{-- User list --}}
{{-- {{ dd($chat_usr_grp->profile_url); }} --}}
<li class="d-flex justify-content-between {{ ($key == 0 ? 'active' : '') }} chat-user" id="chat-user-{{ $chat_usr_grp->id }}" chat-user="{{ $chat_usr_grp->id }}" data-user="{{ $chat_usr_grp->id }}">
    <div class="d-flex gap-2 gap-lg-3 align-items-center">
      <div class="contact-avatar user_profile status-circle">
        <div class="img-wrapper">
          <img src="{{ url('/profile/'.$chat_usr_grp->profile_url) ? url('/profile/'.$chat_usr_grp->profile_url) : asset('images/icon/user_img.png') }}" alt="{{ $chat_usr_grp->name ?: $chat_usr_grp->id }}" class="rounded-circle bg-primary" width="39" height="39">
          {{-- <img src="{{ $chat_usr_grp->profile_url ?:  asset('images/icon/user_img.png') }}" alt="{{ $chat_usr_grp->name ?: $chat_usr_grp->id }}" class="rounded-circle bg-primary" width="39" height="39"> --}}
          {{-- <div class='status-circle'></div> --}}
        </div>
      </div>
      <div class="contacts__about">
        <div class="contact__name user_info">
          <p class="mb-0 fw-smedium">{{ $chat_usr_grp->name ?: $chat_usr_grp->id }}</p>
            @if(!(empty((array)$chat_usr_grp->last_message)))
                @if(isset($chat_usr_grp->last_message['message']))
                    <p class="user_last_msg mb-0">{{ $chat_usr_grp->last_message['decrypted_msg'] ?? '' }}</p>
                @else
                    <p class="user_last_msg mb-0"></p>
                @endif
            @else
                <p class="user_last_msg mb-0"></p>
            @endif
        </div>
        {{-- <div class="contact__msg">
          <p class="mb-0 text-tiny color-text user_last_msg">{{ ($member->last_message->message) ?? '' }}</p>
        </div> --}}
      </div>
      @php $unread = unreadMessagesCount($chat_usr_grp->id, $auth_user->id); @endphp
      <div class="msg_count" id="user_msg_{{ $chat_usr_grp->id }}">{{ ($unread > 0 ? $unread : '') }}</div>
    </div>
  </li>
  @else 
  {{-- Group list --}}
  <li class="d-flex justify-content-between {{ ($key == 0 ? '' : '') }} chat-group" id="chat-group-{{ $chat_usr_grp->id }}" data-group="{{ $chat_usr_grp->id }}">
    <div class="d-flex gap-2 gap-lg-3 align-items-center">
      <div class="contact-avatar group_profile">
        {{-- di__user_status di__user_status--live --}}
        <div class="img-wrapper img_cont">
          <img src="{{ $chat_usr_grp->profile_url ?: asset('images/icon/user_img.png') }}" alt="{{ $chat_usr_grp->group_name ?: $chat_usr_grp->id }}" class="rounded-circle bg-primary" width="39" height="39">
          <div class='group-icon'><i class="fas fa-users" style="color:grey"></i></div>
        </div>
      </div>
      <div class="contacts__about">
        <div class="group_info">
          <p class="mb-0 fw-smedium">{{ $chat_usr_grp->group_name ?: $chat_usr_grp->id }}</p>
        </div>
        <div class="contact__msg">
          {{-- <p class="mb-0 text-tiny color-text user_last_msg">{{ ($member->last_message->message) ?? '' }}</p> --}}
          
          @if(!(empty((array)$chat_usr_grp->last_message)))
              @if(isset($chat_usr_grp->last_message['vendor_short_detail']['id']))
                  @if($chat_usr_grp->last_message['vendor_short_detail']['id'] != Auth::user()->id)
                      <p class="group_last_msg">{{ $chat_usr_grp->last_message['vendor_short_detail']['name'] ?? '' }}: {{ $chat_usr_grp->last_message['decrypted_msg'] ?? '' }}</p>
                  @else
                      <p class="group_last_msg">You: {{ $chat_usr_grp->last_message['decrypted_msg'] ?? '' }}</p>
                  @endif
              @else
                  <p class="group_last_msg"></p>
              @endif
          @else
              <p class="group_last_msg"></p>
          @endif
                
        </div>
      </div>
      @php $unread = unreadMessagesCount($chat_usr_grp->id, $auth_user->id); @endphp
      <div class="msg_count" id="group_msg_{{ $chat_usr_grp->id }}">{{ ($unread > 0 ? $unread : '') }}</div>
    </div>
  </li>
  
  @endif
@empty

@endforelse