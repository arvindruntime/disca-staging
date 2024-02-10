<?php

namespace App\Services;

use App\Models\CommentAttachment;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use phpseclib3\Crypt\Common\PublicKey;

class TopicCommentService
{
    public static function createUpdate($topic, $topicComment, $request)
    {
        if (isset($request->parent_id)) {
            $topicComment->parent_id = $request->parent_id;
        }
        if (isset($request->forum_board_id)) {
            $topicComment->forum_board_id = $request->forum_board_id;
        }
        if (isset($request->comment_text)) {
            $topicComment->comment_text = $request->comment_text;
        } 
        if (isset($request->commented_by)) {
            $topicComment->commented_by = $request->commented_by;
        } else {
            $topicComment->commented_by = Auth::user()->id;
        }

        
        // dd($topicComment);
        $topic->topicComments()->save($topicComment);

        /* upload image */
        if ($request->hasFile('image')) {
            $attachment = new CommentAttachment();
            $fileName = time() . '.' . $request->image->extension();
            $image_path = public_path('comment_attechments/');
            UploadImage($fileName, $image_path, $request->file('image'), '360');
            $attachment->attachment = $fileName;
            $attachment->comment_id = $topicComment->id;
            $attachment->save();
        }

        return $topicComment;
    }
}
