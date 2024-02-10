<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();
     
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
    
        $messages = [
            'email.required' => 'Please enter the email address.',
            'email.email' => 'Please enter the valid email address.',
            'password.required' => 'Please enter the password.',
        ];
    
        $this->validate($request, $rules, $messages);
     
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            $user = auth()->user();

            if($user->user_type == "1"){
                return redirect()->route('admin.users');
            } elseif($user->user_type == "2"){
                return redirect()->route('provider.home');
            } elseif($user->user_type == "3" && $user->account_type == "0"){
                return redirect()->route('user.home');
            } elseif($user->user_type == "3" && $user->account_type == "1"){
                return redirect()->route('forum.user.dashboard');
            }
        }else{
            return redirect()->route('login')
                            ->withErrors(['loginError' => 'Email address and password do not match.'])
                            ->withInput();
        }
          
    }
}
