<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Artisan;
use Auth;
use App\Setting;
use LicenseBoxAPI;

class LicenseController extends Controller
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

            return redirect('home');                                
        } else {
            return Redirect::back()->with('error_msg', 'Invalid Username or Password');
        }
    }

    public function saveLicenseSettings(Request $request){
     
        $request->validate([
            'license_key' => 'bail|required',
            'license_name' => 'bail|required',
        ]);
        $api = new LicenseBoxAPI();   
        $result =  $api->activate_license($request->license_key, $request->license_name);       
        if ($result['status'] === true) {
            Setting::find(1)->update(['license_status'=>1,'license_key'=>$request->license_key,'license_name'=>$request->license_name]);
            return redirect('home');  
        }
        else{                 
            Setting::find(1)->update(['license_status'=>0]);  
            return Redirect::back()->with('error_msg', $result['message']);      
        }
           
    }

}
