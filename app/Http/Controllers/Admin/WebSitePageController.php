<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebSitePage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebSitePageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index');
    }

    public function addPage()
    {
        return view('admin.pages.create');
    }
    public function editPage($slug)
    {
        $page = WebSitePage::where('permalink', $slug)->first();
        return view('admin.pages.create', compact('page'));
    }

    public function getPages(Request $request)
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
            $totalRecords = WebSitePage::select('count(*) as allcount')->count();
            $totalRecordswithFilter = WebSitePage::select('count(*) as allcount')->where('title', 'like', '%' . $searchValue . '%')->count();

            // Fetch records
            $records = WebSitePage::orderBy($columnName, $columnSortOrder)
                ->where('web_site_pages.title', 'like', '%' . $searchValue . '%')
                ->select('web_site_pages.*')
                ->skip($start)
                ->take($rowperpage)
                ->get();

            $data_arr = array();

            foreach ($records as $record) {
                $data_arr[] = array(
                    "title" => $record->title,
                    "created_at" => Carbon::parse($record->created_at)->toDateString(),
                    "slug" => $record->permalink
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
