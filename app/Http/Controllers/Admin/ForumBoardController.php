<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\ForumBoardMember;
use App\Models\User;
use App\Services\ForumBoardService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ForumBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.forum.board.index');
    }

    public function addNewBoard()
    {
        $forumUsers = User::where('user_type', 3)->get();
        return view('admin.forum.board.addNew', compact('forumUsers'));
    }

    public function editBoard($slug)
    {
        $board = Board::where('url', $slug)->with('members')->first();
        $forumUsers = User::where('user_type', 3)->get();
        return view('admin.forum.board.addNew', compact('forumUsers', 'board'));
    }


    public function getBoardList(Request $request)
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
            $totalRecords = Board::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Board::select('count(*) as allcount')->where('board_name', 'like', '%' . $searchValue . '%')->count();

            // Fetch records
            $records = Board::orderBy($columnName, $columnSortOrder)
                ->with('members')
                ->where('forum_board.board_name', 'like', '%' . $searchValue . '%')
                ->select('forum_board.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();

            foreach ($records as $record) {
                $data_arr[] = array(
                    "board_name" => $record->board_name,
                    "discription" => $record->discription,
                    "memberCount" => count($record->members),
                    "url" => $record->url,
                    "image" => $record->image_url,
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

    public function getMembersList(Request $request)
    {
        try {
            ## Read value
            $draw = $request->get('draw');
            $boardId = $request->get('board_id');
            $start = $request->get("start");
            $rowperpage = $request->get("length"); // Rows display per page

            // $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            // $order_arr = $request->get('order');
            $search_arr = $request->get('search');

            // $columnIndex = $columnIndex_arr[0]['column']; // Column index
            // $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value

            // Total records
            $totalRecords = User::select('count(*) as allcount')->where('user_type',3)->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')->where('user_type',3)->where('name', 'like', '%' . $searchValue . '%')->count();
            // Fetch records
            $records = User::orderBy('name')
                ->where('user_type',3)
                ->where('users.name', 'like', '%' . $searchValue . '%')
                ->select('users.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();
            foreach ($records as $record) {
                $isMember = ForumBoardMember::where('user_id',$record->id)->where('forum_board_id',$boardId)->first();
                $data_arr[] = array(
                    "id" => $record->id,
                    "name" => $record->name,
                    "image" => asset($record->profile_image_url ?? "images/icon/user_img.png"),
                    "checked" => isset($isMember) ? "checked" : ""
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
}
