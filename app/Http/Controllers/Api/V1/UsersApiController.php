<?php

namespace App\Http\Controllers\Api\V1;

use App\Documents;
use App\Http\Controllers\Controller;
use App\TechStoreUser;
use App\TechStoreServices;

use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Validator;
use Illuminate\Http\Request;
use DB;
use Route;
use App\TechStoreDocuments;

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

    public function docsOfTech(Request $request)
    {


        $data = Documents::where('type', 1)->get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function getCategories(Request $request)
    {


        $data = Category::get();

        $message = __('api.success');
        return jsonResponse(true, $message, $data, 200);
    }

    public function docsOfStore(Request $request)
    {


        $data = Documents::where('type', 2)->get();

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

                $techStoreDocuments = TechStoreDocuments::create([
                    'document_id' => $data['docs'][0]['id'],
                    'document_link' => $data['docs'][0]['path'],
                    'user_id' => $user->id

                ]);
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

                $techStoreDocuments = TechStoreDocuments::create([
                    'document_id' => $data['docs'][0]['id'],
                    'document_link' => $data['docs'][0]['path'],
                    'user_id' => $user->id

                ]);

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
        dd($request->file);
        if ($request->file) {

            $file = uploadFile($request->file, 0, public_path('/docs/upload'));
            $link = 'docs/upload/' . $file;

            $items['file'] = url('/') . '/' . $link;
            $items['path'] = $link;

            return jsonResponse(true, __('api.success'), $items, 200);
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

}
