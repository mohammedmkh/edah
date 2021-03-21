<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use Auth;
use App\Setting;
use App\GroceryShop;
use App\GroceryOrder;
use App\Currency;
use App\GroceryItem;
use Carbon\Carbon;
// use Paytabs;
use App\Location;
use App\User;
use Illuminate\Http\Request;
//  etlu kam nu nathi aevu hoi to comment mari dav? hu karu 6u
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
        // return view('home');
        
        $master = array();

        $master['users'] = User::where('role',0)->get()->count();
        $master['delivery'] = User::where('role',2)->get()->count();
        $sales = Order::all();
        $orders = Order::all();
        $currency_code = Setting::where('id',1)->first()->currency;

        $users = User::where('role',0)->orderBy('id', 'DESC')->get();  
        foreach ($users as $value) {
            $value->orders = Order::where('user_id',$value->id)->get()->count();
        }
       // dd('mm');
       // $shops = GroceryShop::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->get();

      

        $categories = Category::orderBy('id','DESC')->get();
        //$location = Location::orderBy('id', 'DESC')->get();
        //dd('mm');
         $store_users_count = User::where('role' , 4)->count();
         $tech_users_count = User::where('role' , 3)->count();
        return view('admin.dashboard',['master'=>$master,'users'=>$users, 'orders'=>$orders ,  'category' => $categories , 'tech_users_count'=>$tech_users_count , 'store_users_count' =>$store_users_count]);
    }

    public function paytabsPayment(){
  
    //     $pt = Paytabs::getInstance("bansi.thirstydevs@gmail.com", "fUCC5bEtajZdPSm5s4AumaMU5QOyH9SW4vy9GdDRwD4lwqrYv2sRdeLi5AQMKJJOeiYVvCM2fQoMhPKNScE5rqox0ekLY3zcmy8S");
    //     //  dd(url('/'));
        
    //     $result = $pt->create_pay_page(array(       
    //         "merchant_email" => "bansi.thirstydevs@gmail.com",
    //         'secret_key' => "fUCC5bEtajZdPSm5s4AumaMU5QOyH9SW4vy9GdDRwD4lwqrYv2sRdeLi5AQMKJJOeiYVvCM2fQoMhPKNScE5rqox0ekLY3zcmy8S",
    //         'title' => "John Doe",
    //         'cc_first_name' => "John",
    //         'cc_last_name' => "Doe",
    //         'email' => "customer@email.com",
    //         'cc_phone_number' => "973",
    //         'phone_number' => "33333333",
    //         'billing_address' => "Juffair, Manama, Bahrain",
    //         'city' => "Manama",
    //         'state' => "Capital",
    //         'postal_code' => "97300",
    //         'country' => "BHR",
    //         'address_shipping' => "Juffair, Manama, Bahrain",
    //         'city_shipping' => "Manama",
    //         'state_shipping' => "Capital",
    //         'postal_code_shipping' => "97300",
    //         'country_shipping' => "BHR",
    //         "products_per_title"=> "Mobile Phone",
    //         'currency' => "BHD",
    //         "unit_price"=> "10",
    //         'quantity' => "1",
    //         'other_charges' => "0",
    //         'amount' => "10.00",
    //         'discount'=>"0",
    //         "msg_lang" => "english",
    //         "reference_no" => "1231231",
    //         "site_url" => "www.test.com",
    //         'return_url' => url('/')."/check_payment",
    //         "cms_with_version" => "API USING PHP"
    //     ));
       
    //     if($result->response_code == 4012){
    //         return redirect($result->payment_url);
    //     }else{
    //         return $result->result;
    //     }                   
    }

    public function check_payment(Request $request){
    //     $detail = PaymentSetting::find(1);

    //     $pt = Paytabs::getInstance($detail->paytab_email, $detail->paytab_secret_key);
    //     $result = $pt->verify_payment($request->payment_reference);
       
    //     if($result->response_code == 100){
    //         return response()->json(['success'=>true,'msg'=>null ,'data' =>$result ], 200);             
    //     }  
    //     else{
    //         return response()->json(['success'=>false,'msg'=>null ,'data' =>$result ], 200);             
    //     }
        
    }

    
}
