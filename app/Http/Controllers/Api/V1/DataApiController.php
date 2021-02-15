<?php

namespace App\Http\Controllers\Api\V1;

use App\Cities;
use App\Countries;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Validator;
use Illuminate\Http\Request;
use DB;
use Route;
class DataApiController extends Controller
{



    public function getCountries(Request $request)
    {
        $countries = Countries::where('status' ,1)->get();
        $message = __('api.success');
        return jsonResponse(true , $message  ,  $countries, 200 );

    }

    public function getCitiesByCountry($id)
    {
        $cities = Cities::where('country_id' ,$id)->get();
        $message = __('api.success');
        return jsonResponse(true , $message  ,    $cities , 200 );

    }



}
