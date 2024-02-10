<?php

namespace App\Services;

use App\Models\Board;
use App\Models\ForumBoardActivities;
use Illuminate\Support\Facades\Storage;
use App\Models\ForumBoardMember;
use App\Models\ForumTopic;
use App\Models\TopicComments;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForumTopicService
{
    public static function view($id, $isView = true)
    {
        if ($isView) {
            ForumTopic::where('id', $id)
                ->update([
                    'topic_views' => DB::raw('topic_views + 1'),
                ]);
        }

        $forum_topic = ForumTopic::find($id);
        $comments = TopicComments::where(['forum_board_id' => $forum_topic['forum_board_id'], 'topicommentable_id' => $forum_topic->id])
                ->where('parent_id',null)
                ->with([
                    'attachments',
                    'replies' => function ($query) {
                        $query->with('attachments'); // Load attachments for replies
                    },
                    'replies.user' => function ($query) {
                        $query->select('id','name','username','email','created_at');
                    },
                    'user' => function ($query) {
                        $query->select('id','name','username','email','created_at');
                    }
                ])
                ->withCount(([
                    'likes', 
                    'likes as likes_count' => function ($query) {
                        $query->where('is_like', '=', 1);
                    }])
                )->get();

                $comments->each(function ($comment) {
                    $comment->comment_time = Carbon::parse($comment->created_at)->format('H:i');

                    $comment->replies->each(function ($reply) {
                        $reply->comment_time = Carbon::parse($reply->created_at)->format('H:i');
                    });
                });
                
        $forum_topic['comment'] = $comments;
        $forum_topic['topic_comment_count'] = count($forum_topic['comment']);
        $forum_topic['topic_reply_count'] = TopicComments::where('forum_board_id', $forum_topic['forum_board_id'])->count();
        $forum_topic['voices'] = ForumBoardActivities::select('followers')->where('followers', '!=', 'null')->where('topic_id', $forum_topic['id'])->count();
        $forum_topic['user'] = User::select('id', 'name', 'username', 'image', 'user_type', 'created_at')->find($forum_topic->user_id);
        $forum_topic['board'] = Board::select('board_name', 'discription')->find($forum_topic->forum_board_id);
        $forum_topic['attachments_url'] = $forum_topic->attachments->pluck('attachment')
            ->map(function ($attachment) {
                return url('forum_topic/' . $attachment);
            })
            ->toArray();
        $forum_topic['creted_date'] = Carbon::parse($forum_topic['created_at'])->format('d M, Y');
        $forum_topic['is_following'] = ForumBoardActivities::where('user_id', Auth::id())->where('topic_id', $forum_topic->id)->count() ? true : false;
        $forum_topic['followers_count'] = ForumBoardActivities::where('topic_id', $forum_topic->id)->count();
        unset($forum_topic['attachments']);

        return $forum_topic;
    }
}
