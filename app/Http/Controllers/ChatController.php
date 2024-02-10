<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatMsg;
use App\Models\ChatGroup;
use Illuminate\Http\Request;
use App\Models\ChatGroupMember;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Models\ChatConnection;

class ChatController extends Controller
{
    public function __construct(ChatMsg $chat, UserRepository $user, UserRepository $_user)
    {
        $this->_chat = $chat;
        $this->user = $user;
        $this->_user = $_user;
    }  
    
    function testmsgsequence()
    {
        return view('forum.chat');
    }
    
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $group_members = ChatGroupMember::select('id', 'group_id')->where('user_id',$userId)->get();
        $group_ids = [];
        foreach($group_members as $group_member) {
            $group_ids[] = $group_member->group_id;
        }
        $groups = ChatGroup::whereIn('id', $group_ids)->with('groupmember', 'lastMessage.vendor')->get();
        foreach($groups as $group) {
            if ($group->lastMessage) {
                if (empty($group->lastMessage->message)) {
                    foreach ( $group->lastMessage->documents as $document) {
                        $doc = $document->document;
                    }   
                    $group->lastMessage->message = $doc;
                }
            }
        }       
        $memberList = User::select(
            'users.id',
            'users.name',
            'users.user_type',
            'users.image as profile_image',
            DB::raw('(SELECT message FROM chat_msgs WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1) AS last_chat_message'), // Retrieve the last chat message
            DB::raw('(SELECT created_at FROM chat_msgs WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1) AS last_chat_time'), // Retrieve the last chat time
            DB::raw('(SELECT COUNT(*) FROM chat_msgs WHERE user_id = users.id) AS chat_count') // Retrieve the count of chat messages
        );
        
