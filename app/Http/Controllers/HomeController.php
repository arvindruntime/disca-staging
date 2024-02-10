<?php
  
namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
  
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    } 
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('adminHome');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function providerHome()
    {
        return view('providerHome');
    }

    public function adminProfile(){
        $countries = Country::all();
        return view('admin.profile',compact('countries'));
    }

    public function forumProfile(){
        $countries = Country::all();
        return view('forum.profile',compact('countries'));
    }
}
