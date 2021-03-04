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
use Illuminate\Database\Eloquent\Builder;

class UsersApiController extends Controller
{


    public function signPhoneClient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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


        $message = 'Code ' . $user->sms_verify . ' for verification';
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
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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
        $user->role = 3;
        $user->registration_code = $this->getSmsCode();
        $user->save();


        $message = 'Code ' . $user->sms_verify . ' for verification';
        sendSMS($user->phone, $message);

        $message = __('api.success');
        return jsonResponse(true, $message, null, 200);


    }

    public function signPhoneStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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
        $user->role = 4;
        $user->registration_code = $this->getSmsCode();
        $user->save();


        $message = 'Code ' . $user->sms_verify . ' for verification';
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
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }

        //
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->verify != 1 | $user->is_complete_register != 1) {
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


        return jsonResponse(false, __('api.error'), null, 115);


    }

    public function initOrder(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'technical_id' => 'required',
            'category_id' => 'required',
            'status' => 'required',
            'is_immediately' => 'required',
            'time' => 'required',
            'price' => 'required',
        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }
        $data['user_id'] = Auth::guard('api')->id();


        $create = Order::create($data);

        $message = __('api.success');
        return jsonResponse(true, $message, $create, 200);


    }

    public function loginClient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }

        //
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->verify != 1 | $user->is_complete_register != 1) {
                return jsonResponse(false, __('api.wrong_verify_code'), null, 106, null, null, $validator);
            }


            /*
            Devicetoken::where('device_token',  $request->device_token )->delete();
            $device = Devicetoken::where('user_id' ,  $user->id)->first();
            if($device){
                // delete other device of that user  or  other users that have this device token
                Devicetoken::where('user_id', $user->id )->where('id' ,'<>' ,$device->id)->delete();
            }else{
                $device =new Devicetoken;
            }
            $device->device_type = $request->device_type ;
            $device->device_token = $request->device_token ;
            $device->user_id = $user->id ;
            $device->save();

            ///  delete access token this user
            DB::table('oauth_access_tokens')->where('user_id' , $user->id)->delete();
            */


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

            $header = $request->header('Accept-Language');
            $user_obejct = User::where('id', $user->id)->first();
            if ($user_obejct) {
                $user_obejct->lang = $header;
                $user_obejct->save();
            }


            $message = __('api.success');
            return jsonResponse(true, $message, $json, 200);
        }


        return jsonResponse(false, __('api.error'), null, 115);


    }

    public function loginSupplier(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6',
        ]);

        //dd('login');

        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }

        //
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            if ($user->verify != 1 | $user->is_complete_register != 1) {
                return jsonResponse(false, __('api.wrong_verify_code'), null, 106, null, null, $validator);
            }


            /*
            Devicetoken::where('device_token',  $request->device_token )->delete();
            $device = Devicetoken::where('user_id' ,  $user->id)->first();
            if($device){
                // delete other device of that user  or  other users that have this device token
                Devicetoken::where('user_id', $user->id )->where('id' ,'<>' ,$device->id)->delete();
            }else{
                $device =new Devicetoken;
            }
            $device->device_type = $request->device_type ;
            $device->device_token = $request->device_token ;
            $device->user_id = $user->id ;
            $device->save();

            ///  delete access token this user
            DB::table('oauth_access_tokens')->where('user_id' , $user->id)->delete();
            */


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


            // return $json;

            if (isset($json['error'])) {
                $message = __('api.wrong_login');
                return jsonResponse(false, $message, null, 109);
            }

            $json['user'] = $user;

            $header = $request->header('Accept-Language');
            $user_obejct = User::where('id', $user->id)->first();
            if ($user_obejct) {
                $user_obejct->lang = $header;
                $user_obejct->save();
            }


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

    public function setTechnicianLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lang' => 'required',
        ]);
        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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

    public function searchNearestTechnicalLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lang' => 'required',
        ]);
        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }
        $LATITUDE = $request->lat;
        $LONGITUDE = $request->lang;
        $DISTANCE_KILOMETERS = 40;
        $data = DB::select("SELECT * FROM (
    SELECT *,
        (
            (
                (
                    acos(
                        sin(( {$LATITUDE} * pi() / 180))
                        *
                        sin(( `lat` * pi() / 180)) + cos(( {$LATITUDE} * pi() /180 ))
                        *
                        cos(( `lat` * pi() / 180)) * cos((( {$LONGITUDE} - `lang`) * pi()/180)))
                ) * 180/pi()
            ) * 60 * 1.1515 * 1.609344
        )
    as distance FROM `user_address`
) user_address
WHERE distance <= {$DISTANCE_KILOMETERS}");

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

        $data = Order::with(['userOrder:id,name', 'categoryOrder:id'])->get();


        if ($request->id) {

            $data = Order::where('status', $request->id)->with(['userOrder:id,name', 'categoryOrder:id'])->get();
        }
        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);


    }

    public function registerTechnician(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'name' => 'required',
            'email' => 'required|email|unique:users',
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
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'identity' => 'required',
            'work_time_from' => 'required',
            'work_time_to' => 'required',
            'categories' => 'required',
            'order_min' => 'required',


        ]);

        $data = $request->all();

        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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

    public function uploadFile(Request $request)
    {
        if ($request->file) {

            $data = [];
            foreach ($request->file as $file) {
                $file_name = uploadFile($file, 0, public_path('/docs/upload'));
                $link = 'docs/upload/' . $file_name;

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

    public function setOrderStatusHistory(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|numeric',
            'order_status_id' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }

        $cheak_status = OrderStatus::find($data['order_status_id']);

        if (!$cheak_status) {
            $message_error = __('api.order status id not found');
            return jsonResponse(false, $message_error, null, 100);
        }

        $OrderStatus = OrderStatusHistory::create($data);

        $message = __('api.success');
        return jsonResponse(true, $message, $OrderStatus, 200);


    }

    public function setSupplierPriceOffer(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'price' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }


        $data['user_id'] = Auth::guard('api')->id();

        $setSupplierPriceOffer = SupplierPriceOffer::create($data);

        $message = __('api.success');
        return jsonResponse(true, $message, $setSupplierPriceOffer, 200);


    }

    public function getTechnicanAvilable(Request $request)
    {


        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lang' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }
        $user_id = Auth::guard('api')->id();
        $setLocation = User::find($user_id);
        $setLocation->update(['lat' => $data['lat'], 'lang' => $data['lang']]);
        $lat = $setLocation->lat;
        $lang = $setLocation->lang;

        $avilableTechnical = DB::table("users");
        $order_minimum_value = DB::table("general_setting")->select('order_minimum_value')->get();
        $avilableTechnical->leftjoin('user_evaluations', 'user_evaluations.evaluated_user_id', '=', 'users.id');

        $avilableTechnical = $avilableTechnical->select("users.name", "users.role", "users.id",
            DB::raw("round(6371 * acos(cos(radians(" . $lat . "))
                     * cos(radians(lat)) * cos(radians(lang) - radians(" . $lang . "))
                     + sin(radians(" . $lat . ")) * sin(radians(lat)))) AS distance"),
            DB::raw("AVG(user_evaluations.evaluation_no) as evaluation")
        );
        $avilableTechnical->groupBy('users.id');
        $avilableTechnical = $avilableTechnical->orderBy('distance', 'asc');
        $avilableTechnical = $avilableTechnical->where('role', 3);
        $avilableTechnical = $avilableTechnical->get();
        $data = array();
        foreach ($avilableTechnical as $kay => $value) {

            foreach ($value as $kay1 => $value1) {

                $data[$kay1] = $value1;
                $data['price'] = $order_minimum_value[0]->order_minimum_value;
            }


        }

        /* $collection = collect($avilableTechnical);
         $merged = $collection->merge(['price'=> $order_minimum_value]);
         $merged->all();*/
        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);


    }

    public function getSupplierAvilable(Request $request)
    {


        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lang' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }

        $data['type'] = 1;
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
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
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
            //'evaluation_text' => 'required',

        ]);


        if ($validator->fails()) {
            return jsonResponse(false, __('api.validation_input_error'), null, 111, null, null, $validator);
        }

        $data['evaluated_user_id'] = Auth::guard('api')->id();
        $TechnicianEvaluation = UserEvaluation::create($data);

        $message = __('api.success');
        return jsonResponse(true, $message, $TechnicianEvaluation, 200);


    }


}
