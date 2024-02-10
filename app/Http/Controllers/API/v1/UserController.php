<?php

namespace App\Http\Controllers\API\v1;

use DB;
use Cache;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ForumBoardActivities;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;
use Illuminate\Validation\Rule;

class UserController extends BaseController
{
    public function profile(Request $request)
    {
        try {
            $user_id = $request->wantsJson() ? $request->user_id : Auth::user()->id;
            $user = User::find($user_id);
            if (!empty($user)) {
                $user = new UserResource($user);
                return $this->sendResponse($user, 'User fetched successfully.', 200);
            } else {
                return $this->sendError('Invalid userid provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function update_profile(Request $request)
    {
        try {
            if ($request->wantsJson()) {
                $user_id = $request->user_id;
                $user = User::find($user_id);
            } else {
                $user_id = Auth::user()->id;
                $user = Auth::user();
            }

            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'username' => ['nullable'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($user_id)],
                'street' => ['required'],
                'city' => ['required'],
                'country_id' => ['required'],
                'post_code' => ['required'],
                'company' => ['nullable'],
                'dial_code' => ['required'],
                'mobile_no' => ['required'],
                'sectore' => ['nullable'],
                'image' => ['image', 'mimes:png,jpg,jpeg', 'max:2048'],
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

            $user->name = CheckValue($request->name, '');
            $user->username = CheckValue($request->username, '');
            $user->email = CheckValue($request->email, '');
            $user->street = CheckValue($request->street, '');
            $user->city = CheckValue($request->city, '');
            $user->country_id = CheckValue($request->country_id, 0);
            $user->post_code = CheckValue($request->post_code, '');
            $user->company = CheckValue($request->company, '');
            $user->dial_code = CheckValue($request->dial_code, '');
            $user->mobile_no = CheckValue($request->mobile_no, '');
            $user->sectore = CheckValue($request->sectore, '');
            
            if (!empty($request->image)) {
                if (!empty($user->image)) {
                    $image_path = public_path('profile/' . $user->image);
                    DeleteImage($image_path);
                }
                $fileName = time() . '.' . $request->image->extension();
                $img_path = public_path('profile/');
                UploadImage($fileName, $img_path, $request->file('image'), '360');
                $user->image = $fileName;
            }

            $user->update();

            return $this->sendResponse($user, 'Profile Updated SuccessFully.', 200);
            
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    function update_admin_profile(Request $request) {
        try {
            if ($request->wantsJson()) {
                $user_id = $request->user_id;
                $user = User::find($user_id);
            } else {
                $user_id = Auth::user()->id;
                $user = Auth::user();
            }

            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'company_lead' => ['nullable'],
                'organization' => ['required'],
                'street' => ['required'],
                'city' => ['required'],
                'country_id' => ['required'],
                'post_code' => ['required'],
                'dial_code' => ['required'],
                'mobile_no' => ['required'],
                'image' => ['image', 'mimes:png,jpg,jpeg', 'max:2048']
            ]);

            if($request->remove_img == "true"){
                if (!empty($user->image)) {
                    $image_path = public_path('profile/' . $user->image);
                    DeleteImage($image_path);
                    $user->image = null;
                }
            }
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

            $user->name = CheckValue($request->name, '');
            $user->company_lead = CheckValue($request->company_lead, '');
            $user->organization = CheckValue($request->organization, '');
            $user->street = CheckValue($request->street, '');
            $user->city = CheckValue($request->city, '');
            $user->country_id = CheckValue($request->country_id, 0);
            $user->post_code = CheckValue($request->post_code, '');
            $user->dial_code = CheckValue($request->dial_code, '');
            $user->mobile_no = CheckValue($request->mobile_no, '');

            if (!empty($request->image)) {
                if (!empty($user->image)) {
                    $image_path = public_path('profile/' . $user->image);
                    DeleteImage($image_path);
                }
                $fileName = time() . '.' . $request->image->extension();
                $img_path = public_path('profile/');
                UploadImage($fileName, $img_path, $request->file('image'), '360');
                $user->image = $fileName;
            }

            $user->update();
            
            return $this->sendResponse($user, 'Profile Updated SuccessFully.', 200);
            
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function logout()
    {
        try {
            $user = auth()->user()->tokens();
            if (!empty($user)) {
                auth()->user()->tokens()->delete();
                return $this->sendResponse([], 'Successfully Logged Out', 200);
            } else {
                return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function forgotPassword(Request $request)
    {
        return $this->resetPassword($request);
    }

    public function resetPassword(Request $request)
    {
        try {
            if (request()->route()->getName() == 'auth.forgotPassword') {

                $validator = validator::make($request->all(), [
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'token' =>  ['required', 'string'],
                    'password' => ['required', 'min:6'],
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

                $email_address = $request->email;
                $reset_password = "";
                $reset_password = DB::table('password_resets')->where(['token' => $request->token, 'email' => $email_address])->first();
            } else {

                if ($request->wantsJson()) {
                    $user = User::find($request->user_id);
                } else {
                    $user_data = auth()->user();
                    $user = User::find($user_data->id);
                }

                if(empty($user)){
                    return $this->sendError('Invalid userid provided', [], 402);
                }

                $email_address = $user->email;
                $oldPassword = $user->password;

                $validator = request()->validate([
                    'old_password' => ['required', 'min:6'],
                    'password' => ['required', 'min:6'],
                    // password_confirmation
                ]);

                if (!Hash::check($request->old_password, $oldPassword)) {
                    return $this->sendError('Old password is not matched with our records.', [], 402);
                }
            }

            if (!empty($reset_password) || request()->route()->getName() == 'auth.resetPassword') {

                $user = User::where(['email' => $email_address])->first();

                if (!empty($user)) {
                    $user->password = Hash::make($request->password);
                    $user->save();

                    if (request()->route()->getName() == 'auth.forgotPassword') {
                        DB::table('password_resets')->where(['token' => $request->token, 'email' => $request->email])->delete();
                    }
                    return $this->sendResponse([], 'Password has been successfully changed.', 200);
                } else {
                    return $this->sendError('User not found.', [], 402);
                }
            } else {
                return $this->sendError('Invalid token or email provided.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function change_microsoft_2fa_status(Request $request)
    {
        try {
            $secrate_key = $request->microsoft2fa_secret;
            if (empty($secrate_key) && $request->microsoft2fa_status == 0) {
                $validator = validator::make($request->all(), [
                    'user_id' => 'required',
                    'microsoft2fa_status' => 'required',
                ], [
                    'user_id.required' => 'Please enter the user_id.',
                    'microsoft2fa_status.required' => 'Please enter the 2fa status.',
                ]);
            } else {
                $validator = validator::make($request->all(), [
                    'user_id' => 'required',
                    'microsoft2fa_status' => 'required',
                    'microsoft2fa_secret' => 'required',
                ], [
                    'user_id.required' => 'Please enter the user_id.',
                    'microsoft2fa_status.required' => 'Please enter the 2fa status.',
                    'microsoft2fa_secret.required' => 'Please enter the 2fa secrate key.',
                ]);
            }

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

            $user_id = $request->user_id;
            $status = $request->microsoft2fa_status;

            $user_data = User::find($user_id);

            if (!empty($user_data)) {
                if ($status == 1) {
                    $user = User::where('id', $user_id)->update(['microsoft2fa_status' => $status, 'microsoft2fa_secret' => $secrate_key]);
                    $user_data = User::find($user_id);
                    return sendResponse("Microsoft 2FA Enabled Successfully");
                } elseif ($status == 0) {
                    $user = User::where('id', $user_id)->update(['microsoft2fa_status' => $status, 'microsoft2fa_secret' => NULL]);
                    $user_data = User::find($user_id);
                    return sendResponse("Microsoft 2FA Disabled Successfully");
                }
            } else {
                return $this->sendError('Invalid userid provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function check_microsoft_2fa_status($user_id = "")
    {
        try {
            if (!empty($user_id)) {
                $user_data = User::find($user_id);
                if ($user_data) {
                    return $this->sendResponse(['microsoft2fa_status' => $user_data->microsoft2fa_status], 'Status fetched successfully.', 200);
                } else {
                    return $this->sendError('Invalid userid provided', [], 402);
                }
            } else {
                return $this->sendError('Please Enter userid.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function change_notification_status(Request $request)
    {
        try {
            
            if ($request->notification_status == 0) {
                $validator = validator::make($request->all(), [
                    'user_id' => 'required',
                    'notification_status' => 'required',
                ], [
                    'user_id.required' => 'Please enter the user_id.',
                    'notification_status.required' => 'Please enter the notification status.',

                ]);
            } else {
                $validator = validator::make($request->all(), [
                    'user_id' => 'required',
                    'notification_status' => 'required',
                ], [
                    'user_id.required' => 'Please enter the user_id.',
                    'notification_status.required' => 'Please enter the notification status.',
                ]);
            }

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

            $user_id = $request->user_id;
            $status = $request->notification_status;

            $user_data = User::find($user_id);

            if (!empty($user_data)) {
                if ($status == 1) {
                    $user = User::where('id', $user_id)->update(['notification_status' => $status]);
                    $user_data = User::find($user_id);
                    return $this->sendResponse([], 'Notification Enabled Successfully.', 200);
                } elseif ($status == 0) {
                    $user = User::where('id', $user_id)->update(['notification_status' => $status]);
                    $user_data = User::find($user_id);
                    return $this->sendResponse([], 'Notification Disabled Successfully.', 200);
                } else {
                    return $this->sendError('Invalid userid provided', [], 402);
                }
            } else {
                return $this->sendError('Invalid userid provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function change_email_status(Request $request)
    {
        try {
            if ($request->email_status == 0) {
                $validator = validator::make($request->all(), [
                    'user_id' => 'required',
                    'email_status' => 'required',
                ], [
                    'user_id.required' => 'Please enter the user_id.',
                    'email_status.required' => 'Please enter the email status.',
                ]);
            } else {
                $validator = validator::make($request->all(), [
                    'user_id' => 'required',
                    'email_status' => 'required',
                ], [
                    'user_id.required' => 'Please enter the user_id.',
                    'email_status.required' => 'Please enter the email status.',
                ]);
            }

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

            $user_id = $request->user_id;
            $status = $request->email_status;

            $user_data = User::find($user_id);

            if (!empty($user_data)) {
                if ($status == 1) {
                    $user = User::where('id', $user_id)->update(['email_status' => $status]);
                    $user_data = User::find($user_id);
                    return $this->sendResponse([], 'Email Enabled Successfully.', 200);
                } elseif ($status == 0) {
                    $user = User::where('id', $user_id)->update(['email_status' => $status]);
                    $user_data = User::find($user_id);
                    return $this->sendResponse([], 'Email Disabled Successfully.', 200);
                }
            } else {
                return $this->sendError('Invalid userid provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function profile_forum_board($user_id = "")
    {   
        try {
            $user_data = User::find($user_id);
            if (!empty($user_data)) {
                $list = ForumBoardActivities::with(['board' => function ($query) {
                    $query->select('id', 'board_name', 'url', 'image');
                }])->where(['user_id' => $user_id])
                   ->where('forum_board_id', '!=', null)
                   ->get();
                return $this->sendResponse($list, 'Board fetched successfully.', 200);
            } else {
                return $this->sendError('Invalid userid provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function profile_image_delete($user_id = "") {
        try {
            $user_data = User::find($user_id);
            if(!empty($user_data)){
                if(!empty($user_data->image)){
                    $image_path = public_path('profile/' . $user_data->image);
                    DeleteImage($image_path);
                    $user_data->image = null;
                    $user_data->save();
                    return $this->sendResponse([], 'Profile image successfully deleted.', 200);
                } else {
                    return $this->sendResponse([], 'Profile image not found.', 200);
                }
            } else {
                return $this->sendError('Invalid userid provided', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    public function match_password(Request $request)
    {
        $validator = validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required',
        ], [
            'user_id.required' => 'Please enter the user id.',
            'password.required' => 'Please enter the password.',
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

        $user_id = $request->user_id;
        $password = $request->password;
        $user_data = User::find($user_id);

        if (!empty($user_data)) {
            if (Hash::check($password, $user_data['password'])) {
                return $this->sendResponse([], 'Passwords match!.', 200);
            } else {
                return $this->sendError(' Passwords do not match.', [], 200);
            }
        } else {
            return $this->sendError('Invalid userid provided', [], 402);
        }

    }
}
