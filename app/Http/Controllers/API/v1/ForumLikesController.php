<?php

namespace App\Http\Controllers\API\v1;

use App\Models\ForumLikes;
use App\Models\ForumTopic;
use Illuminate\Http\Request;
use App\Models\ForumComments;
use App\Models\TopicComments;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;

class ForumLikesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_like(Request $request)
    {
        $likes = ForumLikes::where('like_by', Auth::user()->id)->get();

        if ($request->is('api/*')) {
            return $this->sendResponse($likes, 'Likes retrieved successfully.', 200);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function TopicCommentLike(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'topic_id' => 'required',
                    'topic_comment_id' => 'required',
                ],
                [
                    'topic_id.required' => 'Please enter topic id',
                    'topic_comment_id.required' => 'Please enter Topic comment id',
                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 402,
                        'statusState' => 'error',
                        'message' => (empty($validator->errors())
                            ? 'Something went wrong'
                            : $validator->errors()
                        )->first(),
                    ],
                    402
                );
            }

            $topic_id = $request->topic_id;
            $topic_comment_id = $request->topic_comment_id;

            $topic_comment_like = ForumLikes::where('topic_id', $topic_id)->where('topic_comment_id', $topic_comment_id)->where('user_id',Auth::user()->id)->first();
            if(!empty($topic_comment_like)){
                if($topic_comment_like->is_like == 1){
                    $topic_comment_like->is_like = 0;
                } else if($topic_comment_like->is_like == 0){
                    $topic_comment_like->is_like = 1;
                }
            } else {
                $topic_comment_like = new ForumLikes();   
                $topic_comment_like->is_like = 1;
            }
            $topic_comment_like->user_id = Auth::user()->id;
            $topic_comment_like->topic_id = $topic_id;
            $topic_comment_like->topic_comment_id = $topic_comment_id;
            $topic_comment_like->save();

            $count_is_like = ForumLikes::where('topic_id', $topic_id)->where('is_like', 1)->get();
            $topic_comment_like['count_is_like'] =  !empty($count_is_like) ? count($count_is_like) : 0;
            $message = $topic_comment_like->is_like ? 'Topic Comment like successfully.' : 'Topic Comment unlike successfully.';

            return $this->sendResponse($topic_comment_like, $message, 200);
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }
}
