<?php
namespace App\Repositories;

use App\Models\ChatDocument;
use App\Models\ChatGroup;
use App\Models\ChatGroupMember;
use App\Models\ChatMsg;
use DB;
use Auth;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;


class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        User $user,
        ChatMsg $chat,
    ) {
        $this->user = $user;
        $this->chat = $chat;
    }

    public function userList($pagination = "", $request="")
    {
        if ($pagination) {
           $users = $this->user
           ->where('type', 0)
            ->where(function ($query) use ($request) {
                $query->when(!empty($request->search), function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%{$request->search}%");
                    $query->orWhere('email', 'LIKE', "%{$request->search}%");
                });
            })->get();
            $allData = [];
            $phoneUtil = PhoneNumberUtil::getInstance();
            foreach($users as $item) {
                $rowRes = new \StdClass;
                $rowRes->id = $item->id;
                $rowRes->name = $item->name;
                $rowRes->email = $item->email;
                $rowRes->email_address_2 = (!empty($item->email_address_2) ? $item->email_address_2 : []);
                $rowRes->email_verified_at = (!empty($item->email_verified_at) ? $item->email_verified_at : '');
                $rowRes->password = (!empty($item->password) ? $item->password : '');
                $rowRes->two_factor_secret = (!empty($item->two_factor_secret) ? $item->two_factor_secret : '');
                $rowRes->two_factor_recovery_codes = (!empty($item->two_factor_recovery_codes) ? $item->two_factor_recovery_codes : '');
                $rowRes->remember_token = (!empty($item->remember_token) ? $item->remember_token : '');
                $rowRes->profile_photo_path = (env('APP_URL').\Storage::url('profile/').$item->profile_photo_path);
                $rowRes->created_at = $item->created_at;
                $rowRes->updated_at = $item->updated_at;
                $rowRes->type = $item->type;
                $rowRes->user_type = $item->user_type;
                $rowRes->country = $item->country;
                if($item->telephone){
                    $phoneNumber = $phoneUtil->parse($item->telephone, null);
                    $rowRes->country_code = $phoneNumber->getCountryCode();
                    $rowRes->telephone_no = $phoneNumber->getNationalNumber();
                } else {
                    $rowRes->country_code = null;
                    $rowRes->telephone_no = null;
                }
                if($item->telephone_country_name){
                    $string_name= $item->telephone_country_name;
                    $start=strpos($string_name,"(");
                    $end=strpos($string_name,")");
                    $length= $end-$start;
                    if($length!=0)
                    {
                        $remove_string_name=substr($string_name,$start,$length+1);
                        $telephone_country_fetch = str_replace($remove_string_name, "", $string_name);
                    }
                    else{
                        $telephone_country_fetch= $string_name;
                    }
                }
                $rowRes->telephone_country_name = (!empty($telephone_country_fetch) ? trim($telephone_country_fetch) : 'United Kingdom');
                $rowRes->telephone = $item->telephone;
                $rowRes->telephone_2 = (!empty($item->telephone_2) ? $item->telephone_2 : []);
                $rowRes->company_name = $item->company_name;
                $rowRes->address_line_1 = $item->address_line_1;
                $rowRes->address_line_2 = $item->address_line_2;
                $rowRes->address_line_3 = $item->address_line_3;
                $rowRes->city = $item->city;
                $rowRes->area = $item->area;
                $rowRes->postcode = $item->postcode;
                $rowRes->full_name = (!empty($item->full_name) ? $item->full_name : '');
                $rowRes->sla_signature = isset($item->sla_signature) ? env('APP_URL').\Storage::url('public/signature/sla/'.$item->sla_signature) : '' ;
                $rowRes->data_signature = isset($item->data_signature) ? env('APP_URL').\Storage::url('public/signature/data/'.$item->data_signature) : '' ;
                $rowRes->fcm_token = $item->fcm_token;
                $rowRes->Google_2FA_status = $item->google2fa_status;
                $allData[] = $rowRes;
            }
            if (!empty($pagination)) {
                $allData = paginate($allData);
            }
            return $allData;
        
        } else {
            return $this->user->where('type', 0)->get();
        }
    }

    public function userStore($data)
    {
        return $this->user->create($data);
    }

    public function all($filters = [])
    {
        if (empty($filters)) {
            return $this->user->all();
        }

        return $this->user->where($filters)->get();
    }

    public function store($data)
    {
        $data['password'] = Hash::make($data['password']);
        if (!isset($data['user_type'])) {
            $data['user_type'] = 4;
        }

        return $this->user->create($data);
    }

   
    public function storeChat($data)
    {
        $chat = new $this->chat;
        if (isset($data['pictureFile']) && !empty($data['pictureFile'])) {
            $path = storage_path('app/public/chat/general/private');

            try {
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
            } catch (\Exception $e) {
            }

            $file = $data['pictureFile'];
            $filename = $file->getClientOriginalName();

            $file->move($path, $filename);
            $chat->file = $filename;
        } else {
            $chat->message = $data['message'];
        }
        if (isset($data['pictureFilePubllic']) && !empty($data['pictureFilePubllic'])) {
            $path = storage_path('app/public/chat/general/public');

            try {
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
            } catch (\Exception $e) {
            }

            $file = $data['pictureFilePubllic'];
            $filename = $file->getClientOriginalName();

            $file->move($path, $filename);
            $chat->file = $filename;
        } else {
            $chat->message = $data['message'];
        }
        $chat->receiver_id = $data['receiver_id'];
        $chat->group_id = $data['group_id'];
        $chat->type = (isset($data['is_private']) && $data['is_private'] == 1 ? 1 : 0);
        $chat->read = 0;
        $chat->save();
        return $chat;
    }

    public function updateChat($request)
    {
        return $this->chat->where('id', $request['chat_id'])->update(['message' => $request['message']]);
    }

    public function deleteChat($request)
    {
        return $this->chat->where('id', $request['chat_id'])->delete();
    }

    public function getPreferences($id)
    {
        //return $this->setting->where('user_id', $id)->whereIn('key', [ 'timezone', 'dateformat' ])->get();
    }

    public function userUpdate($request, $id)
    {
        $data = $request->validated();
        if (!empty($request->email_address_2)) {
            $data['email_address_2'] = $request->input('email_address_2');
        }
        if(!empty($telephone_2)) {
            $data['telephone_2'] = $request->input('telephone_2');
        }
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data = Arr::except($data,array('password'));
        }
        if (!empty($request->timezone)) {
            // $this->setting->where('user_id', $id)->where('key', 'timezone')->update([
            //     'value' => $request->timezone
            // ]);
        }
        if (!empty($request->dateformat)) {
            // $this->setting->where('user_id', $id)->where('key', 'dateformat')->update([
            //     'value' => $request->dateformat
            // ]);
        }
        if ($request->has('summary-ckeditor-sla')) {
            $data['sla_content'] = $request->input('summary-ckeditor-sla');
        }
        if ($request->has('summary-ckeditor-data')) {
            $data['data_content'] = $request->input('summary-ckeditor-data');
        }
        if ($request->hasFile('image')) {
            Storage::delete('/public/profile/'.$request->oldimage);
            $path = $request->file('image');
            $imagename = time().'.'.$path->extension();
            $request->file('image')->storeAs('public/profile/', $imagename);
            $data['profile_photo_path'] = $imagename;
        }
        if(!empty($request['telephone_country_name'])) {
            $data['telephone_country_name'] = $request['telephone_country_name'];
        }
        unset($data['image']);

        return $this->user->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        $user = $this->user->findorfail($id);
        try {
            if (isset($user->profile_photo_path)) {
                Storage::delete('/public/profile/'.$user->profile_photo_path);
            }
            $user->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function roles()
    {
        return $this->user->whereIn('user_type', [1, 2, 3])->get();
    }

    public function allUsers()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return $users;
    }

    public function chatUsers()
    {
        // if ((Auth::user()->user_type == 1) || (Auth::user()->user_type == 2) || (Auth::user()->user_type == 3)) {
        if ((Auth::user()->user_type == 1) || (Auth::user()->user_type == 2) || (Auth::user()->user_type == 3)) {
            $users = User::where('id', '!=', Auth::user()->id)->get();
            $allData = [];
            foreach($users as $user) { 
                $last_message =  ChatMsg::where(function($query) use($user){
                    $query->where('from', $user->id)->where('user_id', Auth::user()->id);
                })->orWhere(function($query) use($user){
                    $query->where('from', Auth::user()->id)->where('user_id', $user->id);
                })->orderBy('id', 'desc')->latest()->first();
                if($last_message && $last_message->message == null){
                    foreach ( $last_message->documents as $document) {
                        $doc = $document->document;
                    }
                    $last_message->message = $doc;
                    $last_message->makeHidden(['documents']);
                }
                
                $user_type = ($user->user_type == 1) ? 'Admin' : (($user->user_type == 2) ? 'Provider' : (($user->user_type == 3) ? 'Forum' : 'Normal'));
                
                $rowRes = new \StdClass;
                $rowRes->id = $user->id;
                $rowRes->name = $user->name;
                $rowRes->profile_url = $user->image ?? asset('images/icon/user_img.png');
                $rowRes->user_type = $user_type;
                $rowRes->created_at = (isset($last_message->created_at) ? $last_message->created_at->format('Y-m-d H:i:s') : '');
                $rowRes->last_message = $last_message;
                $rowRes->message_count = unreadMessagesCount($user->id ,Auth::user()->id);
                $allData[] = $rowRes;
            }
            $result = (collect($allData)->sortByDesc('created_at')->toArray());
            array_splice($result,1,0);
            return $result;     
            
        } else {
        $generatChats = ChatMsg::where('user_id', Auth::user()->id)->pluck('from');
        $users = User::whereIn('user_type',[1 , 2, 3])->get();
        $allData = [];
        foreach($users as $user) {
            $last_message =  ChatMsg::where(function($query) use($user){
                $query->where('from', $user->id)->where('user_id', Auth::user()->id);
            })->orWhere(function($query) use($user){
                $query->where('from', Auth::user()->id)->where('user_id', $user->id);
            })->orderBy('id', 'desc')->latest()->first();
            if($last_message && $last_message->message == null){
                foreach ( $last_message->documents as $document) {
                    $doc = $document->document;
                }   
                $last_message->message = $doc;
                $last_message->makeHidden(['documents']);
            }
            $rowRes = new \StdClass;
            $rowRes->id = $user->id;
            $rowRes->name = $user->name;
            $rowRes->profile_url = $user->image ?? asset('images/icon/user_img.png');
            $rowRes->user_type = $user->user_type;
            $rowRes->created_at = (isset($last_message->created_at) ? $last_message->created_at->format('Y-m-d H:i:s') : '');
            $rowRes->last_message = $last_message;
            $rowRes->message_count = unreadMessagesCount($user->id ,Auth::user()->id);
            $allData[] = $rowRes;
        }
        $result = (collect($allData)->sortByDesc('created_at')->toArray());
        array_splice($result,1,0);
        return $result;
        }
    }

    public function chat()
    {
        // if ((Auth::user()->user_type == 1) || (Auth::user()->user_type == 2) || (Auth::user()->user_type == 3)) {
        if ((Auth::user()->user_type == 1) || (Auth::user()->user_type == 2) || (Auth::user()->user_type == 3)) {
            $users = User::where('id', '!=', Auth::user()->id)->get();
            $allData = [];
            $userGroup = [];
            foreach($users as $user) { 
                $last_message =  ChatMsg::with('vendorShortDetail')->where(function($query) use($user){
                    $query->where('from', $user->id)->where('user_id', Auth::user()->id);
                })->orWhere(function($query) use($user){
                    $query->where('from', Auth::user()->id)->where('user_id', $user->id);
                })->orderBy('id', 'desc')->latest()->first();
                if ($last_message) {
                    if ($last_message->message == null || $last_message->message == '') {
                        foreach ( $last_message->documents as $document) {
                            $doc = $document->document;
                        }
                        $last_message->message = encryptString($doc);
                        $last_message->makeHidden(['documents', 'decrypted_msg']);
                    }
                    $last_message = $last_message->toArray();
                    $last_message['vendor_short_detail'] = setEmptyData($last_message['vendor_short_detail']);
                }
                unset($last_message['group_id']);
                unset($last_message['decrypted_msg']);
                $rowRes = new \StdClass;
                $rowRes->id = $user->id;
                $rowRes->name = $user->name;
                $rowRes->profile_url = $user->image;
                $rowRes->user_type = isset($user->user_type) ? $user->user_type : '';
                $rowRes->created_at = (isset($last_message['created_at']) ? $last_message['created_at'] : '');
                $rowRes->is_group = 0;
                $rowRes->group_name = '';
                // $rowRes->user_id = '';
                $rowRes->last_message = isset($last_message) ? setEmptyData($last_message) : new \StdClass();
                unset($rowRes->last_message->unique_id);
                unset($rowRes->last_message->socket_id);
                unset($rowRes->last_message->updated_at);
                unset($rowRes->last_message->status);
                // unset($rowRes->last_message->message_type);
                $rowRes->groupmember = [];
                $rowRes->message_count = unreadMessagesCount($user->id ,Auth::user()->id);
                $rowRes->last_message_time = isset($last_message) ? (is_array($last_message) ? $last_message['created_at'] : $last_message->created_at) : '';
                $allData[] = $rowRes;
            }
            // groups
            $user_id = Auth::user()->id;
            $group_members = ChatGroupMember::select('id', 'group_id')->where('user_id',$user_id)->get();
            $group_ids = [];
            foreach($group_members as $group_member) {
                $group_ids[] = $group_member->group_id;
            }
            $groups = ChatGroup::whereIn('id', $group_ids)->with('groupmember', 'lastMessage.vendorShortDetail', 'lastMessage.documents')->get()->makeHidden(['updated_at'])->toArray();

            foreach($groups as $key => $group) {
                if (setEmptyData($group['last_message'])) {
                    if (empty($group['last_message']['message']) || $group['last_message']['message'] == '' || $group['last_message']['message'] == null) {
                        foreach ( $group['last_message']['documents'] as $document) {
                            $doc = $document['document'];
                        }
                        $groups[$key]['last_message']['message'] = encryptString($doc);
                        $groups[$key]['last_message']['vendor_short_detail'] = setEmptyData($group['last_message']['vendor_short_detail']);
                    }
                    $groups[$key]['last_message']['vendor_short_detail'] = setEmptyData($group['last_message']['vendor_short_detail']);
                }
                unset($groups[$key]['last_message']['documents']);
                unset($groups[$key]['last_message']['group_id']);
                unset($groups[$key]['last_message']['decrypted_msg']);
                $rowRes = new \StdClass;
                $rowRes->id = $group['id'];
                $rowRes->name = '';
                $rowRes->profile_url = $group['profile_url'];
                $rowRes->company_name = '';
                $rowRes->created_at = $group['created_at'];
                $rowRes->is_group = 1;
                $rowRes->group_name = $group['group_name'];
                // $rowRes->user_id = $group['user_id'];
                $rowRes->last_message = isset($groups[$key]['last_message']) ? setEmptyData($groups[$key]['last_message']) : new \StdClass();
                unset($rowRes->last_message->unique_id);
                unset($rowRes->last_message->socket_id);
                unset($rowRes->last_message->updated_at);
                unset($rowRes->last_message->status);
                // unset($rowRes->last_message->message_type);
                $rowRes->groupmember = setEmptyData($group['groupmember']);
                $rowRes->message_count = 0;
                $rowRes->last_message_time = isset($groups[$key]['last_message']) ? (is_array($groups[$key]['last_message']) ? $groups[$key]['last_message']['created_at'] : $groups[$key]['last_message']->created_at) : '';
                $userGroup[] = $rowRes;
            }
            ///
            $allData = array_merge($allData, $userGroup);
            $result = setEmptyData(collect($allData)->sortByDesc('last_message_time')->toArray());
            foreach ($result as $res) {
                unset($res->last_message_time);
            }
            array_splice($result,1,0);
            return $result;     
           
        } else {
        $generatChats = ChatMsg::where('user_id', Auth::user()->id)->pluck('from');
        $users = User::whereIn('user_type',[1 , 2, 3])->get();
        $allData = [];
        $userGroup = [];
        foreach($users as $user) {
            $last_message =  ChatMsg::with('vendorShortDetail')->where(function($query) use($user){
                $query->where('from', $user->id)->where('user_id', Auth::user()->id);
            })->orWhere(function($query) use($user){
                $query->where('from', Auth::user()->id)->where('user_id', $user->id);
            })->orderBy('id', 'desc')->latest()->first();
            if ($last_message) {
                if ($last_message->message == null || $last_message->message == '') {
                    foreach ( $last_message->documents as $document) {
                        $doc = $document->document;
                    }
                    $last_message->message = encryptString($doc);
                    $last_message->makeHidden(['documents', 'decrypted_msg']);
                }
                $last_message = $last_message->toArray();
                $last_message['vendor_short_detail'] = setEmptyData($last_message['vendor_short_detail']);
            }
            unset($last_message['group_id']);
            unset($last_message['decrypted_msg']);
            $rowRes = new \StdClass;
            $rowRes->id = $user->id;
            $rowRes->name = $user->name;
            $rowRes->profile_url = $user->image;
            $rowRes->user_type = isset($user->user_type) ? $user->user_type : '';
            $rowRes->created_at = (isset($last_message->created_at) ? $last_message->created_at->format('Y-m-d H:i:s') : '');
            $rowRes->is_group = 0;
            $rowRes->group_name = '';
            // $rowRes->user_id = '';
            $rowRes->last_message = isset($last_message) ? $last_message : new \StdClass;
            unset($rowRes->last_message->unique_id);
            unset($rowRes->last_message->socket_id);
            unset($rowRes->last_message->updated_at);
            unset($rowRes->last_message->status);
            // unset($rowRes->last_message->message_type);
            $rowRes->groupmember = [];
            $rowRes->message_count = unreadMessagesCount($user->id ,Auth::user()->id);
            $allData[] = $rowRes;
        }
        // groups
        $user_id = Auth::user()->id;
        $group_members = ChatGroupMember::select('id', 'group_id')->where('user_id',$user_id)->get();
        $group_ids = [];
        foreach($group_members as $group_member) {
            $group_ids[] = $group_member->group_id;
        }
        $groups = ChatGroup::whereIn('id', $group_ids)->with('groupmember', 'lastMessage.vendorShortDetail', 'lastMessage.documents')->get()->makeHidden(['updated_at'])->toArray();

        foreach($groups as $key => $group) {
            if ($group['last_message']) {
                if (empty($group['last_message']['message']) || $group['last_message']['message'] == '' || $group['last_message']['message'] == null) {
                    foreach ( $group['last_message']['documents'] as $document) {
                        $doc = $document['document'];
                    }
                    $groups[$key]['last_message']['message'] = encryptString($doc);
                    $groups[$key]['last_message']['vendor_short_detail'] = setEmptyData($group['last_message']['vendor_short_detail']);
                }
                $groups[$key]['last_message']['vendor_short_detail'] = setEmptyData($group['last_message']['vendor_short_detail']);
            }
            unset($groups[$key]['last_message']['documents']);
            unset($groups[$key]['last_message']['group_id']);
            unset($groups[$key]['last_message']['decrypted_msg']);
            $rowRes = new \StdClass;
            $rowRes->id = $group['id'];
            $rowRes->name = '';
            $rowRes->profile_url = $group['profile_url'];
            $rowRes->company_name = '';
            $rowRes->created_at = $group['created_at'];
            $rowRes->is_group = 1;
            $rowRes->group_name = $group['group_name'];
            // $rowRes->user_id = $group['user_id'];
            $rowRes->last_message = isset($groups[$key]['last_message']) ? setEmptyData($groups[$key]['last_message']) : new \StdClass;
            unset($rowRes->last_message->unique_id);
            unset($rowRes->last_message->socket_id);
            unset($rowRes->last_message->updated_at);
            unset($rowRes->last_message->status);
            // unset($rowRes->last_message->message_type);
            $rowRes->groupmember = setEmptyData($group['groupmember']);
            $rowRes->message_count = 0;
            $userGroup[] = $rowRes;
        }
        ///
        $allData = array_merge($allData, $userGroup);
        $result = setEmptyData(collect($allData)->sortByDesc('created_at')->toArray());
        array_splice($result,1,0);
        return $result;
        }
    }

    public function chatWeb()
    {
        // if ((Auth::user()->user_type == 1) || (Auth::user()->user_type == 2) || (Auth::user()->user_type == 3)) {
        if ((Auth::user()->user_type == 1) || (Auth::user()->user_type == 2) || (Auth::user()->user_type == 3)) {
            $users = User::where('id', '!=', Auth::user()->id)->get();
            $allData = [];
            $userGroup = [];
            foreach($users as $user) { 
                $last_message =  ChatMsg::with('vendorShortDetail')->where(function($query) use($user){
                    $query->where('from', $user->id)->where('user_id', Auth::user()->id);
                })->orWhere(function($query) use($user){
                    $query->where('from', Auth::user()->id)->where('user_id', $user->id);
                })->orderBy('id', 'desc')->latest()->first();
                if ($last_message) {
                    if ($last_message->message == null) {
                        foreach ( $last_message->documents as $document) {
                            $doc = $document->document;
                        }
                        $last_message->message = $doc;
                        $last_message->makeHidden(['documents']);
                    }
                    $last_message = $last_message->toArray();
                    $last_message['vendor_short_detail'] = setEmptyData($last_message['vendor_short_detail']);
                }
                unset($last_message['group_id']);
                $rowRes = new \StdClass;
                $rowRes->id = $user->id;
                $rowRes->name = $user->name;
                $rowRes->profile_url = $user->image;
                $rowRes->user_type = isset($user->user_type) ? $user->user_type : '';
                $rowRes->created_at = (isset($last_message['created_at']) ? $last_message['created_at'] : '');
                $rowRes->is_group = 0;
                $rowRes->group_name = '';
                // $rowRes->user_id = '';
                $rowRes->last_message = isset($last_message) ? setEmptyData($last_message) : new \StdClass();
                unset($rowRes->last_message->unique_id);
                unset($rowRes->last_message->socket_id);
                unset($rowRes->last_message->updated_at);
                unset($rowRes->last_message->status);
                // unset($rowRes->last_message->message_type);
                $rowRes->groupmember = [];
                $rowRes->message_count = unreadMessagesCount($user->id ,Auth::user()->id);
                $rowRes->last_message_time = isset($last_message) ? (is_array($last_message) ? $last_message['created_at'] : $last_message->created_at) : '';
                $allData[] = $rowRes;
            }
            // groups
            $user_id = Auth::user()->id;
            $group_members = ChatGroupMember::select('id', 'group_id')->where('user_id',$user_id)->get();
            $group_ids = [];
            foreach($group_members as $group_member) {
                $group_ids[] = $group_member->group_id;
            }
            $groups = ChatGroup::whereIn('id', $group_ids)->with('groupmember', 'lastMessage.vendorShortDetail', 'lastMessage.documents')->get()->makeHidden(['updated_at'])->toArray();

            foreach($groups as $key => $group) {
                if (setEmptyData($group['last_message'])) {
                    if (empty($group['last_message']['message'])) {
                        foreach ( $group['last_message']['documents'] as $document) {
                            $doc = $document['document'];
                        }
                        $group['last_message']['message'] = $doc;
                        $groups[$key]['last_message']['vendor_short_detail'] = setEmptyData($group['last_message']['vendor_short_detail']);
                    }
                    $groups[$key]['last_message']['vendor_short_detail'] = setEmptyData($group['last_message']['vendor_short_detail']);
                }
                unset($groups[$key]['last_message']['documents']);
                unset($groups[$key]['last_message']['group_id']);
                $rowRes = new \StdClass;
                $rowRes->id = $group['id'];
                $rowRes->name = '';
                $rowRes->profile_url = $group['profile_url'];
                $rowRes->company_name = '';
                $rowRes->created_at = $group['created_at'];
                $rowRes->is_group = 1;
                $rowRes->group_name = $group['group_name'];
                // $rowRes->user_id = $group['user_id'];
                $rowRes->last_message = isset($groups[$key]['last_message']) ? setEmptyData($groups[$key]['last_message']) : new \StdClass();
                unset($rowRes->last_message->unique_id);
                unset($rowRes->last_message->socket_id);
                unset($rowRes->last_message->updated_at);
                unset($rowRes->last_message->status);
                // unset($rowRes->last_message->message_type);
                $rowRes->groupmember = setEmptyData($group['groupmember']);
                $rowRes->message_count = 0;
                $rowRes->last_message_time = isset($groups[$key]['last_message']) ? (is_array($groups[$key]['last_message']) ? $groups[$key]['last_message']['created_at'] : $groups[$key]['last_message']->created_at) : '';
                $userGroup[] = $rowRes;
            }
            ///
            $allData = array_merge($allData, $userGroup);
            $result = setEmptyData(collect($allData)->sortByDesc('last_message_time')->toArray());
            foreach ($result as $res) {
                unset($res->last_message_time);
            }
            array_splice($result,1,0);
            return $result;     
           
        } else {
        $generatChats = ChatMsg::where('user_id', Auth::user()->id)->pluck('from');
        $users = User::whereIn('user_type',[1 , 2, 3])->get();
        $allData = [];
        $userGroup = [];
        foreach($users as $user) {
            $last_message =  ChatMsg::with('vendorShortDetail')->where(function($query) use($user){
                $query->where('from', $user->id)->where('user_id', Auth::user()->id);
            })->orWhere(function($query) use($user){
                $query->where('from', Auth::user()->id)->where('user_id', $user->id);
            })->orderBy('id', 'desc')->latest()->first();
            if ($last_message) {
                if ($last_message->message == null) {
                    foreach ( $last_message->documents as $document) {
                        $doc = $document->document;
                    }
                    $last_message->message = $doc;
                    $last_message->makeHidden(['documents']);
                }
                $last_message = $last_message->toArray();
                $last_message['vendor_short_detail'] = setEmptyData($last_message['vendor_short_detail']);
            }
            unset($last_message['group_id']);
            $rowRes = new \StdClass;
            $rowRes->id = $user->id;
            $rowRes->name = $user->name;
            $rowRes->profile_url = $user->image;
            $rowRes->user_type = isset($user->user_type) ? $user->user_type : '';
            $rowRes->created_at = (isset($last_message->created_at) ? $last_message->created_at->format('Y-m-d H:i:s') : '');
            $rowRes->is_group = 0;
            $rowRes->group_name = '';
            // $rowRes->user_id = '';
            $rowRes->last_message = isset($last_message) ? $last_message : new \StdClass;
            unset($rowRes->last_message->unique_id);
            unset($rowRes->last_message->socket_id);
            unset($rowRes->last_message->updated_at);
            unset($rowRes->last_message->status);
            // unset($rowRes->last_message->message_type);
            $rowRes->groupmember = [];
            $rowRes->message_count = unreadMessagesCount($user->id ,Auth::user()->id);
            $allData[] = $rowRes;
        }
        // groups
        $user_id = Auth::user()->id;
        $group_members = ChatGroupMember::select('id', 'group_id')->where('user_id',$user_id)->get();
        $group_ids = [];
        foreach($group_members as $group_member) {
            $group_ids[] = $group_member->group_id;
        }
        $groups = ChatGroup::whereIn('id', $group_ids)->with('groupmember', 'lastMessage.vendorShortDetail', 'lastMessage.documents')->get()->makeHidden(['updated_at'])->toArray();

        foreach($groups as $key => $group) {
            if ($group['last_message']) {
                if (empty($group['last_message']['message'])) {
                    foreach ( $group['last_message']['documents'] as $document) {
                        $doc = $document['document'];
                    }
                    $group['last_message']['message'] = $doc;
                    $groups[$key]['last_message']['vendor_short_detail'] = setEmptyData($group['last_message']['vendor_short_detail']);
                }
                $groups[$key]['last_message']['vendor_short_detail'] = setEmptyData($group['last_message']['vendor_short_detail']);
            }
            unset($groups[$key]['last_message']['documents']);
            unset($groups[$key]['last_message']['group_id']);
            $rowRes = new \StdClass;
            $rowRes->id = $group['id'];
            $rowRes->name = '';
            $rowRes->profile_url = $group['profile_url'];
            $rowRes->company_name = '';
            $rowRes->created_at = $group['created_at'];
            $rowRes->is_group = 1;
            $rowRes->group_name = $group['group_name'];
            // $rowRes->user_id = $group['user_id'];
            $rowRes->last_message = isset($groups[$key]['last_message']) ? setEmptyData($groups[$key]['last_message']) : new \StdClass;
            unset($rowRes->last_message->unique_id);
            unset($rowRes->last_message->socket_id);
            unset($rowRes->last_message->updated_at);
            unset($rowRes->last_message->status);
            // unset($rowRes->last_message->message_type);
            $rowRes->groupmember = setEmptyData($group['groupmember']);
            $rowRes->message_count = 0;
            $userGroup[] = $rowRes;
        }
        ///
        $allData = array_merge($allData, $userGroup);
        $result = setEmptyData(collect($allData)->sortByDesc('created_at')->toArray());
        array_splice($result,1,0);
        return $result;
        }
    }
}