        $search = $request->query('search');
        if ($search) {
            $memberList->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', "%$search%");
            });
        }
        
        $perPage = $request->query('per_page', 10);
        $chatMemberLists = $memberList->paginate($perPage);
    
        $generatChats = ChatMsg::where('user_id', Auth::user()->id)->pluck('from');
        // $results = User::where('status', 1)->get();
        $results = User::select(
            '*',
            DB::raw("CASE 
            WHEN user_type = 1 THEN 'Admin'
            WHEN user_type = 2 THEN 'Provider'
            WHEN user_type = 3 THEN 'Forum'
            ELSE 'Normal'
            END AS user_role")
            )->where('status', 1)->get();
            $allData = [];
            foreach($results as $user) {
                $last_message =  ChatMsg::where(function($query) use($user){
                    $query->where('from', $user->id)->where('user_id', Auth::user()->id);
                })->orWhere(function($query) use($user){
                    $query->where('from', Auth::user()->id)->where('user_id', $user->id);
                })->orderBy('id', 'desc')->latest()->first();
                // dd($last_message);
                // $last_message->message == null
                // if(!empty($last_message) && isset($last_message)){
                    //     foreach ( $last_message->documents as $document) {
                        //         $doc = $document->document;
                        //     }   
                        //     $last_message->message = $doc;
                        //     $last_message->makeHidden(['documents']);
                        // }
                        
                        $rowRes = new \StdClass;
                        $rowRes->id = $user->id;
                        $rowRes->name = $user->name;
                        $rowRes->user_type = $user->user_role;
                        $rowRes->profile_image = ($user->profile_image) ? asset('storage/profile/' . $user->profile_image) : asset('images/icon/user_img.png');
                        
                        $rowRes->created_at = (isset($last_message->created_at) ? $last_message->created_at->format('Y-m-d H:i:s') : '');
                        $rowRes->last_message = $last_message;
                        $rowRes->message_count = unreadMessagesCount($user->id ,Auth::user()->id);
                        $rowRes->allMessageCount = allMessageCount(Auth::user()->id);
                        $allData[] = $rowRes;
                    }
                    $users = (collect($allData)->sortByDesc('created_at')->toArray());
        
                    $users = $this->_user->chatUsers();
                    $chat_usr_grps = $this->_user->chatWeb();
                    $all_users = $this->_user->allUsers();
                    
                    // dd($users);
                    array_splice($users,1,0);        
                    $message = 'Chat user listed successfully.';
                    if(!empty($users)) {
            if($request->wantsJson()) {  
                
                // $final_result['chatMemberLists'] = $chatMemberLists;
                $final_result['users'] = $users;
                $final_result['chat_usr_grps'] = $chat_usr_grps;
                $final_result['groups'] = $groups;
                $final_result['all_users'] = $all_users;
                                
                return sendResponse($final_result,$message);
                // dd($final_result);
            } else {
                if ($request->ajax()) {
                    $view = view('forum.chat.chat_users_xhr',compact('users', 'chat_usr_grps', 'groups', 'all_users'))->render();
                    return response()->json(['html'=>$view]);
                }
                    return view('forum.chat.index' ,  compact('users', 'chat_usr_grps', 'groups', 'all_users'));
                    //'chatMemberLists', 
            }
 
        } else {
            return sendError('Error occurred.');
        }
        
        
        //////////////////////////////////  New chat system code /////////////
        
        
        // $users = $this->_user->chatUsers();
        // $chat_usr_grps = $this->_user->chatWeb();
        // $all_users = $this->_user->allUsers();
        // return view('forum.chat.index', compact('users', 'chat_usr_grps', 'groups', 'all_users'));
    }
    
    public function showChatMessage(Request $request, $id)
    {
        $chatMemberLists = $this->_chat->where('from', $id)
            ->where('user_id', Auth::user()->id)
            ->where('status', '!=', 2);
        $chatMemberLists->update([ 'status' => 2 ]);
        return $this->_chat->with(['vendor', 'documents'])
                ->whereNull('group_id')
                ->where(function ($query) use ($id) {
                    return $query->where('from', $id)->where('user_id', Auth::user()->id);
                })->orWhere(function ($query) use ($id) {
                    return $query->where('user_id', $id)->where('from', Auth::user()->id);
                })->orderBy('created_at', 'DESC')->paginate(30);
                
        // $chatMemberLists = $this->_chat->where('from', $id)
        //                                ->where('user_id', Auth::user()->id)
        //                                ->where('status', '!=', 2);
                                                                  
        
        $from_user_data = $this->_user->find($id);
        
        // dd($from_user_data);
        
        // $chatMemberLists->update([ 'status' => 2 ]);
        // $chatMemberLists = $this->_chat->with(['vendor', 'documents'])
        // ->whereNull('group_id')
        // ->where(function ($query) use ($id) {
        //     $chatMemberLists = $query->where('from', $id)->where('user_id', Auth::user()->id);
        // })->orWhere(function ($query) use ($id) {
        //     $chatMemberLists = $query->where('user_id', $id)->where('from', Auth::user()->id);
        // })->orderBy('created_at', 'DESC')->paginate(30);
        
        // dd($chatMemberLists);
        
        
        $chatMemberLists['from_user'] = $from_user_data;
        $message = 'Chat user fetched successfully.';   
               
        if($request->wantsJson()) { 
            return sendResponse($chatMemberLists, $message);
        } else {
            if ($request->ajax()) {
                return $chatMemberLists;
            }
            return view('forum.chat.index' ,  compact('chatMemberLists'));
        } 
    }
    
    
    ////////////// Start API function creation
    
    public function deleteConnection($socket_id)
    {
        try {
            $query = "DELETE FROM chat_connections WHERE socket_id = ?";
            DB::delete($query, [$socket_id]);

            $message = 'Connection deleted successfully!';
            return sendResponse([], $message);
        } catch (\Exception $e) {
            $message = 'Failed to delete connection!';
            return sendResponse([], $message);
        }
    }
    
    public function userConnection(Request $request)
    {
        try {
            // Check if the user already has a connection
            $existingConnection = ChatConnection::where('socket_id', $request->socket_id)->first();
            if (!$existingConnection) {
                // Create a new connection record
                $newConnection = new ChatConnection([
                    'user_id' => $request->user_id,
                    'vendor_id' => $request->user_id, // Assuming vendor_id should be set to user_id
                    'socket_id' => $request->socket_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $newConnection->save();
            }

            $message = 'Connection success!';
            return sendResponse($existingConnection, $message);
        } catch (\Exception $e) {
            $message = 'Connection faild!';
            return sendResponse('', $message);
        }
    }

    public function findUserSocket($user_id)
    {
        try {
            $result = ChatConnection::where('user_id', $user_id)->first();
            
            
            if ($result) {
                $message = 'Connection fetched successfully!';
                // return ['success' => true, 'socket_id' => $result->socket_id];
                return sendResponse($result, $message);
            } else {
                $message = 'No record found!';
                // return ['success' => false, 'socket_id' => ''];
                return sendResponse($result, $message);
            }
        } catch (\Exception $e) {
            // return ['success' => false, 'socket_id' => ''];
            $message = 'Something went wrong!';
            return sendResponse('', $message);
        }
    }
    
    public function updateMessageStatus(Request $request)
    {
        // Assuming you get the required parameters from the request
        
        
        $uuids = $request->input('unique_id', []);
        $uuids = array_map(function ($uuid) {
            return "'" . $uuid . "'";
        }, $uuids);

        $query = "UPDATE chat_msgs SET status = 2 WHERE unique_id IN (" . implode(',', $uuids) . ")";        
        
        try {
            $rs = DB::update($query);
            $message = 'Message status updated successfully.';
            return sendResponse([], $message);
        } catch (\Exception $e) {
            $message = 'Failed to update message status.';
            return sendResponse([], $message);
        }
    }
    
    public function findVendorUserSockets(Request $request)
    {
        // Assuming you get the required parameters from the request
        $userIds = $request->input('user_ids', []);

        if (!is_array($userIds) || empty($userIds)) {
            $message = 'Invalid user_ids provided.';
            return sendResponse([], $message);
        }

        $query = "SELECT * FROM chat_connections WHERE user_id IN ('" . implode("','", $userIds) . "') OR vendor_id IN ('" . implode("','", $userIds) . "')";
                
        try {
            $results = DB::select($query);
            $finalResults = [];
            
            foreach ($results as $result) {
                $finalResults[] = (array) $result;
            }

            if (!empty($finalResults)) {
                $message = 'Vendor user sockets found successfully.';
                return sendResponse($finalResults, $message);
            }

            $message = 'No vendor user sockets found.';
            return sendResponse([], $message);
        } catch (\Exception $e) {
            $message = 'Failed to find vendor user sockets.';
            return sendResponse([], $message);
        }
    }

    public function storeMessage(Request $request)
    {
        $message = $request->input('message');
        $socket_id = $request->input('socket_id');
        $toUserId = $request->input('user_id');
        $fromUser = Auth::user();
        $unique_id = $request->input('unique_id');
        $documents = $request->input('documents', []);
        
        
        $message = trim($message);
        $datetime = now();
        $now = $datetime->toDateTimeString();
        
        $chatMsg = new ChatMsg();
        $chatMsg->message = $message;
        $chatMsg->socket_id = $socket_id;
        $chatMsg->user_id = $toUserId;
        $chatMsg->from = $fromUser['id'];
        $chatMsg->created_at = $now;
        $chatMsg->updated_at = $now;
        $chatMsg->unique_id = $unique_id;
        $chatMsg->is_msg_encrypted = 1;
        $chatMsg->save();
        $finalResults = [];
        
        if (!empty($documents)) {
            foreach ($documents as $element) {
                $chatDocument = new ChatDocument();
                $chatDocument->chat_msg_id = $chatMsg->id;
                $chatDocument->document = $element['name'];
                $chatDocument->created_at = $now;
                $chatDocument->updated_at = $now;
                $chatDocument->save();
    
                $documentUrl = env('APP_URL') . '/storage/chats/' . $fromUser['id'] . '/' . $chatDocument->document;
                $finalDocuments[] = [
                    'id' => $chatDocument->id,
                    'document' => $chatDocument->document,
                    'created_at' => $chatDocument->created_at,
                    'updated_at' => $chatDocument->updated_at,
                    'document_url' => $documentUrl,
                ];
            }
            $chatMsgWithDocuments->documents = $finalDocuments;
        }
        
        $chatMsgWithDocuments = ChatMsg::with('user')->find($chatMsg->id);
        
        
        $message = 'Chat stored successfully';
        return sendResponse($chatMsgWithDocuments, $message);
        
    }
    
    public function storeChatImage(Request $request)
    {
        $request->validate([
            'documents' => 'required|array|max:10',
            'documents.*' => 'file|max:25600',
        ], [
            'documents.max' => 'File size exceeds maximum limit 25 MB.'
        ]);

        $path = storage_path('app/public/chats/' . Auth::user()->id . '/');

        $documents = [];
        foreach ($request->documents as $key => $file) {
            $name = uniqid() . '_' . $key . '_' . str_replace(' ', '-', trim($file->getClientOriginalName()));
            $file->move($path, $name);
            $link = asset('storage/chats/' . Auth::user()->id . '/' . $name);
            array_push($documents, [
                'link'          => $link,
                'name'          => $name,
                'original_name' => $file->getClientOriginalName(),
            ]);
        }
        
        $message = 'File uploaded successfully';
        if($request->wantsJson()) { 
            return sendResponse($documents, $message);
        } else {
            return response()->json([
                'documents' => $documents
            ]);
        }
    }
    
    public function userChat(Request $request, $id)
    {
        $messages = $this->_chat->where('from', $id)
            ->where('user_id', Auth::user()->id)
            ->where('status', '!=', 2);
        $messages->update([ 'status' => 2 ]);
        return $this->_chat->with(['vendor', 'documents'])
                ->whereNull('group_id')
                ->where(function ($query) use ($id) {
                    return $query->where('from', $id)->where('user_id', Auth::user()->id);
                })->orWhere(function ($query) use ($id) {
                    return $query->where('user_id', $id)->where('from', Auth::user()->id);
                })->orderBy('created_at', 'DESC')->paginate(30);
    }
    
    
    
    public function groupChat(Request $request, $id)
    {
        return $this->_chat->with(['vendor', 'documents'])
                ->where(function ($query) use ($id) {
                    return $query->where('group_id', $id);
                })->orderBy('created_at', 'DESC')->paginate(30);
    }

    public function chats(Request $request, $id)
    {       
        $messages = $this->_chat->where('from', $id)
            ->where('user_id', Auth::guard('api')->user()->id)
            ->whereNull('group_id')
            ->where('status', '!=', 2);
        $messages->update([ 'status' => 2 ]);
        $chats = $this->_chat->with(['vendor', 'documents'])
            ->where(function ($query) use ($id) {
                return $query->where('from', $id)->where('user_id', Auth::guard('api')->user()->id);
            })->orWhere(function ($query) use ($id) {
                return $query->where('user_id', $id)->where('from', Auth::guard('api')->user()->id);
            })->orderBy('created_at', 'DESC')->paginate(30)->toArray();

        foreach ($chats['data'] as $key1 => $chat) {
            foreach ($chat['documents'] as $key => $document) {
                unset($chats['data'][$key1]['documents'][$key]['chat_msg']['decrypted_msg']);
            }
            unset($chats['data'][$key1]['decrypted_msg']);
        }
        return $chats;
    }
    
    public function store(Request $request)
    {
        $request->validate(
            [
            'message' => 'required',
            'user_id' => 'required'
            ]
        );

        $this->chat->store($data);
    }
    
    public function encodeString(Request $request)
    {
        $string = encryptString($request->string);
        return sendResponse([
            'string' => $string,
        ]);
    }

    public function decodeString(Request $request)
    {
        $string = decryptString($request->string);
        return sendResponse([
            'string' => $string,
        ]);
    }
    
    public function storeGroup(Request $request) 
    {
        $request->validate([
            'group_name' => 'required',
            'user_id' => 'required',
        ]);
         
        $group = [];
        $group = $request->except(['val[]', '_token']);
        $group_create = ChatGroup::create($group);
        $user_id = $group_create->user_id;
        $group_id = $group_create->id;
        foreach($group['val'] as $member) {
            $chat_member = ChatGroupMember::create(['group_id'=>$group_id,'user_id'=>$member]);

            $user = $chat_member->vendor;
            $data  = [
                'name' => $user->name,
                'title' => $group_create->group_name,
                'group_id' => $group_id,
                'user_id' => $group_create->user_id
            ];

            // Notification::send($user, new GroupChatInvitationNotification($data));
        }
        $chat_member = ChatGroupMember::create(['group_id'=>$group_id,'user_id'=>$user_id]);

        if($chat_member) {
            return sendResponse([
                'group_data' => $group_create,
                'group_chat_data' => $chat_member
            ]);
        }
    }
    
    public function getGroups()
    {
        $user_id = Auth::user()->id;
        $group_members = ChatGroupMember::select('id', 'group_id')->where('user_id',$user_id)->get();
        $group_ids = [];
        foreach($group_members as $group_member) {
            $group_ids[] = $group_member->group_id;
        }
        $groups = ChatGroup::whereIn('id', $group_ids)->with('groupmember', 'lastMessage.vendor')->get();
        foreach($groups as $group) {
            if ($group->lastMessage) {
                if (empty($group->lastMessage->message)) {
                    foreach ( $group->lastMessage->documents as $document) {
                        $doc = $document->document;
                    }   
                    $group->lastMessage->message = $doc;
                }
            }
        }
        return sendResponse([
            'groups' => $groups,
        ]);
    }
    
    public function deleteGroup(Request $request)
    {
        $group_member = ChatGroupMember::where('group_id', $request->group_id)->delete();
        $group = ChatGroup::where('id', $request->group_id)
                            ->where('user_id', Auth::user()->id)
                            ->delete();

        return sendResponse(['group_id' => $request->group_id], 'Group Deleted Successfully');
        
    }
    public function JoinMember(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:chat_groups,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $chat_group = ChatGroup::where('id',$request->group_id)->first();
        
        $group = ChatGroup::where('id',$request->group_id)->get();
        
        $add_member = ChatGroupMember::create(['group_id'=>$group[0]->id,'user_id'=>$request->user_id]);
        $user = $add_member->vendor;
        $data  = [
            'name' => $user->name,
            'title' => $chat_group->group_name,
            'group_id' => $request->group_id,
            'user_id' => $chat_group->user_id
        ];

        // Notification::send($user, new GroupChatInvitationNotification($data));

        return sendResponse([
            'group_data' => $group,
            'added_group_member' => $request->user_id
        ]);
    }
    
    public function RemoveMember(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:chat_groups,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $group = ChatGroup::where('id',$request->group_id)->get();
                
        $add_member = ChatGroupMember::where('group_id',$group[0]->id)->where('user_id',$request->user_id)->delete();

        return sendResponse([
            'group_data' => $group,
            'removed_group_member' => $request->user_id
        ]);
    }
    
    public function updateGroup(Request $request) 
    {
        $request->validate([
            'group_id' => 'required|exists:chat_groups,id',
            'group_name' => 'required',
            // 'group_profile' => 'nullable|sometimes|mimes:jpeg,jpg,png|max:2048'
        ]);
        $profile_changed = 0;
        $group = ChatGroup::find($request->group_id);
        $group->group_name = $request->group_name;
        if ($request->hasFile('group_profile') && !empty($request->file('group_profile'))) {
            $profile_changed = 1;
            Storage::delete('/public/profile/'.$group->profile_photo);
            $path = $request->file('group_profile');
            $imagename = time().'.'.$path->extension();
            $request->file('group_profile')->storeAs('public/profile/', $imagename);
            $group->profile_photo = $imagename;
        }
        $group->save();

        return sendResponse([
            'group_data' => $group,
            'profile_changed' => $profile_changed
        ], 'Group Updated Successfully');
    }
    
    public function leaveGroup(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
        ]);

        ChatGroupMember::where('group_id', $request->group_id)
                        ->where('user_id', Auth::user()->id)
                        ->delete();

        return sendResponse([
            'group_id' => $request->group_id,
            'user' => Auth::user()
        ]);

    }
}
