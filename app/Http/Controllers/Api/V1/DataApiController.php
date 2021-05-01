<?php

namespace App\Http\Controllers\Api\V1;

use App\Cities;
use App\CompanySetting;
use App\Countries;
use App\Http\Controllers\Controller;
use App\Notifications;
use App\Order;
use App\Scheduling;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Validator;
use Illuminate\Http\Request;
use DB;
use Route;
class DataApiController extends Controller
{



    public function getResultsTech(Request $request)
    {
        $user = Auth::guard('api')->user();

        $data = array();

        $notif = Notifications::where('user_id' , $user->id)
            ->where('action_type' ,'searchacceptfromtech')->where('action_id' , $request->order_id)->pluck('action');

        $message = __('api.success');
        return jsonResponse(true, $message,   $notif  , 200);

    }


    public function removeTheOrder(Request $request)
    {
        $user = Auth::guard('api')->user();

        $data = array();

        $order = Order::where('user_id' , $user->id)->where('id' , $request->order_id)->first();
        if($order->status != 0 ){
            $message = __('api.error_can_not_cancel_order');
            return jsonResponse(true, $message,  null , 200);
        }

        $order->delete();
        $message = __('api.success');
        return jsonResponse(true, $message,  null , 200);

    }

    public function getSettings(Request $request)
    {
        $user = Auth::guard('api')->user();

        $data = array();


        $settings = CompanySetting::where('id' , 1)->first();
        $data['fees']=$settings->fees;
        $data['taxes']=$settings->taxes;
        $data['conditions']=$settings->conditions;

        $message = __('api.success');
        return jsonResponse(true,  $message ,   $data , 200);

    }



    public function getPaymentMethod(Request $request)
    {

        $data = array();

        $data[]=['id'=>1 , 'name' =>__('Visa & Master') ];
        $data[]=['id'=>2 , 'name' =>__('Mada') ];
        $data[]=['id'=>3 , 'name' =>__('Cash') ];

       // $ar[] = (Object)  $data;

        $message = __('api.success');
        return jsonResponse(true,  $message ,  $data, 200);

    }


    public function schedulingDate(Request $request)
    {

        $user = Auth::guard('api')->user();

        $schedul =new  Scheduling;
        $schedul->user_id = $user->id ;
        $schedul->category_id = $request->category_id ;
        $schedul->date = $request->date ;
        $schedul->time = $request->time ;
        $schedul->note = $request->note ;
        $schedul->save();

        $message = __('api.success');
        return jsonResponse(true,  $message , $schedul , 200);

    }






}
