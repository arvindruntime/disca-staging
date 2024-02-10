<?php

namespace App\Http\Controllers\API\v1;

use random;
use Validator;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\RegisterWelcomeMail;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Mail\ForumRegisterWelcomeMail;
use App\Http\Controllers\API\v1\BaseController;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $input = $request->all();
            $validator = validator::make($request->all(), [
                'account_type' => 'required',
                'name' => 'required',
                //'company' => 'required',
                'organization' => 'required',
                'street' => 'required',
                'city' => 'required',
                'country_id' => 'required',
                'post_code' => 'required',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'dial_code' => 'required',
                'mobile_no' => 'required',
                'website' => 'nullable',
                'sectore' => 'nullable',
                'terms_and_condition' => 'required',
                // Added By Mayank Gajjar
                'phone_dial_code' => 'required',
                'phone_no' => 'required',
                'password' => 'required|confirmed|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 202,
                        'statusState' => 'error',
                        'message' => (empty($validator->errors())
                            ? 'Something went wrong'
                            : $validator->errors()
                        )->first(),
                    ],
                    202
                );
            }

            $password = $request->password;
            $input['password'] =  bcrypt($password);

            /* image upload */
            // if ($request->hasFile('image')) {
            //     $imageName = md5(time()) . '.' . $request->image->extension();
            //     $request->image->storeAs('public/profile', $imageName);
            //     $input['image'] = $imageName;
            //     $user['image'] = ($input['image']);
            // }

            $input['terms_and_condition'] = 1;
            $user = User::create($input);

            if(!empty($user['dial_code'])){
                $country_name = Country::where('dial_code',$user['dial_code'])->pluck('country_name');
                $user['country_name'] = $country_name[0];
            }

            try {
                // Send the email to the user
                Mail::to($user->email)->send(new ForumRegisterWelcomeMail($user->name, $password));
            } catch (\Exception $e) {
                // Log the email sending error for debugging purposes
                Log::error('Error sending forum registration email');
                Log::error('Error message: ' . $e->getMessage());
            }
            $response['token'] =  $user->createToken('DiscaToken')->accessToken;
            // if ($request->hasFile('image')) {
            //     $user['profile_image_url'] = ('/storage/profile/'.$user['image']);
            // }
            $userResource = new UserResource($user);
            $response['user'] = $userResource;

            return $this->sendResponse($response, 'Forum register successfully.', 200);
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => 402,
                        'statusState' => 'error',
                        'message' => (empty($validator->errors())
                            ? 'Something went wrong'
                            : $validator->errors()
                        )->first(),
                    ],
                    402
                );
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                if(!empty($user->dial_code)){
                    $country_name = Country::where('dial_code',$user->dial_code)->pluck('country_name');
                    $user->mobile_country_name = $country_name[0];
                }
                if(!empty($user->phone_dial_code)){
                    $country_name = Country::where('dial_code',$user->phone_dial_code)->pluck('country_name');
                    $user->phone_country_name = $country_name[0];
                }
                $token = $user->createToken('DiscaToken')->accessToken;

                //$response_data['status'] = 200;
                if ($user->user_type == "1") {
                    $message = 'Admin login successfully';
                } elseif ($user->user_type == "2") {
                    $message = 'Provider login successfully';
                } elseif ($user->user_type == "3" && $user->account_type == "0") {
                    $message = 'User login successfully';
                } elseif ($user->user_type == "3" && $user->account_type == "1") {
                    $message = 'Forum login successfully';
                }
                $response_data['token'] = $token;
                $userResource = new UserResource($user);
                $response_data['user'] = $userResource;

                return $this->sendResponse($response_data, $message, 200);
            } else {
                return $this->sendError('Invalid Email or Password', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }
}
