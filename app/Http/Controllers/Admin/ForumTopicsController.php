<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\ForumTopic;
use App\Services\ForumTopicService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ForumTopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.forum.topics.index');
    }

    public function viewTopic($id)
    {
        $topic = ForumTopicService::view($id, false);
        return view('admin.forum.topics.view', compact('topic'));
    }

    public function addNewTopic()
    {
        $boards = Board::orderBy('created_at')->get();
        return view('forum.topic.create',compact('boards'));
    }

    public function addTopic()
    {
        $boards = Board::orderBy('created_at')->get();
        return view('forum.topic.create', compact('boards'));
    }

    public function editTopic($id)
    {
        $topic = ForumTopicService::view($id, false);
        $boards = Board::orderBy('created_at')->get();
        return view('forum.topic.create', compact('topic', 'boards'));
    }

    public function getTopicList(Request $request)
    {
        try {
            ## Read value
            $draw = $request->get('draw');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');

            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value

            // Total records
            $totalRecords = ForumTopic::select('count(*) as allcount')->count();
            $totalRecordswithFilter = ForumTopic::select('count(*) as allcount')->where('title', 'like', '%' . $searchValue . '%')->count();

            // Fetch records
            $records = ForumTopic::orderBy($columnName, $columnSortOrder)
                ->with(['topicComments', 'user', 'board'])
                ->where('forum_topics.title', 'like', '%' . $searchValue . '%')
                ->select('forum_topics.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();

            foreach ($records as $record) {
                $data_arr[] = array(
                    "title" => $record->title,
                    "user" => $record->user->name,
                    "board" => $record->board->board_name,
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
        } catch (Exception $e) {
            dd($e->getMessage);
        }
    }

    public function getRefreshedData($id){
        $topic = ForumTopicService::view($id, false);
        $view = view('admin.forum.topics.comments', compact('topic'))->render();
        return response()->json([
            'status' => 200,
            'statusState' => true,
            'data'    => [
                "topic" => $topic,
                "view" => $view
            ],
            'message' => "",
        ]);
    }
}
