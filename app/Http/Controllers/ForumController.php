<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\ForumTopic;
use App\Services\ForumTopicService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function dashboard()
    {
        return view('forum.dashboard');
    }

    public function chat()
    {
        return view('forum.chat');
    }

    // public function discussion()
    // {
    //     return view('forum.discussion');
    // }

    public function generalUpdateBoardList()
    {
        return view('forum.general-update-board');
    }
    
    public function viewTopics($slug)
    {
        try{
            $board = Board::where('url',$slug)->first();
            return view('forum.topic.topic-list',compact('board'));
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function getTopics(Request $request,$id){
        // try{
           ## Read value
           $draw = $request->get('draw');
           $start = $request->get("start");
           $rowperpage = $request->get("length"); // Rows display per page

        //    $columnIndex_arr = $request->get('order');
           $columnName_arr = $request->get('columns');
           $order_arr = $request->get('order');
           $search_arr = $request->get('search');

        //    $columnIndex = $columnIndex_arr[0]['column']; // Column index
        //    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        //    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
           $searchValue = $search_arr['value']; // Search value

           // Total records
           $totalRecords = ForumTopic::select('count(*) as allcount')->where('forum_board_id',$id)->count();
           $totalRecordswithFilter = ForumTopic::select('count(*) as allcount')->where('forum_board_id',$id)->where('title', 'like', '%' . $searchValue . '%')->count();

           // Fetch records
           $records = ForumTopic::orderBy($request->get('sortBy'))
               ->with(['topicComments', 'user', 'board'])
               ->where('forum_topics.title', 'like', '%' . $searchValue . '%')
               ->where('forum_board_id',$id)
               ->select('forum_topics.*')
               ->skip($start)
               ->take($rowperpage)
               ->get();

           $data_arr = array();

           foreach ($records as $record) {
               $data_arr[] = array(
                   "title" => $record->title,
                   "user" => $record->user,
                   "topic_views" => $record->topic_views,
                   "replies" => count($record->topicComments),
                   "created_at" => Carbon::parse($record->created_at)->toDateString(),
                   "id" => $record->id
               );
           }

           $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordswithFilter,
               "aaData" => $data_arr
           );

           return response()->json($response);
        // }catch(Exception $e){
        //     dd($e->getMessage());
        // }
    }

    public function forumTopicDetail($id)
    {
        $topic = ForumTopicService::view($id);
        return view('forum.topic.forum-topic', compact('topic'));
    }

    public function createTopic()
    {
        $boards = Board::orderBy('created_at')->get();
        return view('forum.topic.create',compact('boards'));
    }
}
