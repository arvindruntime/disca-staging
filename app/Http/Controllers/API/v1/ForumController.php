<?php

namespace App\Http\Controllers\API\v1;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Forum;
use App\Models\Reply;
use App\Models\ForumTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;
use App\Models\Board;
use App\Models\ForumBoardActivities;
use App\Models\TopicComments;

class ForumController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_forum_boards(Request $request)
    {
        $perPage = $request->input('per_page', 2);
        $forum = Board::paginate($perPage);
        $loggedInUserId = Auth::user()->id;
        
        foreach ($forum as $key => $value) {
            $forum[$key]['topic_count'] =  ForumTopic::where('forum_board_id',$forum[$key]['id'])->where('status',1)->count();
            $forum[$key]['topic_reply_count'] = TopicComments::where('forum_board_id',$forum[$key]['id'])->count();
            $forum[$key]['creted_date'] = Carbon::parse($forum[$key]['created_at'])->format('d M, Y');
            $forum[$key]['voices'] =  ForumBoardActivities::where('forum_board_id',$forum[$key]['id'])->count();
            $forum[$key]['is_following'] = (int)ForumBoardActivities::where('forum_board_id', $value['id'])
                                                                ->where('user_id', $loggedInUserId)
                                                                ->exists();
            
            $topicDetails = [];
            $topic = ForumTopic::where('forum_board_id',$value['id'])->where('status',1)->limit(4)->get();
            foreach ($topic as $topicItem) {

                if ($topicItem->forum_board_id == $value->id) {                    
                    $userDetails = User::select('id','name','user_type','created_at')->find($topicItem->user_id);
                    $topic_reply = TopicComments::where('topicommentable_id',$topicItem->id)->count();
                    $topic_views = ForumTopic::select('topic_views')->where('forum_board_id',$topicItem->forum_board_id)->get();
                    $topicDetails[] = [
                        'id' => $topicItem->id,
                        'forum_board_id' => $topicItem->forum_board_id,
                        'user_id' => $topicItem->user_id,
                        'title' => $topicItem->title,
                        'description' => $topicItem->description,
                        'status' => $topicItem->status,
                        'repilies' => $topic_reply,
                        'topic_views' =>  $topic_views[0]['topic_views'],
                        'created_at' => Carbon::parse($topicItem->created_at)->format('d M, Y'),
                        'user' => $userDetails,
                    ];
                } 
            }
        
            $forum[$key]['topic_detailes'] = $topicDetails;
            $message = 'Forum retrieved successfully.';
        }
        if ($request->wantsJson()) {
            return $this->sendResponse($forum, $message);
        } else {
            return view('forum.discussion', compact('forum'));
        }
    }
}
