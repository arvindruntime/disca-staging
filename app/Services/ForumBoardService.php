<?php

namespace App\Services;

use App\Models\Board;
use Illuminate\Support\Facades\Storage;
use App\Models\ForumBoardMember;
use Exception;
use Str;

class ForumBoardService
{
    public static function createUpdate($forum_board, $request)
    {
        if (!empty($request->user_id)) {
            $forum_board->user_id = (int)$request->user_id;
        }

        if (!empty($request->board_name)) {
            $forum_board->board_name = $request->board_name;
        }

        if (!empty($request->url)) {
            $forum_board->url = Str::slug($request->url);
        }

        if (!empty($request->discription)) {
            $forum_board->discription = $request->discription;
        }

        /* upload image */
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Handle the new image upload
            if (!empty($forum_board->image)) {
                $image_path = public_path('forum_board/' . $forum_board->image);
                DeleteImage($image_path);
            }
            $fileName = time() . '.' . $request->image->extension();
            $img_path = public_path('forum_board/');
            UploadImage($fileName, $img_path, $request->file('image'), '360');
            $forum_board->image = $fileName;
        }

        $forum_board->save();

        if(!empty($request->members)){
            ForumBoardMember::where(['forum_board_id' => $forum_board->id])->delete();
            foreach ($request->members as $key => $value) {
                $member = new ForumBoardMember;
                $member->forum_board_id = $forum_board->id;
                $member->user_id = $value;
                $member->save();
            }
        }
        return $forum_board;
    }

}
