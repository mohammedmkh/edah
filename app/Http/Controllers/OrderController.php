<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Currency;
use App\User;
use App\Coupon;
use App\GroceryOrder;
use App\OwnerSetting;
use OneSignal;
use App\GroceryShop;
use App\UserAddress;
use Twilio\Rest\Client;
use App\CompanySetting;
use DB;
use Config;
use App\AdminNotification;
use Carbon\Carbon;
use App\Notification;
use App\NotificationTemplate;
use App\Mail\OrderStatus;
use App\Mail\OrderCreate;
use Illuminate\Support\Facades\Mail;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
      
    }


    public function driverTrip(){
        $date = Carbon::now()->format('Y-m-d');

        $master= array();
        $master['collect'] =0;
      
        $master['grocery_order']= GroceryOrder::with(['shop'])->where([['date',$date],['order_status','Pending']])
        ->orWhere([['date',$date],['order_status','Approved']])
        ->orderBy('id', 'DESC')->get();
       
        $grocerytrip = GroceryOrder::where([['date',$date],['deliveryBoy_id',Auth::user()->id]])->get()->count();
        $master['trip']= $grocerytrip;
 
        $groceryOrders= GroceryOrder::where([['date',$date],['deliveryBoy_id',Auth::user()->id]])->get();
        foreach ($groceryOrders as $value) {
            $master['collect'] = $master['collect'] + $value->payment;
        }

        return response()->json(['success'=>true,'msg'=>null ,'data' =>$master ], 200);
    }

    public function earningHistroy(Request $request){

        if($request->date != ""){
           
            $grocery = GroceryOrder::where([['deliveryBoy_id',Auth::user()->id],['order_status','Delivered'],['payment_status',1],['date',$request->date]])->orderBy('id', 'DESC')->get();
            $d_charge = Setting::find(1)->delivery_charge_per;
           
            foreach ($grocery as $value) {
                $value->driver_earning = $value->payment*$d_charge/100;
                $value->customer_name = User::findOrFail($value->customer_id)->name;
            }
        }
        else{
            $request->validate([
                'start_date' => 'bail|required|date_format:Y-m-d',
                'end_date' => 'bail|required|date_format:Y-m-d',
            ]);
           
            $grocery = GroceryOrder::where([['deliveryBoy_id',Auth::user()->id],['order_status','Delivered'],['payment_status',1]])
            ->whereBetween('date', [ $request->start_date,  $request->end_date])
            ->orderBy('id', 'DESC')->get();
            $d_charge = Setting::find(1)->delivery_charge_per;
         
            foreach ($grocery as $value) {
                $value->driver_earning = $value->payment*$d_charge/100;
                $value->customer_name = User::findOrFail($value->customer_id)->name;
            }
        }
       
        return response()->json(['success'=>true,'msg'=>null ,'data' =>$grocery ], 200);
    }    

    public function viewnotification(){
        $data = Notification::where('driver_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
       
        return response()->json(['success'=>true,'msg'=>null ,'data' =>$data ], 200);
    }

    public function saveDriverLocation(Request $request){
        $request->validate( [
            'lat' => 'bail|required',
            'lang' => 'bail|required',
        ]);
        User::findOrFail(Auth::user()->id)->update(['lat'=>$request->lat,'lang'=>$request->lang]);
        $data = User::findOrFail(Auth::user()->id);

        return response()->json(['success'=>true,'msg'=>null ,'data' =>$data ], 200);
    }

}


