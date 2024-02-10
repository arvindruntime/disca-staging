<?php

namespace App\Services;

use App\Models\Board;
use Illuminate\Support\Facades\Storage;
use App\Models\ForumBoardMember;
use Exception;
use Str;

class WebsitePageService
{
    public static function createUpdate($page, $request)
    {
        if (!empty($request->title)) {
            $page->title = $request->title;
        }

        if (!empty($request->content)) {
            $page->content = $request->content;
        }

        if (!empty($request->permalink)) {
            $page->permalink = Str::slug($request->permalink);;
        }

        $page->save();

        return $page;
    }
}
