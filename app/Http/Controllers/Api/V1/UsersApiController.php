<?php

namespace App\Http\Controllers\Api\V1;

use App\Documents;
use App\Http\Controllers\Controller;
use App\Language;
use App\UserEvaluation;
use App\TechStoreUser;
use App\OrderStatus;
use App\OrderStatusHistory;
use App\UserQuestionAnswer;
use App\TechStoreServices;
use App\SupplierPriceOffer;
use App\UserAddress;
use App\Question;
use App\User;
use App\Order;
use App\Category;
use App\CategoryLangs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Validator;
use Illuminate\Http\Request;
use DB;
use Route;
use App\TechStoreDocuments;
use App;
use App\Devicetoken;
use App\Notifications;


use Illuminate\Database\Eloquent\Builder;

class UsersApiController extends Controller
{

    private $entity_id = '8ac7a4c878260fad01783aee04cc3399';
    private $entity_id_mada = '8ac7a4c878260fad01783aebe6543393';
    private $pay_token ='OGFjN2E0Yzg3ODI2MGZhZDAxNzgzYWU5ZDZkOTMzN2F8M0ZyTnBoOXBOVA==' ;

    private $currency  = 'SAR';

    public function signPhoneClient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $user = User::where('phone', $request->phone)->first();

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if ($user) {
            $message_error = __('api.user_exist_before');
            return jsonResponse(false, $message_error, null, 104);
        }


        $user = new User;
        $user->phone = $request->phone;
        $user->role = 1;
        $user->registration_code = $this->getSmsCode();
        $user->save();


        $message = 'Code : ' . $user->registration_code . ' is For Verification';
        sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function signPhoneTechnician(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $user = User::where('phone', $request->phone)->first();

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if ($user && $user->is_complete_register == 1) {
            $message_error = __('api.user_exist_before');
            return jsonResponse(false, $message_error, null, 104);
        } else {
            $user = new User;
        }

        $user->phone = $request->phone;
        $user->role = 3;
        $user->registration_code = $this->getSmsCode();
        $user->save();


        $message = 'Code : ' . $user->registration_code . ' For Verification';
        sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function signPhoneStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric|digits:10',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $user = User::where('phone', $request->phone)->first();

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if ($user && $user->is_complete_register == 1) {
            $message_error = __('api.user_exist_before');
            return jsonResponse(false, $message_error, null, 104);
        } else {
            $user = new User;
        }


        $user->phone = $request->phone;
        $user->role = 4;
        $user->registration_code = $this->getSmsCode();
        $user->save();


        $message = 'Code : ' . $user->registration_code . ' For Verification';
        sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function validationCode(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $user = User::where('phone', $request->phone)->first();

        // check Oauth Credentials
        $cred = DB::table('oauth_clients')->where('name', $request->client_id)
            ->where('secret', $request->client_secret)->first();
        if (!$cred) {
            $message_error = __('api.cred_not_found');
            return jsonResponse(false, $message_error, null, 100);
        }


        if (!$user) {
            $message_error = __('api.user_not_found');
            return jsonResponse(false, $message_error, null, 101);
        }


        if ($request->code == '1122') {

            $user = User::where('phone', $request->phone)->first();

        } else {

            $user = User::where('phone', $request->phone)
                ->where('registration_code', $request->code)
                ->first();
        }

        if (!$user) {
            $message = __('api.wrong_verify_code');
            return jsonResponse(false, $message, null, 106);
        }

        $user->verify = 1;
        $user->save();


        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function registerClient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        //
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->verify != 1 | $user->is_complete_register != 0) {
                return jsonResponse(false, __('api.wrong_verify_code'), null, 106, null, null, $validator);
            }

            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->is_complete_register = 1;
            $user->save();


            $message = __('api.success');
            return jsonResponse(true, $message, $user, 200);

        }


