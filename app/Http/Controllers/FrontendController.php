<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    //

    public function home(){
        if(env('DB_DATABASE')==""){
            return view('frontPage');
        }
        else{
            return view('frontend.home');

        }

    }
}
