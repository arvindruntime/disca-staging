<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;

class ReplyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_reply(Request $request)
    {
        $reply = Reply::where('replied_by', Auth::user()->id)->where('status',1)->get();

        if($request->is('api/*')) {
            return $this->sendResponse($reply, 'Reply retrieved successfully.');
        } else {
            return redirect()->route('user.home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_reply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'forum_id' => 'required',
            'topic_id' => 'required',
            'comment_user_id' => 'required',
            'replies' => 'required'
        ]);
   
        if($validator->fails()){
            if($request->wantsJson()) {
                return $this->sendError('Validation Error.', $validator->errors(), 400);

            } else {
                return Redirect::back()->withErrors($validator->errors());
            }
        } 
        
        $input = $request->all();
        $input['replied_by'] = Auth::user()->id;
        $reply = Reply::create($input);

        if($request->wantsJson()) {
            return $this->sendResponse($reply, 'Reply created successfully.');
        } else {
            return redirect()->route('user.home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit_reply(Request $request, $id)
    {
        $reply = Reply::where('id', $id)->where('replied_by', Auth::user()->id)->first();
    
        if (is_null($reply)) {
            return $this->sendError('Reply not found.', [], 403);
        } else {
            if($request->wantsJson()) {
                return $this->sendResponse($reply, 'Reply retrieved successfully.');
            } else {
                return redirect()->route('user.home');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update_reply(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'forum_id' => 'required',
            'topic_id' => 'required',
            'comment_user_id' => 'required',
            'replies' => 'required'
        ]);
   
        if($validator->fails()){
            if($request->wantsJson()) {
                return $this->sendError('Validation Error.', $validator->errors());

            } else {
                return Redirect::back()->withErrors($validator->errors());
            }
        } 
        
        $input = $request->all();
        $input['replied_by'] = Auth::user()->id;
        Reply::where('id', $id)->update($input);

        $reply = Reply::find($id);

        if($request->wantsJson()) {
            return $this->sendResponse($reply, 'Reply updated successfully.');
        } else {
            return redirect()->route('user.home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function delete_reply(Request $request, $id)
    {
        $reply = Reply::where('id', $id)->where('replied_by', Auth::user()->id)->first();

        if(!empty($reply)) {
            $reply->delete();

            if($request->wantsJson()) {
                return $this->sendResponse([], 'Reply deleted successfully.');
            } else {
                return redirect()->route('user.home');
            }
        } else {
            return $this->sendError('Reply not found.', [], 403);
        }
    }
}
