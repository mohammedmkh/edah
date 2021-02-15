<?php

namespace App\Http\Controllers;

use App\GroceryReview;
use App\User;
use Auth;
use App\UserAddress;
use App\UserGallery;
use Illuminate\Http\Request;

class GroceryReviewController extends Controller
{
    //

    public function driverReview(){
        $master = array();      
        $master['grocery'] = GroceryReview::where('deliveryBoy_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $master,'success'=>true], 200);
    }


    public function viewUserReview(){
        $master = array();        
        $master['grocery_review'] = GroceryReview::whereNotNull('shop_id')->where('customer_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
        $master['userDetail'] = User::where('id',Auth::user()->id)->first();       
        $master['userAddress'] = UserAddress::where('id',$master['userDetail']->address_id)->first();
        $master['photos'] = UserGallery::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $master,'success'=>true], 200);
    }
    
}
