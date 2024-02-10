<?php

namespace App\Http\Controllers\API\v1;

use Log;
use Mail;
use Exception;
use Validator;
use DB;
use Str;
use App\Models\User;
use App\Mail\sendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\API\v1\BaseController;

class AuthController extends BaseController
{
    public function requestOtp(Request $request)
    {
        try {
            $input = $request->all();
            $validator = validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255'],
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

            $otp = rand(100000, 999999);
            $user = User::where('email', '=', $request->email)->update(['otp' => $otp]);
            if (!empty($user)) {
                $mail_details = [
                    'subject' => 'Disca Account Verification OTP',
                    'body' => 'Your account verification OTP is : ' . $otp
                ];
                \Mail::to($request->email)->send(new sendEmail($mail_details));
                $res['email'] = $request->email;
                return $this->sendResponse($res, 'OTP sent successfully' . ' - ' . $otp, 200);
            } else {
                return $this->sendError('Invalid Email address.', [], 402);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 402);
        }
    }

    function resendOtp(Request $request)
    {
        return $this->requestOtp($request);
    }

    public function verifyOtp(Request $request)
    {
        try {
            $input = $request->all();
            $validator = validator::make($input, [
                'email' => ['required', 'string', 'email', 'max:255'],
                'otp' => ['required', 'max:6'],
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

            $user  = User::where([['email', '=', $request->email], ['otp', '=', $request->otp]])->first();
            if (!empty($user)) {
                User::where('email', '=', $request->email)->update(['otp' => null]);

                $token = Str::random(64);
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now(),
                ]);

                $res['email'] = $request->email;
                $res['token'] = $token;
                $res['reset_url'] = route('reset.password.get', ['token' => $token, 'email' => $request->email ]);
                
                return $this->sendResponse($res, 'OTP match with our records', 200);
                
                //auth()->login($user, true);
                //$accessToken = auth()->user()->createToken('authToken')->accessToken;
                //return response(["status" => 200, "message" => "Success", 'user' => auth()->user(), 'access_token' => $accessToken]);
            } else {
                return $this->sendError('OTP not match with our records.', [], 202);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Error.', ['error' => $th->getMessage()], 202);
        }
    }
}
