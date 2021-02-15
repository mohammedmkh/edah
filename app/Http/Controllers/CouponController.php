<?php

namespace App\Http\Controllers;

use App\Coupon;
use App\Setting;
use Carbon\Carbon;
use App\Currency;
use App\User;
use DB;
use App\GroceryShop;
use Auth;
use Illuminate\Http\Request;

class CouponController extends Controller
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
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Coupon::where('code',$id)->first();
        // $shop = Shop::where('user_id',Auth::user()->id)->get();
        $groceryShop = GroceryShop::where('user_id',Auth::user()->id)->get();
        return view('admin.coupon.editCoupon',['data'=>$data,'groceryShop'=>$groceryShop ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate( [
            'name' => 'bail|required',
            'shop_id' => 'bail|required',
            'type' => 'bail|required',
            'discount' => 'bail|required',
            'max_use' => 'bail|required',
            'start_date' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $data = $request->all();
        if($request->start_date){
            $date = explode(" to ",$request->start_date);
            $data['start_date'] = $date[0];
            $data['end_date'] = $date[1];
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        Coupon::find($id)->update($data);
        return redirect('Coupon');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $delete = Coupon::find($id);
            $delete->delete();
            return 'true';
        } catch (\Exception $e) {
            return response('Data is Connected with other Data', 400);
        }
    }

    public function viewCoupon(){
        $data = Coupon::where([['status',0],['use_for','Grocery']])->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $data,'success'=>true], 200);
    }

    public function chkCoupon(Request $request){
        $request->validate( [
            'code' => 'bail|required',
            // 'date' => 'bail|required|date_format:Y-m-d',
        ]);
        $date = Carbon::now()->format('Y-m-d');

        $data = Coupon::where([['code',$request->code],['status',0]])->first();
        if($data){
            if (Carbon::parse($date)->between(Carbon::parse($data->start_date),Carbon::parse($data->end_date))){
                if($data->max_use<=$data->use_count){
                    return response()->json(['success'=>false,'msg'=>'This coupon is expire!' ,'data' =>null ], 200);
                }
                else{
                    return response()->json(['success'=>true,'msg'=>null ,'data' =>$data ], 200);
                }
            }
            else{
                return response()->json(['success'=>false,'msg'=>'This coupon is expire!' ,'data' =>null ], 200);
            }
        }
        else{
            return response()->json(['success'=>false,'msg'=>'Invalid Coupon code!' ,'data' =>null ], 200);
        }
    }

    public function viewShopCoupon($id){
        $data = Coupon::where([['shop_id',$id],['status',0],['use_for','Grocery']])->orderBy('id', 'DESC')->get();
        return response()->json(['msg' => null, 'data' => $data,'success'=>true], 200);
    }



}
