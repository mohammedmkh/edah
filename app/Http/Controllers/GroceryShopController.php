<?php

namespace App\Http\Controllers;

use App\GroceryShop;
use App\Setting;
use App\GroceryCategory;
use App\Currency;
use App\GroceryItem;
use App\GrocerySubCategory;
use App\GroceryOrder;
use App\GroceryReview;
use Auth;
use App\GroceryOrderChild;
use App\Notification;
use App\Coupon;
use Carbon\Carbon;
use App\Location;
use Illuminate\Http\Request;

class GroceryShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = GroceryShop::with('locationData')->where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->paginate(10);
        return view('admin.GroceryShop.viewGroceryShop',['shops'=>$data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $location = Location::orderBy('id', 'DESC')->get();
        $category = GroceryCategory::orderBy('id', 'DESC')->get();
        return view('admin.GroceryShop.addGroceryShop',['location'=>$location,'category'=>$category]);
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
        $request->validate([
            'name' => 'bail|required',
            'address' => 'bail|required',
            'description' => 'bail|required',
            'latitude' => 'bail|required|numeric',
            'longitude' => 'bail|required|numeric',
            'delivery_charge' => 'bail|required|numeric',
            'delivery_type' => 'bail|required',
            'radius'=> 'bail|required|numeric',
            'status' => 'bail|required',
            'open_time' => 'bail|required',
            'close_time' => 'bail|required',
            'image' => 'bail|required',
            'cover_image' => 'bail|required',
            'location' => 'bail|required',
            'phone' => 'bail|required',
            'website' => 'bail|required',

        ]);

        $data = $request->all();
        $data['category_id']= implode(",",$data['category_id']);
        $data['user_id'] = Auth::user()->id;
        $data['open_time'] = Carbon::parse($data['open_time'])->format('g:i A');
        $data['close_time'] = Carbon::parse($data['close_time'])->format('g:i A');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $cover_image_name = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $cover_image_name);
            $data['cover_image'] = $cover_image_name;
        }
        $shop = GroceryShop::create($data);

        return redirect('GroceryShop');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroceryShop  $groceryShop
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $shop = GroceryShop::where('name',$id)->first();
        // $shop->items = Item::where('shop_id',$shop->id)->get();

        $currency_code = Setting::where('id',1)->first()->currency;
        $currency = Currency::where('code',$currency_code)->first()->symbol;
        
        return view('admin.GroceryShop.groceryShopDetail',['data'=>$shop,'currency'=>$currency]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroceryShop  $groceryShop
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = GroceryShop::find($id);
        $data['open_time'] = Carbon::parse($data->open_time)->format('H:i');
        $data['close_time'] = Carbon::parse($data->close_time)->format('H:i');
        $category = GroceryCategory::orderBy('id', 'DESC')->get();
        $location = Location::orderBy('id', 'DESC')->get();

         
        return view('admin.GroceryShop.editGroceryShop',['data'=>$data,'category'=>$category,'location'=>$location]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroceryShop  $groceryShop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'bail|required',
            'address' => 'bail|required',
            'description' => 'bail|required',
            'latitude' => 'bail|required|numeric',
            'longitude' => 'bail|required|numeric',
            'delivery_charge' => 'bail|required|numeric',
            'delivery_type' => 'bail|required',
            'radius'=> 'bail|required|numeric',
            'status' => 'bail|required',
            'open_time' => 'bail|required',
            'close_time' => 'bail|required',
            'location' => 'bail|required',
            'phone' => 'bail|required',
            'website' => 'bail|required',

        ]);

        $data = $request->all();
        $data['category_id']= implode(",",$data['category_id']);
        $data['user_id'] = Auth::user()->id;
        $data['open_time'] = Carbon::parse($data['open_time'])->format('g:i A');
        $data['close_time'] = Carbon::parse($data['close_time'])->format('g:i A');

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        if ($request->hasFile('cover_image')) {
            $cover_image = $request->file('cover_image');
            $cover_image_name = uniqid() . '.' . $cover_image->getClientOriginalExtension();
            $cover_destinationPath = public_path('/images/upload');
            $cover_image->move($cover_destinationPath, $cover_image_name);
            $data['cover_image'] = $cover_image_name;
        }
        $shop = GroceryShop::find($id)->update($data);

        return redirect('GroceryShop');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroceryShop  $groceryShop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            $GroceryItem = GroceryItem::where('shop_id',$id)->get();
            if($GroceryItem){
                foreach ($GroceryItem as $i) {
                    $i->delete();
                } 
            }  
             $GrocerySubCategory = GrocerySubCategory::where('shop_id',$id)->get();                   
            if($GrocerySubCategory){
                foreach ($GrocerySubCategory as $g) {                           
                    $g->delete();
                } 
            }
            $Coupon = Coupon::where([['shop_id',$id],['use_for','Grocery']])->get();
            if($Coupon){
                foreach ($Coupon as $c) {
                    $c->delete();
                } 
            } 
            
            $Order = GroceryOrder::where('shop_id',$id)->get();
            if($Order){
                foreach ($Order as $item) {                    
                    $Notification = Notification::where([['order_id',$item->id],['notification_type','Grocery']])->get();
                    if($Notification){
                        foreach ($Notification as $n) {
                            $n->delete();
                        } 
                    }
                    $Review = GroceryReview::where('order_id',$item->id)->get();
                    if($Review){
                        foreach ($Review as $r) {
                            $r->delete();
                        } 
                    }
                    $OrderChild = GroceryOrderChild::where('order_id',$item->id)->get();
                    if($OrderChild){
                        foreach ($OrderChild as $oc) {
                            $oc->delete();
                        } 
                    }                                              
                    $item->delete();
                } 
            }

            $shop = GroceryShop::find($id);
            $shop->delete();
            return 'true';
        }catch (\Exception $e) {
            return response('Data is Connected with other Data', 400);
        }
    }

    public function shopCategory($id){
        $category = GroceryShop::find($id)->category_id; 
        $category = GroceryCategory::whereIn('id',explode(",",$category))->get();   
        return response()->json(['data' =>$category ,'success'=>true], 200);
    }

    public function itemSubcategory($id){
       $data = GrocerySubCategory::where([['category_id',$id],['owner_id',Auth::user()->id]])->get();
       return response()->json(['data' =>$data ,'success'=>true], 200);
    }

   

}
