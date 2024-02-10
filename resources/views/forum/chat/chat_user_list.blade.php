@php $auth_user = Auth::user(); @endphp
<div class="input-group">
    <input type="text" placeholder="Search..." name="" class="form-control" id="search_user">
    <div class="input-group-prepend ms-2">
        <span class="search_btn h-100 btn"><img src="{{ asset('images/icon/search.svg') }}" alt="Admin" class="in-svg"></span>
    </div>
</div>
@forelse ($users as $key => $user) 
    <li class="list-user my-3" id="list-user-{{ $user->id }}" data-user="{{ $user->id }}">
        <div class="d-flex bd-highlight justify-content-between align-items-center">
            <label for="user-{{ $user->id }}" class="user_profile d-flex align-items-center gap-3" >
                <div class="img_cont">
                    <div class="img-wrapper">
                        <img src="{{ $user->profile_url ?:  asset('images/icon/user_img.png') }}" alt="Admin" class="rounded-circle bg-primary" width="52" height="52">
                    </div>
                    <div class="group-icon"><i class="fas fa-users" style="color:grey"></i></div>
                    {{-- <div class='status-circle'></div> --}}
                </div>
                
                <div class="user_info">
                    <span>{{ $user->name ?: $user->id }}</span>
                </div>
            </label>
            <input type="checkbox" name="user_checkbox[]" data-id="{{ $user->id }}" class="form-check-input" value="{{ $user->id }}" id="user-{{ $user->id }}">
            @php $unread = unreadMessagesCount($user->id, $auth_user->id); @endphp
            <!-- <div class="msg_count" id="user_msg_{{ $user->id }}">{{ ($unread > 0 ? $unread : '') }}</div> -->
        </div>
    </li>
@empty
@endforelse