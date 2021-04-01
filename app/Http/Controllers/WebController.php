<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Artisan;
use Auth;
use App\Setting;
use LicenseBoxAPI;
use App;
class WebController extends Controller
{


    public function home(){


        return view('frontend.home');

    }

    public function viewMainAdminLogin()
    {
        return view('mainAdmin.auth.login');
    }

    public function viewAdminLogin(){

        return view('auth.login');
    }


    public function owner_login(Request $request)
    {
        $status = Setting::find(1)->license_status;

        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);
        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'role' => 1,
        );
        if (Auth::attempt($userdata)) {
            $lang= 'arabic';
            App::setLocale($lang);
            session()->put('locale', $lang);

            return redirect(adminPath().'home');
        } else {
            return Redirect::back()->with('error_msg', 'Invalid Username or Password');
        }
    }



}
