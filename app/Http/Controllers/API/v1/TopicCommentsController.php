<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Models\TopicComments;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;
use App\Models\CommentAttachment;
use App\Models\ForumTopic;
use App\Models\User;
use App\Services\TopicCommentService;

class TopicCommentsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_comment(Request $request)
    {
        $comments = TopicComments::where('commented_by', Auth::user()->id)->get();

        if($request->is('api/*')) {
            return $this->sendResponse($comments, 'Comments retrieved successfully.');
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
    public function store_comment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'forum_id' => 'required',
            'topic_id' => 'required',
            'comments' => 'required'
        ]);
   
        if($validator->fails()){
            if($request->wantsJson()) {
                return $this->sendError('Validation Error.', $validator->errors(), 400);

            } else {
                return Redirect::back()->withErrors($validator->errors());
            }
        } 
        
        $input = $request->all();
        $input['commented_by'] = Auth::user()->id;

        $comment = TopicComments::create($input);

        if($request->wantsJson()) {
            return $this->sendResponse($comment, 'Comment added successfully.');
        } else {
            return redirect()->route('user.home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TopicComments  $TopicComments
     * @return \Illuminate\Http\Response
     */
    public function show(TopicComments $TopicComments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TopicComments  $TopicComments
     * @return \Illuminate\Http\Response
     */
    public function edit_comment(Request $request, $id)
    {
        $comment = TopicComments::where('id', $id)->where('commented_by', Auth::user()->id)->first();
    
        if (is_null($comment)) {
            return $this->sendError('Comment not found.', [], 403);
        } else {
            if($request->wantsJson()) {
                return $this->sendResponse($comment, 'Comment retrieved successfully.');
            } else {
                return redirect()->route('user.home');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TopicComments  $TopicComments
     * @return \Illuminate\Http\Response
     */
    public function update_comment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'forum_id' => 'required',
            'topic_id' => 'required',
            'comments' => 'required'
        ]);
   
        if($validator->fails()){
            if($request->wantsJson()) {
                return $this->sendError('Validation Error.', $validator->errors());

            } else {
                return Redirect::back()->withErrors($validator->errors());
            }
        } 
        
        $input = $request->all();
        if(Auth::user()->user_type != "1"){
            $input['commented_by'] = Auth::user()->id;
        }
        TopicComments::where('id', $id)->update($input);

        $comment = TopicComments::find($id);

        if($request->wantsJson()) {
            return $this->sendResponse($comment, 'Comment updated successfully.');
        } else {
            return redirect()->route('user.home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TopicComments  $TopicComments
     * @return \Illuminate\Http\Response
     */
    public function delete_comment(Request $request, $id)
    {
        $comment = TopicComments::where('id', $id)->where('commented_by', Auth::user()->id)->first();

        if(!empty($comment)) {
            $comment->delete();

            if($request->wantsJson()) {
                return $this->sendResponse([], 'Comment deleted successfully.');
            } else {
                return redirect()->route('user.home');
            }
        } else {
            return $this->sendError('Comment not found.', [], 403);
        }
    }

    public function index(ForumTopic $topic, Request $request)
    {
        $topic_comments = TopicComments::whereHas('topic', function ($query) use ($topic) {
            $query->where('id', $topic->id);
            return $query;
        })
        ->with(['user','replies.user'])
        ->whereNull('parent_id')
        ->orderBy('id', 'DESC');
        $perPage = $request->query('per_page', 10);
        $topic_comments = $topic_comments->paginate($perPage);
        return sendResponse(compact('topic','topic_comments'), 'Topic comments listed successfully.');
    }

    public function store(ForumTopic $topic, TopicComments $topicComment, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'forum_board_id' => 'required',
            'comment_text' => 'required',
            'image'=> 'nullable'
        ],
        [
            'forum_board_id.required' => 'Please enter forum board id',
            'comment_text.required' => 'Please enter the comment',
        ]);
        
        if($validator->fails()){
            return response()->json(
                [
                    'status' => 422,
                    'statusState' => 'error',
                    'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                ],422
            );       
        }
        $topicComment = TopicCommentService::createUpdate($topic,TopicComments::where('id',$request->id)->first() ?? $topicComment, $request);

        $attachment_url = $topicComment->attachments->isNotEmpty() ? url('comment_attechments/' . $topicComment->attachments->first()->attachment) : null;
        $topic_comments = TopicComments::orderBy('id', 'DESC')->first();
        $topic_comments = $topic_comments->toArray();
        $topic_comments['attachment_urls'] = $attachment_url;
        $message = 'Topic comment added successfully.';
        return sendResponse($topic_comments, $message);
    }
    
    public function destroy(ForumTopic $topic, TopicComments $topicComment, Request $request)
    {
        if ($topicComment->parent_id != null) {
            $topicComment->delete();
            $topic_comments = TopicComments::with(['user','replies.user'])
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC')->first();
            $message = 'Topic Comment deleted successfully.';
            return sendResponse($topic_comments, $message);
        } else {
            $topic_comments = TopicComments::with(['user','replies.user'])
            ->whereNull('parent_id')
            ->orderBy('id', 'DESC')->first();
            $topicComment->delete();
            $message = 'Topic Comment deleted successfully.';
            return sendResponse($topic_comments, $message);
        }
    }

    public function delteAttechment(Request $request,$id){
        $attachment = CommentAttachment::where('id', $id)->first();

        if(!empty($attachment)) {
            if (!empty($attachment->attachment)) {
                $image_path = public_path('comment_attechments/'. $attachment->attachment);
                DeleteImage($image_path);
            }
            $attachment->delete();

            return $this->sendResponse([], 'Attachment deleted successfully.');
        } else {
            return $this->sendError('Attachment not found.', [], 403);
        }
    }
}
