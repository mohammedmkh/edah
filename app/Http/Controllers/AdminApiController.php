<?php

namespace App\Http\Controllers;

use App\Category;
use App\Currency;
use App\Location;
use App\Setting;
use App\Admin;
use App\Coupon;
use App\GroceryItem;
use App\Banner;
use App\GrocerySubCategory;
use App\GroceryReview;
use App\GroceryCategory;
use App\GroceryShop;
use App\OwnerSetting;
use App\GroceryOrderChild;
use App\GroceryOrder;
use App\CompanySetting;
use App\Notification;
use App\AdminNotification;
use App\Mail\ForgetPassword;
use Illuminate\Support\Facades\Mail;
use App\NotificationTemplate;
use Illuminate\Support\Facades\Hash;
use App\User;
use Artisan;
use Auth;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{

    public function ownerLogin(Request $request){
        $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
            'device_token' => 'bail|required',                      
        ]);
         $userdata = array(
            'email'     => $request->email,
            'password'  => $request->password,
            'role' => 1,
        );
        if(Auth::attempt($userdata)){
            $user = Auth::user();                              
            User::find(Auth::user()->id)->update(['device_token'=>$request->device_token]);                       
            $user['token'] = $user->createToken('BookAppoint')->accessToken;                    
            return response()->json(['msg' => null, 'data' => $user,'success'=>true], 200);           
        }
        else{
            return response()->json(['msg' => 'Invalid Username or password', 'data' => null,'success'=>false], 400);
        }  
    }


    public function resetOwnerPassword(Request $request){
        $request->validate([
            'email' => 'bail|required|email',            
        ]);
        $user = User::where([['email',$request->email,['role',1]]])->first();
        
        if($user){                                                                    
            $password=rand(100000,999999);                                     
            
            $content = NotificationTemplate::where('title','Forget Password')->first()->mail_content;
            $detail['name'] = $user->name;
            $detail['password'] = $password;
            $detail['shop_name'] = CompanySetting::where('id',1)->first()->name;      
            try{              
                Mail::to($user)->send(new ForgetPassword($content,$detail));
            }catch (\Exception $e) {
                
            }
             User::findOrFail($user->id)->update(['password'=>Hash::make($password)]);  
            return response()->json(['data' =>null ,'msg'=>'new password is send in your mail!' , 'success'=>true], 200);                                   
        }
        else{
            return response()->json(['data' =>null ,'msg'=>'Invalid Email ID!' , 'success'=>false], 200); 
        }
    }

    public function allShops(){
        $data = GroceryShop::with('locationData')->where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);                                   
    }

    public function shopItem($id){
        $data = GroceryItem::where('shop_id',$id)->orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);                                   
    }

    public function allItem(){
        $data = GroceryItem::orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);     
    }
    public function allCategory(){
        $data = GroceryCategory::orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);     
    }

    public function allSubCategory(){
        $data = GrocerySubCategory::orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);     
    }

    public function groceryCoupon(){
        $data = Coupon::where('use_for','Grocery')->orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);     
    }

    public function imageSlider(){
        $data = Banner::orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);     
    }

    public function locations(){
        $data = Location::orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);   
    }

    public function allUsers(){
        $data = User::where('role',0)->orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function allDrivers(){
        $data = User::where('role',2)->orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function addCategory(Request $request){
        $request->validate([
            'name' => 'bail|required|unique:grocery_category',   
            'image' => 'bail|required',                        
        ]);
        $data = $request->all();
        $data['status'] = 0;
        if(isset($request->image)|| $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        $category = GroceryCategory::create($data);
        return response()->json(['data' =>$category ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function addSubCategory(Request $request){
        $request->validate([
            'name' => 'bail|required|unique:grocery_sub_category',   
            'image' => 'bail|required', 
            'category_id' => 'bail|required',                        
            'shop_id' => 'bail|required', 
        ]);
        $data = $request->all();
        $data['status'] = 0;
        $data['owner_id'] = Auth::user()->id;
        if(isset($request->image)|| $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        $category = GrocerySubCategory::create($data);
        return response()->json(['data' =>$category ,'msg'=>'null' , 'success'=>true], 200); 
    }

    public function addShop(Request $request){
        $request->validate([
            'name' => 'bail|required|unique:grocery_shop',  
            'address' => 'bail|required',   
            'latitude' => 'bail|required|numeric',  
            'longitude' => 'bail|required|numeric',  
            'location' => 'bail|required',  
            'category_id' => 'bail|required',  
            'phone' => 'bail|required', 
            'radius' => 'bail|required',                        
            'open_time' => 'bail|required', 
            'close_time' => 'bail|required', 
            'delivery_charge' => 'bail|required', 
            'delivery_type' => 'bail|required', 
            'image' => 'bail|required', 
        ]);

        $data = $request->all();
        $data['status'] = 0; 
        $data['user_id'] = Auth::user()->id;
        if(isset($request->image)|| $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        if(isset($request->cover_image) || $request->cover_image != null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['cover_image']=$Iname.'.png';                
        }
        else{
            $data['cover_image']='default_cover.jpg';     
        }
      
        $shop = GroceryShop::create($data);
        return response()->json(['data' =>$shop ,'msg'=>'null' , 'success'=>true], 200); 

    }

    public function addItem(Request $request){
        $request->validate([
            'name' => 'bail|required|unique:grocery_item',            
            'sell_price' => 'bail|required',          
            'category_id' => 'bail|required',
            'subcategory_id' => 'bail|required',
            'shop_id' => 'bail|required',          
            'image' => 'bail|required',
            'stoke' => 'bail|required',          
            'weight' => 'bail|required',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 0;
        if(isset($request->image)|| $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        $item = GroceryItem::create($data);
        return response()->json(['data' =>$item ,'msg'=>'null' , 'success'=>true], 200); 
    }

    public function addCoupon(Request $request){
        $request->validate([
            'name' => 'bail|required',            
            'shop_id' => 'bail|required',          
            'type' => 'bail|required',
            'discount' => 'bail|required',
            'max_use' => 'bail|required',          
            'start_date' => 'bail|required',
            'end_date' => 'bail|required',                                 
        ]);
        $data = $request->all();    
        $data['status'] = 0;
        $data['use_for'] = 'Grocery';   
        $data['use_count'] = 0;     
        $data['code'] = chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).'-'.rand(999,10000);
        if(isset($request->image) || $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        else{
            $data['image']='default_coupon.png'; 
        }
        
        $coupon = Coupon::create($data);
        return response()->json(['data' =>$coupon ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function addBanner(Request $request){
        $request->validate([
            'title' => 'bail|required',            
            'image' => 'bail|required',                      
        ]);
        $data = $request->all();    
        $data['status'] = 0;
        if(isset($request->image) || $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        $banner = Banner::create($data);
        return response()->json(['data' =>$banner ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function addLocation(Request $request){
        $request->validate([
            'name' => 'bail|required|unique:location',            
            'latitude' => 'bail|required',                      
            'longitude' => 'bail|required',                      
            'radius' => 'bail|required',                                                   
        ]);
        $data = $request->all();    
        $data['status'] = 0;
        if(isset($request->popular)){ $data['popular'] = 1; }
        else{ $data['popular'] = 0; }
        $location = Location::create($data);
        return response()->json(['data' =>$location ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function viewCategory($id){
        $category = GroceryCategory::find($id);
        return response()->json(['data' =>$category ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function viewSubCategory($id){
        $data = GrocerySubCategory::find($id);
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function viewShop($id){
        $data = GroceryShop::find($id);
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function viewItem($id){
        $data = GroceryItem::find($id);
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function viewCoupon($id){
        $data = Coupon::find($id);
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function viewBanner($id){
        $data = Banner::find($id);
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function viewLocation($id){
        $data = Location::find($id);
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function deleteCategory($id){
        try {            
            $item = GroceryItem::where('category_id',$id)->get();           
            if(count($item)==0){
                $delete = GroceryCategory::find($id);
                $delete->delete();
                return response()->json(['data' =>null ,'msg'=>'Record deleted successfully' , 'success'=>true], 200);           
            }     
            else{
                return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
            }      
            
        } catch (\Exception $e) {
            return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
        }
    }

    public function deleteSubCategory($id){
        try {
              $item = GroceryItem::where('subcategory_id',$id)->get();           
            if(count($item)==0){
                $delete = GrocerySubCategory::find($id);
                $delete->delete();
                return response()->json(['data' =>null ,'msg'=>'Record deleted successfully' , 'success'=>true], 200);           
            }     
            else{
                return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200); 
            }               
        } catch (\Exception $e) {
            return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
        }
    }

    public function deleteShop($id){
        try {
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
            return response()->json(['data' =>null ,'msg'=>'Record deleted successfully' , 'success'=>true], 200);           
        } catch (\Exception $e) {
            return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
        }
    }

    public function deleteItem($id){
        try {
            $delete = GroceryItem::find($id);
            $child = GroceryOrderChild::where('item_id',$id)->get();
            if(count($child)==0){
                $delete->delete();
                return response()->json(['data' =>null ,'msg'=>'Record deleted successfully' , 'success'=>true], 200);           
            }  
            else{
                return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
            } 
           
        } catch (\Exception $e) {
            return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
        }
    }

    public function deleteCoupon($id){
        try {
            $delete = Coupon::find($id);
            $delete->delete();            
            return response()->json(['data' =>null ,'msg'=>'Record deleted successfully' , 'success'=>true], 200);           
        } catch (\Exception $e) {
            return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
        }
    }

    public function deleteBanner($id){
        try {
            $delete = Banner::find($id);
            $delete->delete();
            return response()->json(['data' =>null ,'msg'=>'Record deleted successfully' , 'success'=>true], 200);           
        } catch (\Exception $e) {
            return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
        }
    }

    public function deleteLocation($id){
        try {           
            $Groceryshop = GroceryShop::where('location',$id)->get();
            if($Groceryshop){
                foreach ($Groceryshop as $value) {
                    $GroceryItem = GroceryItem::where('shop_id',$value->id)->get();
                    if($GroceryItem){
                        foreach ($GroceryItem as $i) {
                            $i->delete();
                        } 
                    }  
                    $GrocerySubCategory = GrocerySubCategory::where('shop_id',$value->id)->get();                   
                    if($GrocerySubCategory){
                        foreach ($GrocerySubCategory as $g) {                           
                            $g->delete();
                        } 
                    }                   
                  
                    $Coupon = Coupon::where([['shop_id',$value->id],['use_for','Grocery']])->get();
                    if($Coupon){
                        foreach ($Coupon as $c) {
                            $c->delete();
                        } 
                    }                                       

                    $Order = GroceryOrder::where('shop_id',$value->id)->get();
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
                    $value->delete();
                } 
            }

            $delete = Location::findOrFail($id);
            $delete->delete();

            return response()->json(['data' =>null ,'msg'=>'Record deleted successfully' , 'success'=>true], 200);           
        } catch (\Exception $e) {
            return response()->json(['data' =>null ,'msg'=>'Data is connected another data' , 'success'=>false], 200);            
        }
    }
    
    public function editLocation(Request $request){
      
        $request->validate([
            'name' => 'bail|required',            
            'latitude' => 'bail|required',                      
            'longitude' => 'bail|required',                      
            'radius' => 'bail|required',     
            'status' => 'bail|required',
            'id' => 'bail|required',                                                
        ]);
        $data = $request->all();              
        Location::find($request->id)->update($data);
        $location = Location::find($request->id);
        return response()->json(['data' =>$location ,'msg'=>'null' , 'success'=>true], 200);
    }
    
    public function editBanner(Request $request){
      
        $request->validate([
            'title' => 'bail|required',            
            'status' => 'bail|required', 
            'id' => 'bail|required',                      
        ]);
        $data = $request->all();            
        if(isset($request->image) || $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        Banner::find($request->id)->update($data);
        $banner =Banner::find($request->id);
        return response()->json(['data' =>$banner ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function editCoupon(Request $request){
        $request->validate([
            'name' => 'bail|required',            
            'shop_id' => 'bail|required',          
            'type' => 'bail|required',
            'discount' => 'bail|required',
            'max_use' => 'bail|required',          
            'start_date' => 'bail|required',
            'end_date' => 'bail|required',                      
            'status'=> 'bail|required', 
            'id'=> 'bail|required', 
        ]);
        $data = $request->all();    
        
        if(isset($request->image) || $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
               
        Coupon::find($request->id)->update($data);
        $coupon = Coupon::find($request->id);
        return response()->json(['data' =>$coupon ,'msg'=>'null' , 'success'=>true], 200);
    }
    
    public function editShop(Request $request){
        $request->validate([
            'name' => 'bail|required',  
            'address' => 'bail|required',   
            'latitude' => 'bail|required|numeric',  
            'longitude' => 'bail|required|numeric',  
            'location' => 'bail|required',  
            'category_id' => 'bail|required',  
            'phone' => 'bail|required', 
            'radius' => 'bail|required',                        
            'open_time' => 'bail|required', 
            'close_time' => 'bail|required', 
            'delivery_charge' => 'bail|required', 
            'delivery_type' => 'bail|required', 
            'status' => 'bail|required', 
            'id' => 'bail|required', 
        ]);

        $data = $request->all();              
        if(isset($request->image)|| $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        if(isset($request->cover_image) || $request->cover_image != null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['cover_image']=$Iname.'.png';                
        }
              
        GroceryShop::find($request->id)->update($data);
        $shop = GroceryShop::find($request->id);
        return response()->json(['data' =>$shop ,'msg'=>'null' , 'success'=>true], 200); 

    }

    public function editItem(Request $request){
        $request->validate([
            'name' => 'bail|required|unique:grocery_item',            
            'sell_price' => 'bail|required',          
            'category_id' => 'bail|required',
            'subcategory_id' => 'bail|required',
            'shop_id' => 'bail|required',          
            'status' => 'bail|required',
            'id' => 'bail|required',
            'stoke' => 'bail|required',          
            'weight' => 'bail|required',
        ]);
        $data = $request->all();
     
        if(isset($request->image)|| $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        GroceryItem::find($request->id)->update($data);
        $item = GroceryItem::find($request->id);
        return response()->json(['data' =>$item ,'msg'=>'null' , 'success'=>true], 200); 
    }


    public function editCategory(Request $request){
        $request->validate([
            'name' => 'bail|required',   
            'status' => 'bail|required',                        
            'id' => 'bail|required',                        
        ]);
        $data = $request->all();
        
        if(isset($request->image)|| $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        GroceryCategory::find($request->id)->update($data);
        $category = GroceryCategory::find($request->id);
        return response()->json(['data' =>$category ,'msg'=>'null' , 'success'=>true], 200);
    }

    public function editsubCategory(Request $request){
        $request->validate([
            'name' => 'bail|required',   
            'status' => 'bail|required', 
            'category_id' => 'bail|required',                        
            'shop_id' => 'bail|required',
            'id' => 'bail|required', 
        ]);
        $data = $request->all();
      
        if(isset($request->image)|| $request->image!= null)
        {
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $img_code = base64_decode($img);
            $Iname = uniqid();
            $file = public_path('/images/upload/') . $Iname . ".png";
            $success = file_put_contents($file, $img_code);
            $data['image']=$Iname.'.png';                
        }
        GrocerySubCategory::find($request->id)->update($data);
        $category = GrocerySubCategory::find($request->id);
        return response()->json(['data' =>$category ,'msg'=>'null' , 'success'=>true], 200); 
    }

    public function viewOrders(){
        $data = GroceryOrder::with(['shop','customer','deliveryGuy'])->orderBy('id', 'DESC')->get();
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200); 
    }

    public function singleOrder($id){
        $data = GroceryOrder::with(['shop','customer','deliveryGuy'])->find($id);
        return response()->json(['data' =>$data ,'msg'=>'null' , 'success'=>true], 200); 
    }
}
