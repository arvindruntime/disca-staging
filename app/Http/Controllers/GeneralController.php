<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\v1\BaseController;
use App\Models\User;
use App\Models\Country;
use App\Models\WebSitePage;

class GeneralController extends BaseController
{
    public function terms() {
        return view('terms-normal');
    }

    public function cookie_policy() {
        return view('cookie_policy');
    }

    public function privacy_policy() {
        return view('privacy_policy');
    }

    public function proffesional_care() {
        $countries = Country::select('id','country_code','country_name','dial_code')->get();
        return view('proffesional_care',compact('countries'));
    }
    public function getPage($slug)
    {
        $page = WebSitePage::where('permalink', $slug)->first();
        if(!$page){
            abort(404);
        }
        return view('terms', compact('page'));
    }
}
