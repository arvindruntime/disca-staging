<?php

namespace App\Http\Controllers\Auth;

use DB;
use Hash;
use Mail;
use Exception;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\sendEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;

class   ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;
    /**
     * 

     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ], [
            'email.required' => 'Please enter the email',
            'email.exists' => 'Email not found, please enter a registered email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 202,
                'statusState' => 'error',
                'message' => (empty($validator->errors())
                    ? 'Something went wrong'
                    : $validator->errors()
                )->first(),
            ], 202);
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
            Session::put('UserEmailAddress',$request->email);
            return $this->sendResponse($res, 'OTP sent successfully' . ' - ' . $otp, 200);
        } else {
            return $this->sendError('Invalid Email address.', [], 402);
        }

        /*$user = User::where('email', $request->email)->first();
        $userName = $user->first_name;
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        try {
            $mail_details = [
                'subject' => 'Disca Account Verification OTP',
                'body' => 'Your account verification OTP is : ' . $otp
            ];
            \Mail::to($request->email)->send(new sendEmail($mail_details));
            $res['email'] = $request->email;
            return $this->sendResponse($res, 'OTP sent successfully', 200);
            /*Mail::send('email.forgetPassword', ['token' => $token, 'userName' => $userName, 'email' => $request->email], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
        } catch (Exception $e) {
            // Log the email sending error for debugging purposes
            Log::error('Error sending forgot password email');
            Log::error('Error message: ' . $e->getMessage());
        }

        return response()->json([
            'status' => 200,
            'statusState' => 'error',
            'message' => "We have e-mailed your password reset link!",
        ], 200);

        return back()->with('message', 'We have e-mailed your password reset link!');*/
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token, $email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->with('error', 'User not found for the provided email.');
        }
        return view('auth.passwords.reset', ['token' => $token, 'userName' => $user->name, 'email' => $email]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|same:password'
            ],
            [
                'email.required' => 'Please enter the email',
                'password.required' => 'Please enter the password',
                'password_confirmation.required' => 'Please enter the confirm password',
                'password.confirmed' => 'The confirm password does not match',
                'password_confirmation.same' => 'The confirm password does not match',
            ]
        );

        $updatePassword = DB::table('password_resets')->where(['email' => $request->email,'token' => $request->token])->first();

        if (empty($updatePassword)) {
            return $this->sendError('Invalid token!', [], 202);
        } else {
            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
            DB::table('password_resets')->where(['email' => $request->email])->delete();
            return $this->sendResponse([], 'Your password has been changed!', 200);
        }
    }

    public function VerifyOtpForm() {
        $email = Session::get('UserEmailAddress');
        return view('auth.passwords.verifyotpform',compact('email'));
    }
}
