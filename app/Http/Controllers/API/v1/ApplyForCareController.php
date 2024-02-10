<?php

namespace App\Http\Controllers\api\v1;

use App\Models\cr;
use App\Models\User;
use App\Models\ApplyForCare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApplyForCareResource;
use App\Http\Controllers\API\v1\BaseController;


class ApplyForCareController extends BaseController
{
    public function __construct(User $user) {
        $this->_user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validator = Validator::make($request->all(), [
            // 'user_id' => 'required', *NOTE* : if want validation then uncomment 
            // 'user_name' => 'required',*NOTE* : if want validation then uncomment 
            'apply_person_name' => 'required',
            'relationship' => 'required',
            'street' => 'required',
            'city' => 'required',
            'country' => 'required',
            'post_code'=> 'required|numeric',   
            'email' => 'required|string|email|unique:users',
            'telephone' => 'required|numeric:10',
            'mobile_number' => 'required|numeric:10',
            'required_care' => 'required',
            'description' => 'required',
            'specialist_care' => 'required',
            'term_condition' => 'required',
        ],
        [
            // 'user_id.required' => 'Please enter the user id',*NOTE* : if want validation then uncomment 
            // 'user_name.required' => 'Please enter the user name',*NOTE* : if want validation then uncomment 
            'apply_person_name.required' => 'Please aplicent person name',
            'relationship.required' => 'Please enter relationship',
            'street.required' => 'Please enter the street',
            'city.required' => 'Please enter city name',
            'email.required' => 'Please enter email address',
            'email.email' => 'You have entered an invalid email',
            'telephone.required' => 'Please enter telephone',
            'mobile_number.required' => 'Please enter mobile number',
            'required_care.required' => 'Please enter required care',
            'specialist_care.required' => 'Please enter specialist care',
            'term_condition.required' => 'term_condition required',
        ]);
   
        if($validator->fails()){
            return response()->json(
                [
                    'status' => 422,
                    'statusState' => 'error',
                    'message' => (empty($validator->errors()) ? 'Something went wrong' : $validator->errors())->first(),
                ],422
            );       
        }
        $input = $request->all();

        $input['user_id'] = auth()->user()->id;
        $input['user_name'] = auth()->user()->first_name;

        $data = ApplyForCare::create($input);

        $users = new ApplyForCareResource($data);

        return sendResponse($users, 'Submit Form successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }
}
