<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function userList()
    {
        $data = User::select('*');
            // dd($data);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('username', function($row){
                        return $row->first_name.' '.$row->last_name;
                    })
                    ->addColumn('profile', function($row){
                        if(isset($row->image)) {
                            return '<img src=" '.asset('storage/profile/'.$row->image).'" width="40px">';

                        } else {
                            return '<img src=" '.asset('storage/profile/demo_profile.jpeg').'" width="40px">';
                        }
                    })
                    ->addColumn('user_type', function($row){
                        if($row->type == 'user') {
                            $userType = 'Normal User';
                        } elseif ($row->type == 'provider') {
                            $userType = 'Provider';
                        } elseif ($row->type == 'forum_user') {
                            $userType = 'Forum User';
                        } elseif ($row->type == 'admin') {
                            $userType = 'Super Admin';
                        }

                        return $userType;
                    })
                    ->addColumn('user_status', function($row) {
                        if($row->status == 1) {
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Active</a>';
                        } else {
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Inactive</a>';
                        }
      
                        return $btn;
                    })
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>&nbsp';
                            $btn .= '<a href="javascript:void(0)" class="edit btn btn-info btn-sm">Edit</a>&nbsp';
                            $btn .= '<a href="javascript:void(0)" class="edit btn btn-danger btn-sm">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['profile', 'user_type', 'user_status', 'action'])
                    ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            dd($data);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('username', function($row){
                    })
                    ->addColumn('user_type', function($row){
                    })
                    ->addColumn('action', function($row){
                    })
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
      
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
