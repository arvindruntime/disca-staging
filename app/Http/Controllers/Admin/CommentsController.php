<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopicComments;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(){
        return view("admin.forum.comments.index");
    }

    public function list(Request $request){
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
            $totalRecords = TopicComments::select('count(*) as allcount')->where('parent_id',null)->count();
            $totalRecordswithFilter = TopicComments::select('count(*) as allcount')->where('parent_id',null)->where('comment_text', 'like', '%' . $searchValue . '%')->count();

            if($columnName == "user"){
                $columnName = "created_at";
            }
            // Fetch records
            $records = TopicComments::orderBy($columnName, $columnSortOrder)
                ->with(['topic','user'])
                ->where('parent_id',null)
                ->where('topic_comments.comment_text', 'like', '%' . $searchValue . '%')
                ->select('topic_comments.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();

            foreach ($records as $record) {
                $data_arr[] = array(
                    "user" => $record->user->name,
                    "profile" => $record->user->profile_image_url,
                    "email" => $record->user->email,
                    "comment_text" => $record->comment_text,
                    "topic" => $record->topic->title,
                    "created_at" => Carbon::parse($record->created_at)->toDateString(),
                    "id" => $record->id,
                    "topic_id" => $record->topic->id,
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

    public function editComment($id) {
        $comment = TopicComments::where('id',$id)->with(['user','topic','attachments'])->first();
        return view('admin.forum.comments.edit',compact('comment'));
    }
}