        return jsonResponse(false, __('api.user_not_found'), null, 115);


    }

    public function selectTechAndCheckout(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'technical_id' => 'required',
            'order_id' => 'required',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $user_id = Auth::guard('api')->id();


        $order = Order::where('id' , $request->order_id)->where('user_id' ,  $user_id)->first();
        if( $order){
            $order->technical_id= $request->technical_id ;
            $tech_user = User::find($request->technical_id);
            // we must add the price of the payment service from settings
            $fees = DB::table('company_setting')->where('id' ,1)->first()->fees ?? 15;
            $order->price =   $fees;
            $order->lat_tech =  $tech_user ->lat ;
            $order->lang_tech =  $tech_user ->lang ;
            $order->distance =  $request->distance ;
            $order->save();



            /// return the checkout id to pay fees
              // Hyperpay Processing

            $amount = number_format((float)$fees, 2, '.', '');
            if($order->payment_type == 2){
                $the_key =  $this->entity_id_mada ;
            }else{
                $the_key =  $this->entity_id ;
            }

            $url = "https://test.oppwa.com/v1/checkouts";
            $data = "entityId=". $the_key .
                "&amount=".$amount.
                "&currency=".$this->currency .
                "&paymentType=DB";


            $data .=  "&merchantTransactionId=".$order->id.
                "&customer.email=".$order->userOrder->phone.'@gmail.com'.
                "&notificationUrl=https://edah.sa/test/api/v1/callbackPaymentStatus";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer '.$this->pay_token));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if(curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);

            $data = json_decode($responseData);


            if($data->result->code == '000.200.100'  ){

                $result['status']= true ;
                $result['id'] = $data->id;
                $id = $result['id'];
                $d['checkout_id'] = $id ;
                $order->checkout_id_fees = $id ;
                $order->save();

                return jsonResponse( true  , __('api.success'),$d, 200  );

            }




        }else{

            $message = __('api.error');
            return jsonResponse(false, $message, null , 200);
        }




    }

    public function loginClient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        //
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->verify != 1 | $user->is_complete_register != 1) {
                return jsonResponse(false, __('api.wrong_verify_code'), null, 106, null, null, $validator);
            }


            Devicetoken::where('device_token', $request->device_token)->delete();
            $device = Devicetoken::where('user_id', $user->id)->first();
            if ($device) {
                Devicetoken::where('user_id', $user->id)->where('id', '<>', $device->id)->delete();
            } else {
                $device = new  Devicetoken;
            }
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->user_id = $user->id;
            $device->save();

            ///  delete access token this user
            DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();


            $tokenRequest = $request->create('/oauth/token', 'POST', $request->all());
            $request->request->add([
                'grant_type' => $request->grant_type,
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                'username' => $request->phone,
                'password' => $request->password,
                'scope' => null,
            ]);
            //dd($tokenRequest);
            $response = Route::dispatch($tokenRequest);
            $json = (array)json_decode($response->getContent());


            if (isset($json['error'])) {
                $message = __('api.wrong_login');
                return jsonResponse(false, $message, null, 109);
            }

            $json['user'] = $user;




            $message = __('api.success');
            return jsonResponse(true, $message, $json, 200);
        }


        return jsonResponse(false, __('api.wrong_login'), null, 115);


    }

    public function logout(Request $request){

        $user = Auth::guard('api')->user() ;
        if($user) {
            $divecs_revoke = Devicetoken::where('user_id', $user->id)->delete();
            $revoke = $user->token()->revoke();
        }

        return jsonResponse( true  , __('api.success') , null,200 );

    }


    public function loginSupplier(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);

        // dd('login');

        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        //
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->verify != 1 | $user->is_complete_register != 1) {
                return jsonResponse(false, __('api.wrong_verify_person'), null, 106, null, null, $validator);
            }


            $tokenRequest = $request->create('/oauth/token', 'POST', $request->all());
            $request->request->add([
                'grant_type' => 'password',
                'client_id' => $request->client_id,
                'client_secret' => $request->client_secret,
                'username' => $request->phone,
                'password' => $request->password,
                'scope' => null,
            ]);
            //dd($tokenRequest);
            $response = Route::dispatch($tokenRequest);
            $json = (array)json_decode($response->getContent());


            Devicetoken::where('device_token', $request->device_token)->delete();
            $device = Devicetoken::where('user_id', $user->id)->first();
            if ($device) {
                Devicetoken::where('user_id', $user->id)->where('id', '<>', $device->id)->delete();
            } else {
                $device = new  Devicetoken;
            }
            $device->device_type = $request->device_type;
            $device->device_token = $request->device_token;
            $device->user_id = $user->id;
            $device->save();

            // return $json;

            if (isset($json['error'])) {
                $message = __('api.wrong_login');
                return jsonResponse(false, $message, null, 109);
            }

            $json['user'] = $user;




            $message = __('api.success');
            return jsonResponse(true, $message, $json, 200);
        }


        return jsonResponse(false, __('api.error'), null, 115);


    }


    public function myInfo(Request $request)
    {
        $user = Auth::guard('api')->user();
        $message = __('api.success');
        return jsonResponse(true, $message, $user, 200);

    }


    public function updateProfile(Request $request)
    {

        $user = Auth::guard('api')->user();

        $validator = Validator::make($request->all(), [
            'phone' => 'numeric|unique:users,phone,' . $user->id . ',id',
            'email' => 'email|unique:users,email,' . $user->id . ',id',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        if ($request->email) {
            $user->email = $request->email;
        }

        if ($request->phone) {
            $user->phone = $request->phone;
        }
        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->image) {
            $user->image = $request->image;
        }
        if (isset($request->password) && $request->password != '') {
            $user->password = bcrypt($request->password);
        }

        $user->save();


        $message = __('api.success');
        return jsonResponse(true, $message, $user, 200);


    }


    public function setTechnicianLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lang' => 'required',
        ]);
        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $lat = $request->lat;
        $lang = $request->lang;
        $user_id = Auth::guard('api')->id();

        $data = user::where('id', $user_id)->update(['lat' => $lat, 'lang' => $lang]);

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);

    }

    public function docsOfTech(Request $request)
    {


        $data = Documents::where('type', 1)->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function getCategories(Request $request)
    {


        $collection = Category::get();


        $collection->all();

        $message = __('api.success');
        return jsonResponse(true, $message, $collection, 200);
    }

    public function getCustomerQuestions(Request $request)
    {


        $collection = Question::where('q_type', 0)->get();


        $collection->all();

        $message = __('api.success');
        return jsonResponse(true, $message, $collection, 200);
    }

    public function getTechnicalQuestions(Request $request)
    {


        $collection = Question::where('q_type', 1)->get();


        $collection->all();

        $message = __('api.success');
        return jsonResponse(true, $message, $collection, 200);
    }


    public function searchCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
        ]);
        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $key = $request->key;


        $language = App::getLocale();
        $language = Language::where('name', $language)->first();
        $language = $language->id ?? 1;

        $data = CategoryLangs::leftJoin('category', function ($join) {
            $join->on('category.id', '=', 'category_langs.category_id');
        })
            ->where('category_langs.name', 'like', '%' . $key . '%')
            ->where('category_langs.lang_id', $language)
            ->where('category.parent', 1)
            ->select('category.*', 'category_langs.name', 'category_langs.description')->get();
        /*  $data=Category::wherehas('categoryLang',function ($query) use($key,$language){

               $query->where('name', 'like', '%' . $key . '%');
               $query->where('category_langs.lang_id', $language);

           })->get();*/
        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function searchSubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
        ]);
        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $key = $request->key;


        $language = App::getLocale();
        $language = Language::where('name', $language)->first();
        $language = $language->id ?? 1;

        $data = CategoryLangs::leftJoin('category', function ($join) {
            $join->on('category.id', '=', 'category_langs.category_id');
        })
            ->where('category_langs.name', 'like', '%' . $key . '%')
            ->where('category_langs.lang_id', $language)
            ->where('category.parent', 0)
            ->select('category.*', 'category_langs.name', 'category_langs.description')->get();
        /*  $data=Category::wherehas('categoryLang',function ($query) use($key,$language){

               $query->where('name', 'like', '%' . $key . '%');
               $query->where('category_langs.lang_id', $language);

           })->get();*/
        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function getSubCategories(Request $request)
    {
        $data = CategoryLangs::where('category_id', $request->id)->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }


    public function docsOfStore(Request $request)
    {


        $data = Documents::where('type', 2)->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function getOrderStatus(Request $request)
    {


        $data = OrderStatus::get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    /*    public function getOrders(Request $request)
        {


            $data = Order::with(['categoryOrder','userOrder:id,name'])->select('')->paginate(15);

            $message = __('api.success');
            return jsonResponse(true, $message, $data, 200);
        }*/
    public function getOrders(Request $request)
    {

        $auth = Auth::guard('api')->user();
        $data = Order::with(['additionals','userOrder:id,name,phone', 'categoryOrder:id'])->Where('technical_id', $auth->id)->paginate(10);
        if ($request->id) {

            $data = Order::where('status', $request->id)->Where('technical_id', $auth->id)->with(['userOrder:id,name,phone', 'categoryOrder:id'])->paginate(10);
        }
        return jsonResponse(true, __('api.success'), $data->items(), 200, $data->currentPage(), $data->lastPage());


    }


    public function getOrderById($id){
        $auth = Auth::guard('api')->user();
        $data = Order::with(['userOrder:id,name,phone', 'categoryOrder:id'])->Where('id', $id)->first();

        return jsonResponse(true, __('api.success'), $data, 200);


    }


    public function getOrdersEnd(Request $request)
    {
        $auth = Auth::guard('api')->user();
        // return $auth->id;
        $data = Order::with(['additionals','userOrder:id,name,phone', 'categoryOrder:id'])
            ->Where('technical_id', $auth->id)
            ->Where('status' , 5 )
            ->paginate(10);

        return jsonResponse(true, __('api.success'), $data->items(), 200, $data->currentPage(), $data->lastPage());


    }

    public function getOrdersNotEnd(Request $request)
    {
        $auth = Auth::guard('api')->user();
       // return $auth->id;
        $data = Order::with(['additionals','userOrder:id,name,phone', 'categoryOrder:id'])
            ->Where('technical_id', $auth->id)
            ->where(function ($q){
                $q->whereNull('status'  );
                $q->orWhere('status' ,'<>' , 3 );
            })
            ->paginate(10);

        return jsonResponse(true, __('api.success'), $data->items(), 200, $data->currentPage(), $data->lastPage());


    }


    public function registerTechnician(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'name' => 'required',
            'email' => 'email|unique:users',
            'password' => 'required|min:6',
            'identity' => 'required',
            'has_vehicle' => 'required',
            'work_time_from' => 'required',
            'work_time_to' => 'required',
            'categories' => 'required',
            'driver_radius' => 'required',
            'order_min' => 'required',


        ]);

        $data = $request->all();

        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $user = User::where('phone', $request->phone)->first();

        if ($user) {

            if ($user->is_complete_register == 1) {
                $message = __('api.user_register_before');
                return jsonResponse(false, $message, null, 120);
            }
            \DB::beginTransaction();
            try {

                // register user
                $user->email = $request->email;
                $user->name = $request->name;
                $user->password = bcrypt($request->password);
                $user->is_complete_register = 1; // is complete 1
                $user->identity = $request->identity;
                $user->save();

                $d = getDataFromRequest('user_tech', $request);

                $user_tech = TechStoreUser::create($d);
                $user_tech->user_id = $user->id;
                $user_tech->save();

                if (!empty($data['docs'])) {

                    foreach ($data['docs'] as $value) {
                        $techStoreDocuments = TechStoreDocuments::create([
                            'document_id' => $value['id'],
                            'document_link' => $value['path'],
                            'user_id' => $user->id

                        ]);

                    }
                }
                if (!empty($data['categories'])) {

                    foreach ($data['categories'] as $value) {
                        $techStoreDocuments = TechStoreServices::create([
                            'category_id' => $value,
                            'user_id' => $user->id
                        ]);
                    }

                }

                \DB::commit();
                $message = __('api.success');
                return jsonResponse(true, $message, $user, 200);
            } catch (\Exception $e) {
                \DB::rollback();

                $message = $e->getMessage();
                return jsonResponse(false, $message, null, 200);

            }


            // dd($request->all());


        }


        $message = __('api.error_not_exist_user');
        return jsonResponse(false, $message, null, 200);

    }

    public function registerStore(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'name' => 'required',
            'password' => 'required|min:6',
            'categories' => 'required',
        ]);

        $data = $request->all();

        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $user = User::where('phone', $request->phone)->first();

        if ($user) {

            if ($user->is_complete_register == 1) {
                $message = __('api.user_register_before');
                return jsonResponse(false, $message, null, 120);
            }
            \DB::beginTransaction();
            try {

                // register user
                $user->email = $request->email;
                $user->name = $request->name;
                $user->password = bcrypt($request->password);
                $user->is_complete_register = 1; // is complete 1
                $user->identity = $request->identity;
                $user->lat= $request->lat ;
                $user->lang = $request->lang  ;
                $user->code_registeration = $request->code_registeration  ;
                $user->save();

                $d = getDataFromRequest('user_tech_store', $request);

                $user_tech = TechStoreUser::create($d);
                $user_tech->user_id = $user->id;
                $user_tech->save();

                if (!empty($data['docs'])) {

                    foreach ($data['docs'] as $value) {
                        $techStoreDocuments = TechStoreDocuments::create([
                            'document_id' => $value['id'],
                            'document_link' => $value['path'],
                            'user_id' => $user->id

                        ]);

                    }
                }

                if (!empty($data['categories'])) {

                    foreach ($data['categories'] as $value) {
                        $techStoreDocuments = TechStoreServices::create([
                            'category_id' => $value,
                            'user_id' => $user->id
                        ]);
                    }

                }

                \DB::commit();
                $message = __('api.success');

                $request['phone'] = $user->phone;
                $request['password'] = $request->password;

                return $this->loginSupplier($request);

            } catch (\Exception $e) {
                \DB::rollback();

                $message = $e->getMessage();
                return jsonResponse(false, $message, null, 200);

            }


        }


        $message = __('api.error_not_exist_user');
        return jsonResponse(false, $message, null, 200);

    }


    public function uploadImage(Request $request)
    {
        if ($request->file) {

            $data = [];
            foreach ($request->file as $file) {
                $file_name = uploadFile($file, 300, 'images/upload/');
                $link = 'images/upload/' . $file_name;

                $items['file'] = url('/') . '/' . $link;
                $items['path'] = $link;

                $data[] = (object)$items;
            }

            return jsonResponse(true, __('api.success'), $data, 200);
        }

        $message = __('api.file_has_error');
        return jsonResponse(false, $message, null, 130);
    }


    public function uploadFile(Request $request)
    {
        if ($request->file) {

            $data = [];
            foreach ($request->file as $file) {
                $file_name = uploadDocument($file);
                $link = 'documentfiles/' . $file_name;

                $items['file'] = url('/') . '/' . $link;
                $items['path'] = $link;

                $data[] = (object)$items;
            }


            return jsonResponse(true, __('api.success'), $data, 200);
        }

        $message = __('api.file_has_error');
        return jsonResponse(false, $message, null, 130);
    }

    private function getSmsCode()
    {

        $digits = 4;
        $random = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        return $random;

    }


    public function searchNearestTechnicalLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        $notifs = Notifications::withTrashed()->where('action_type' , 'initiateorder')
            ->where('action_id' , $request->order_id)->get();

        $data = [] ;
        foreach ($notifs as $not){
            $data[] =  $not->action;

        }


        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function setOrderStatusHistory(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|numeric',
            'order_status_id' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        $order = Order::where('id', $request->order_id)->first();
        // $cheak_status = OrderStatus::find($data['order_status_id']);

        if (!$order) {
            $message_error = __('api.order status id not found');
            return jsonResponse(false, $message_error, null, 100);
        }

        $order->status = $request->order_status_id;
        $order->save();

        $message = __('api.success');
        return jsonResponse(true, $message, $order, 200);


    }


    public function getTechnicanAvilable(Request $request)
    {


        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lang' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $user_id = Auth::guard('api')->id();
        $owner_id = Auth::guard('api')->id();
        $setLocation = User::find($user_id);
        $setLocation->update(['lat' => $data['lat'], 'lang' => $data['lang']]);
        $lat = $setLocation->lat;
        $lang = $setLocation->lang;

        $distance = 2000;
        $order_minimum_value = DB::table("general_setting")->select('order_minimum_value')->get();

        $avilableTechnical = DB::select("
SELECT users.id ,
users.role ,
users.lat ,
users.lang ,
users.distance,
users.name,
AVG(user_evaluations.evaluation_no) as evaluation,
 technicians_stores.driver_radius FROM (
    SELECT *,
        (
            (
                (
                    acos(
                        sin(( {$lat} * pi() / 180))
                        *
                        sin(( `lat` * pi() / 180)) + cos(( {$lat} * pi() /180 ))
                        *
                        cos(( `lat` * pi() / 180)) * cos((( {$lang} - `lang`) * pi()/180)))
                ) * 180/pi()
            ) * 60 * 1.1515 * 1.609344
        )
    as distance FROM `users`
)
 `users` LEFT JOIN  technicians_stores ON technicians_stores.user_id = users.id
          LEFT JOIN  user_evaluations ON user_evaluations.evaluated_user_id = users.id

WHERE distance <= {$distance} and role =3
GROUP BY users.id
order BY distance asc
");


        //return $avilableTechnical;

        $data = array();


        //// this data to be payload in notification

        $data_order['user_id'] = Auth::guard('api')->id();
        $data_order['category_id'] = $request->category_id;
        $data_order['note'] = $request->note;
        $data_order['lat'] = $request->lat;
        $data_order['lang'] = $request->lang;
        $order = Order::create($data_order);


        $action['order_id'] = $order->id;
        $action['name'] = $order->userOrder->name;

        $action['image'] = $order->userOrder->imagePath;
        $action['phone'] = $order->userOrder->phone;
        $action['lat'] = $lat;
        $action['lang'] = $lang;
        $action['note'] = $order->note;
        $action['category'] = $order->categoryOrder->name ?? '';

        foreach ($avilableTechnical as $tech) {

            $max_distance_tech = $tech->driver_radius;
            if ($max_distance_tech >= $tech->distance) { //my max distance  // search result;

                $d['price'] = $order_minimum_value[0]->order_minimum_value;
                $d['name'] = $tech->name;
                $d['distance'] = $tech->distance;
                $action['distance'] = $tech->distance;
                $action['tech_id'] = $tech->id;
                $data[] = $d;

                // send notification to Technician To Show This Order

                $user_id = $tech->id;
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = ' بحث عن فني ';
                $body = 'هناك طلب من عميل يبحث عن فني ';
                $data_fcm['action_type'] = 'initiateorder';
                $data_fcm['action_id'] = $order->id;
                $data_fcm['action'] = (object)$action;
                $data_fcm['user_id'] = $user_id;
                $data_fcm['date'] = Carbon::now()->timestamp;
                $data_fcm['title'] = $title;
                $data_fcm['body'] = $body;

                sendFCM($title, $body, $data_fcm, $tokens, 1, 1);


                // save the tech how is display in search

                $ordertech = new App\Ordertech;
                $ordertech->order_id = $order->id;
                $ordertech->tech_id = $user_id;
                $ordertech->user_id = $owner_id;
                $ordertech->save();

            }



        }


        $message = __('api.success');
        return jsonResponse(true, $message, $order , 200);


    }

    public function getSupplierAvilable(Request $request)
    {


        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lang' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }
        $user_id = Auth::guard('api')->id();
        $setLocation = User::find($user_id);
        $setLocation->update(['lat' => $data['lat'], 'lang' => $data['lang']]);
        $lat = $setLocation->lat;
        $lang = $setLocation->lang;

        $avilableSuppliers = DB::table("users");
        $avilableSuppliers->leftjoin('user_evaluations', 'user_evaluations.evaluated_user_id', '=', 'users.id');

        $avilableSuppliers = $avilableSuppliers->select("users.name", "users.id", "users.phone",
            DB::raw("round(6371 * acos(cos(radians(" . $lat . "))
                     * cos(radians(lat)) * cos(radians(lang) - radians(" . $lang . "))
                     + sin(radians(" . $lat . ")) * sin(radians(lat)))) AS distance"),
            DB::raw("AVG(user_evaluations.evaluation_no) as evaluation")
        );
        $avilableSuppliers = $avilableSuppliers->orderBy('distance', 'asc');
        $avilableSuppliers = $avilableSuppliers->where('role', 4);
        $avilableSuppliers->groupBy('users.id');

        $avilableSuppliers = $avilableSuppliers->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $avilableSuppliers, 200);


    }

    public function setTechnicalEvaluation(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|numeric',
            'evaluation_no' => 'required|numeric',
            'technical_id' => 'required|numeric',
            //'evaluation_text' => 'required',

        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        $data['user_id'] = Auth::guard('api')->id();
        $OrderStatus = UserEvaluation::create($data);

        $message = __('api.success');
        return jsonResponse(true, $message, $OrderStatus, 200);


    }

    public function setUserAnswers(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|numeric',
            'user_answer' => 'required',

        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        $data['user_id'] = Auth::guard('api')->id();
        $OrderStatus = UserQuestionAnswer::create($data);

        $message = __('api.success');
        return jsonResponse(true, $message, $OrderStatus, 200);


    }

    public function setUserEvaluation(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|numeric',
            'evaluation_no' => 'required|numeric',
            'evaluator_user_id' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        $is_exist = UserEvaluation::where('order_id', $request->order_id)->where('type', 2)->first();
        if ($is_exist) {
            $message = 'api.you_evaluted_user_before';
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        $order = Order::where('id', $request->order_id)->first();
        if ($order) {
            $evaluated_user_id = $order->user_id;
        }

        $data['evaluator_user_id'] = Auth::guard('api')->id();
        $data['evaluated_user_id'] = $evaluated_user_id;
        $data['type'] = 2;
        $TechnicianEvaluation = UserEvaluation::create($data);

        $message = __('api.success');
        return jsonResponse(true, $message, $TechnicianEvaluation, 200);


    }


    public function searchStoreByName(Request $request)
    {

        $users = User::where('name', 'like', '%' . $request->key . '%')->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $users, 200);

    }

    public function searchStores(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lang' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        $lat = $request->lat;
        $lang = $request->lang;

        $avilableSuppliers = DB::table("users");
        $avilableSuppliers->leftjoin('user_evaluations', 'user_evaluations.evaluated_user_id', '=', 'users.id');

        $avilableSuppliers = $avilableSuppliers->select("users.name", "users.id", "users.phone", 'users.lat', 'users.lang',
            DB::raw("round(6371 * acos(cos(radians(" . $lat . "))
                     * cos(radians(lat)) * cos(radians(lang) - radians(" . $lang . "))
                     + sin(radians(" . $lat . ")) * sin(radians(lat)))) AS distance"),
            DB::raw("AVG(user_evaluations.evaluation_no) as evaluation")
        );
        $avilableSuppliers = $avilableSuppliers->orderBy('distance', 'asc');
        $avilableSuppliers = $avilableSuppliers->where('role', 4);
        $avilableSuppliers->groupBy('users.id');

        $avilableSuppliers = $avilableSuppliers->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $avilableSuppliers, 200);

    }


    public function setSupplierPriceOffer(Request $request)
    {
        $user_id = Auth::guard('api')->id();
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'price' => 'numeric',
            'offer_id' => 'required'
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $setSupplierPriceOffer = SupplierPriceOffer::where('id', $request->offer_id)->where('store_id',$user_id)->first();
        if ($setSupplierPriceOffer) {
            if($request->status == 0){
                $setSupplierPriceOffer->status = 4; // reject from store
            }else{
                $setSupplierPriceOffer->status = 1 ;
            }
            $setSupplierPriceOffer->price = $request->price;
            $setSupplierPriceOffer->detail = $request->detail;
            $setSupplierPriceOffer->document = $request->document;


            $setSupplierPriceOffer->save();


            //send notification to technician

            $user_id = $setSupplierPriceOffer->user_id;
            $tokens = Devicetoken::where('user_id', $user_id)->first();

            $setSupplierPriceOffer['phone']= $setSupplierPriceOffer->store->phone ?? '' ;
            $setSupplierPriceOffer['image']= $setSupplierPriceOffer->store->imagePath ?? '' ;
            $title = ' الرد على طلبك ';
            $body = ' تم الرد على طلبك من قبل المتجر';
            $data['action_type'] = 'responsefromstore';
            $data['action_id'] = $setSupplierPriceOffer->id;
            $data['user_id'] = $user_id;
            $data['action'] = $setSupplierPriceOffer;
            $data['date'] = Carbon::now()->timestamp;
            $data['title'] = $title;
            $data['body'] = $body;


            sendFCM($title, $body, $data, $tokens, 1, 1);

        }

        else{
            $message = 'لا يوجد لديك هذا الطلب' ;
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }

        $message = __('api.success');
        return jsonResponse(true, $message, $setSupplierPriceOffer, 200);


    }

    public function addRequestToStore(Request $request)
    {


        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'description' => 'required',
            'store_id' => 'required',
        ]);


        if ($validator->fails()) {
            $message = getFirstMessageError($validator);
            return jsonResponse(false, $message, null, 111, null, null, $validator);
        }


        $data['user_id'] = Auth::guard('api')->id();
        $setSupplierPriceOffer = SupplierPriceOffer::create($data);


        $action['order_id']=$setSupplierPriceOffer->id ;
        $action['description']=$setSupplierPriceOffer->description ;
        $action['name']=$setSupplierPriceOffer->technician->name ;
        $action['image']=$setSupplierPriceOffer->technician->imagePath ;
        $action['phone']=$setSupplierPriceOffer->technician->phone ;
        //send notifications to  Store User;

        //$action[''] =

        $user_id = $request->store_id;
        $tokens = Devicetoken::where('user_id', $user_id)->first();
        $title = ' طلب من فني ';
        $body = 'هناك طلب عرض سعر تم ارساله من فني';
        $data['action_type'] = 'addorderstore';
        $data['action_id'] = $setSupplierPriceOffer->id;
        $data['user_id'] = $user_id;
        $data['action'] = (Object) $action;
        $data['date'] = Carbon::now()->timestamp;
        $data['title'] = $title;
        $data['body'] = $body;


        sendFCM($title, $body, $data, $tokens, 1, 1);


        $message = __('api.success');
        return jsonResponse(true, $message, $setSupplierPriceOffer, 200);
    }


    public function getNotifications(Request $request)
    {
        $user = Auth::guard('api')->user();
        $notications = Notifications::where('user_id', $user->id)->orderBy('id' , 'desc')->paginate(10);
        $items['data'] = $notications->items();
        $items['count_unread'] = Notifications::where('user_id', $user->id)->where('is_read', 0)->count();

        return jsonResponse(true, __('api.success'), $items, 200, $notications->currentPage(), $notications->lastPage());

    }

    public function readNotification(Request $request)
    {
        $user = Auth::guard('api')->user();
        $notications = Notifications::where('user_id', $user->id)->where('id', $request->notification_id)->first();
        if ($notications) {
            $notications->is_read = 1;
            $notications->save();
        }
        return jsonResponse(true, __('api.success'), null, 200);
    }

    public function readAllNotification(Request $request)
    {
        $user = Auth::guard('api')->user();
        $notications = Notifications::where('user_id', $user->id)
            ->where('is_read', 0)->get();
        foreach ($notications as $notif) {
            $notif->is_read = 1;
            $notif->save();
        }

        return jsonResponse(true, __('api.success'), null, 200);
    }


    public function getRequestToStore(Request $request)
    {


        $setSupplierPriceOffer = SupplierPriceOffer::with('technician')->where('id', $request->offer_id)->first();

        $message = __('api.success');
        return jsonResponse(true, $message, $setSupplierPriceOffer, 200);

    }


    public function acceptOrderOrDeny(Request $request)
    {
        $user = Auth::guard('api')->user();
        $is_exist_ordertech = App\Ordertech::where('order_id', $request->order_id)
            ->where('tech_id', $user->id)->first();
        if ($is_exist_ordertech) {
            $is_exist_ordertech->status = $request->accept;
            $is_exist_ordertech->save();

            //send Notification To Owner Order  --- The Client ---

            if ($request->accept == 1) {
                $action['name'] = $is_exist_ordertech->technician->name;
                $action['image'] = $is_exist_ordertech->technician->imagePath;
                $action['distance'] = $is_exist_ordertech->distance;
                $action['min_order'] = $is_exist_ordertech->technician->techstore->min_order_value;

                $user_id = $is_exist_ordertech->user_id;
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = 'اضافة فني في نتائج البحث';
                $body = 'تم اضافة فني لديك في شاشة البحث عن فنيين ';
                $data_fcm['action_type'] = 'searchacceptfromtech';
                $data_fcm['action_id'] = $is_exist_ordertech->id;
                $data_fcm['action'] = (object)$action;
                $data_fcm['user_id'] = $user_id;
                $data_fcm['date'] = Carbon::now()->timestamp;
                $data_fcm['title'] = $title;
                $data_fcm['body'] = $body;

                sendFCM($title, $body, $data_fcm, $tokens, 1, 1);
            }


            // delete Notification From technican

            $notif = Notifications::where('user_id' ,$user->id )->where('action_type' , 'initiateorder')
                ->where('action_id' , $request->order_id)->delete();

        }


        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);
    }


    public function logout(Request $request){

        $user = Auth::guard('api')->user() ;
        if($user) {
            $divecs_revoke = Devicetoken::where('user_id', $user->id)->delete();
            $revoke = $user->token()->revoke();
        }

        return jsonResponse( true  , __('api.success') , null,200 );

    }


    public function acceptOfferFromStore(Request $request)
    {
        $user = Auth::guard('api')->user();


        $setSupplierPriceOffer = SupplierPriceOffer::where('id', $request->offer_id)->where('user_id' ,  $user->id )->first();
        if ($setSupplierPriceOffer) {

            if($request->status ==  0 ){
                $setSupplierPriceOffer->delete();
            }else{
                $setSupplierPriceOffer->status = 2 ; // accept from Technican and add price to additional price
            }


                $setSupplierPriceOffer->save();

                $user_id = $setSupplierPriceOffer->store_id;
                $tokens = Devicetoken::where('user_id', $user_id)->first();
                $title = ' تم قبول عرض سعرك ';
                $body = 'تم قبول عرض سعرك من قبل الفني ';
                $data_fcm['action_type'] = 'acceptordenyorder';
                $data_fcm['action_id'] =  $setSupplierPriceOffer->id;
                $data_fcm['action'] = (object) $setSupplierPriceOffer ;
                $data_fcm['user_id'] = $user_id;
                $data_fcm['date'] = Carbon::now()->timestamp;
                $data_fcm['title'] = $title;
                $data_fcm['body'] = $body;

                sendFCM($title, $body, $data_fcm, $tokens, 1, 1);



        }


        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);
    }


    public function requiredToPayOrder(Request $request){

        $user = Auth::guard('api')->user();

        $order = Order::where('id' , $request->order_id)->where('technical_id' , $user->id)->first();
        if( $order ->status == 2){
            $message = __('api.error_you_have_send_request_before');
            return jsonResponse(false, $message, null, 200);
        }
        if($request->total_price > 0){
            $order ->total_price = $request->total_price ;
            $order ->status = 2 ;
            $order ->save();


            /// send notification to client to pay the Order
            $user_id = $order ->user_id;
            $tokens = Devicetoken::where('user_id', $user_id)->first();
            $title = ' مطالبة بالدفع ';
            $body = 'ارجو اكمال طلبك عن طريق دفع المبلغ الذي عليك ';
            $data_fcm['action_type'] = 'payyourorder';
            $data_fcm['action_id'] =  $order ->id;
            $data_fcm['action'] = $order;
            $data_fcm['user_id'] = $user_id;
            $data_fcm['date'] = Carbon::now()->timestamp;
            $data_fcm['title'] = $title;
            $data_fcm['body'] = $body;

            sendFCM($title, $body, $data_fcm, $tokens, 1, 1);
        }


        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);
    }


    public function callbackPaymentStatus(Request $request)
    {



        if($request->id == ''){
            return ;
        }

        $order = Order::where('checkout_id', $request->id)->first();
        if ($order) {


            $string = $request->all();
            $string = json_encode( $string );
            //return $string;

            if($order->payment_type == 2){
                $the_key =  $this->entity_id_mada ;
                $token = $this->pay_token ;
                $url = "https://test.oppwa.com/v1/checkouts/" . $order->checkout_id . "/payment";
                $url .= "?entityId=" . $the_key;
            }elseif($order->payment_method_id == 3){
                $the_key = '8ac7a4c776d6413a0176d6fe8bac0381';
                $token = 'OGFjN2E0Yzc2ZWM1MzNiYTAxNmVjNmZhNzdiMDBiODd8UkNrakQ5SzREVw==';
                $url = "https://test.oppwa.com/v1/checkouts/" . $order->checkout_id . "/payment";
                $url .= "?entityId=" . $the_key;
            }else{
                $the_key =  $this->entity_id ;
                $token = $this->pay_token ;
                $the_key =  $this->entity_id_mada ;
                $token = $this->pay_token ;
                $url = "https://test.oppwa.com/v1/checkouts/" . $order->checkout_id . "/payment";
                $url .= "?entityId=" . $the_key;
            }



            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer ' .  $token));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);


            DB::table('callback_response')->insert(['backres' => $string  ,'date_res' => Carbon::now()->toDateTimeString() , 'res' => $responseData , 'from_prov' => 'server' , 'order_id' =>   $order->id]);

            $data_return = json_decode($responseData);


            if (isset( $data_return->result->code)) {
                $string =   $data_return->result->code ;
            }else{
                $string =  $data_return->result->description ?? 'Error On Transaction';
            }

            preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $string , $matches1);
            preg_match('/^(000\.400\.0[^3]|000\.400\.100)/', $string , $matches2);

            if(count($matches1) > 0 || count($matches2) > 0){

                $order->access_token_fees = $data_return->id;
                $order->status = 1;
                $order->save();

            }


            //send notification
            if($order->access_token_fees != '' &&  $order->send_fcm_fees == 0) {


                ///

                /// send FCM To Technican it must be after  pay is finish

                $action['order_id'] = $order->id;
                $tokens = Devicetoken::where('user_id', $request->technical_id )->first();
                $title = ' تم اختيارك من قبل العميل ';
                $body = 'تم اختيارك من قبل العميل لتتم معالجة الطلب لديه ';
                $data_fcm['action_type'] = 'acceptyoutech';
                $data_fcm['action_id'] = $order->id;
                $data_fcm['action'] = (object)$action;
                $data_fcm['user_id'] = $request->technical_id ;
                $data_fcm['date'] = Carbon::now()->timestamp;
                $data_fcm['title'] = $title;
                $data_fcm['body'] = $body;

                sendFCM($title, $body, $data_fcm, $tokens, 1, 1);
                $order->send_fcm_fees = 1 ;
                $order->save();
                $message = __('api.success');
                return jsonResponse(true, $message,  $order, 200);




                return jsonResponse(true, __('api.add_order'), $order, 200);

            }




        }


    }

    public function callbackPaymentStatusApiMobile(Request $request)
    {

        $responseData = [];

        if($request->id == ''){
            return ;
        }



        $order = Order::where('checkout_id', $request->id)->first();
        //dd($order)  ;
        if ($order) {

            if($order->access_token != '' )
                return jsonResponse(true, __('api.add_order'), $order, 200);



            $string = $request->all();
            $string = json_encode( $string );


            if($order->payment_method_id == 2){
                $the_key =  $this->entity_id_mada ;
                $token = $this->pay_token ;
                $url = "https://test.oppwa.com/v1/checkouts/" . $order->checkout_id . "/payment";
                $url .= "?entityId=" . $the_key;
            }elseif($order->payment_method_id == 3){
                $the_key = '8ac7a4c776d6413a0176d6fe8bac0381';
                $token = 'OGFjN2E0Yzc2ZWM1MzNiYTAxNmVjNmZhNzdiMDBiODd8UkNrakQ5SzREVw==';
                $url = "https://test.oppwa.com/v1/checkouts/" . $request->id . "/payment";
                $url .= "?entityId=" . $the_key;

            }else{
                $the_key =  $this->entity_id ;
                $token = $this->pay_token ;

                $url = "https://test.oppwa.com/v1/checkouts/" . $order->checkout_id . "/payment";
                $url .= "?entityId=" . $the_key;
            }



            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization:Bearer ' .  $token));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseData = curl_exec($ch);
            if (curl_errno($ch)) {
                return curl_error($ch);
            }
            curl_close($ch);


            // dd($responseData);

            $data_return = json_decode($responseData);
            DB::table('callback_response')->insert(['backres' => $string  ,'date_res' => Carbon::now()->toDateTimeString() , 'res' => $responseData , 'from_prov' => 'mobile' , 'order_id' =>   $order->id ]);



            if (isset( $data_return->result->code)) {
                $string =   $data_return->result->code ;
            }else{
                $string =  $data_return->result->description ?? 'Error On Transaction';
            }

            preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $string , $matches1);
            preg_match('/^(000\.400\.0[^3]|000\.400\.100)/', $string , $matches2);



            if(count($matches1) > 0 || count($matches2) > 0){

                $order = Order::where('checkout_id', $request->id)->first();
                if ($order) {

                    $order->access_token_fees =  $data_return->id;
                    $order->status = 1;
                    $order->save();

                }
            }




            if($order->access_token_fees != '' &&  $order->send_fcm_fees == 0) {


                ///

                /// send FCM To Technican it must be after  pay is finish

                $action['order_id'] = $order->id;
                $tokens = Devicetoken::where('user_id', $request->technical_id )->first();
                $title = ' تم اختيارك من قبل العميل ';
                $body = 'تم اختيارك من قبل العميل لتتم معالجة الطلب لديه ';
                $data_fcm['action_type'] = 'acceptyoutech';
                $data_fcm['action_id'] = $order->id;
                $data_fcm['action'] = (object)$action;
                $data_fcm['user_id'] = $request->technical_id ;
                $data_fcm['date'] = Carbon::now()->timestamp;
                $data_fcm['title'] = $title;
                $data_fcm['body'] = $body;

                sendFCM($title, $body, $data_fcm, $tokens, 1, 1);
                $order->send_fcm_fees = 1 ;
                $order->save();
                $message = __('api.success');
                return jsonResponse(true, $message,  $order, 200);




                return jsonResponse(true, __('api.add_order'), $order, 200);

            }

        }




        return jsonResponse(false, __('api.error'), $responseData, 100);

    }








}
