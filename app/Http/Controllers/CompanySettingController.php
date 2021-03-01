<?php

namespace App\Http\Controllers;

use App\CompanySetting;
use App\PaymentSetting;
use App\Setting;
use Redirect;
use App\Currency;
use App\NotificationTemplate;
use App\Mail\TestMail;
use App\Language;
use App\PointSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $companySetting = CompanySetting::findOrFail(1);
        $paymentSetting = PaymentSetting::findOrFail(1);
        $setting = Setting::findOrFail(1);
        $currency = Currency::get();
        $language = Language::get();
        
       
        return view('mainAdmin.setting.settings',['companyData'=>$companySetting,'language'=>$language,'paymentData'=>$paymentSetting,'setting'=>$setting,'currency'=>$currency]);
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
     * @param  \App\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function show(CompanySetting $companySetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanySetting $companySetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required_if:stripe,1',
            'address' => 'required_if:stripe,1',
            'phone' => 'required_if:paypal,1',
            'email' => 'required_if:paypal,1',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/upload/');
            $image->move($destinationPath, $name);
            $data['logo'] = $name;
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = uniqid() . '.' . $favicon->getClientOriginalExtension();
            $faviconPath = public_path('images/upload/');
            $favicon->move($faviconPath, $faviconName);
            $data['favicon'] = $faviconName;
        }

        CompanySetting::findOrFail(1)->update($data);
        return redirect('OwnerSetting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompanySetting  $companySetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanySetting $companySetting)
    {
        //
    }
    public function savePaymentSetting(Request $request){

        $request->validate([
            'stripePublicKey' => 'required_if:stripe,1',
            'stripeSecretKey' => 'required_if:stripe,1',
            'paypalSendbox' => 'required_if:paypal,1',
            'paypalProduction' => 'required_if:paypal,1',
            'razorPublishKey' => 'required_if:razor,1',
            'razorSecretKey' => 'required_if:razor,1',
            'paytab_secret_key' => 'required_if:paytabs,1',
            'paytab_email' => 'required_if:paytabs,1',
        ]);
        $data = $request->all();
        if(isset($request->cod)){    $data['cod'] = 1;    }
        else{  $data['cod'] = 0;  }

        if(isset($request->razor)){    $data['razor'] = 1;    }
        else{  $data['razor'] = 0;  }

        if(isset($request->stripe)){    $data['stripe'] = 1;    }
        else{  $data['stripe'] = 0;  }

        if(isset($request->paypal)){    $data['paypal'] = 1;    }
        else{  $data['paypal'] = 0;  }
        if(isset($request->paytabs)){    $data['paytabs'] = 1;    }
        else{  $data['paytabs'] = 0;  }

        PaymentSetting::findOrFail(1)->update($data);
        return redirect('OwnerSetting');
    }
    public function saveWebNotificationSettings(Request $request)
    {
        $request->validate([
            'web_onesignal_app_id' => 'required_if:web_notification,1',
            'web_onesignal_api_key' => 'required_if:web_notification,1',
            'web_onesignal_auth_key' => 'required_if:web_notification,1',
        ]);
        $data1 = $request->all();
        if (isset($request->web_notification)) {
            $data1['web_notification'] = 1;
        } else {
            $data1['web_notification'] = 0;
        }
        Setting::findOrFail(1)->update($data1);
        $data['APP_ID_WEB'] = $request->web_onesignal_app_id;
        $data['REST_API_KEY_WEB'] = $request->web_onesignal_api_key;
        $data['USER_AUTH_KEY_WEB'] = $request->web_onesignal_auth_key;

        $envFile = app()->environmentFilePath();
        if ($envFile) {
            $str = file_get_contents($envFile);
            if (count($data) > 0) {
                foreach ($data as $envKey => $envValue) {
                    $str .= "\n";
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
                }
            }
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)) {
                return false;
            } else {
                return redirect('OwnerSetting');
            }
        }
        return redirect('OwnerSetting');
    }

    public function saveNotificationSettings(Request $request){
        $request->validate([
            'onesignal_app_id' => 'required_if:push_notification,1',
            'onesignal_project_number' => 'required_if:push_notification,1',
            'onesignal_api_key' => 'required_if:push_notification,1',
            'onesignal_auth_key' => 'required_if:push_notification,1',
        ]);

        $data1 = $request->all();
        if(isset($request->push_notification)){
            $data1['push_notification'] = 1;
        }
        else{
            $data1['push_notification'] = 0;
        }
        Setting::findOrFail(1)->update($data1);

        $data['APP_ID']=$request->onesignal_app_id;
        $data['REST_API_KEY']=$request->onesignal_api_key;
        $data['USER_AUTH_KEY']=$request->onesignal_auth_key;
        $data['PROJECT_NUMBER']=$request->onesignal_project_number;

        $envFile = app()->environmentFilePath();
        if($envFile){
            $str = file_get_contents($envFile);
            if (count($data) > 0) {
                foreach ($data as $envKey => $envValue) {
                    $str .= "\n"; // In case the searched variable is in the last line without \n
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    // If key does not exist, add it
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
            }
            }
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)){ return false;  }
            else{   return redirect('OwnerSetting');   }
        }
        return redirect('OwnerSetting');
    }
    public function saveMailSettings(Request $request){
        $request->validate([
            'mail_host' => 'bail|required_if:mail_notification,1',
            'mail_port' => 'bail|required_if:mail_notification,1',
            'mail_username' => 'bail|required_if:mail_notification,1',
            'mail_password' => 'bail|required_if:mail_notification,1',
            'sender_email' => 'bail|email|required_if:mail_notification,1',
        ]);
        $data1 = $request->all();
        if(isset($request->mail_notification)){  $data1['mail_notification'] = 1; }
        else{  $data1['mail_notification'] = 0; }
        Setting::findOrFail(1)->update($data1);

        $data['MAIL_HOST']=$request->mail_host;
        $data['MAIL_PORT']=$request->mail_port;
        $data['MAIL_USERNAME']=$request->mail_username;
        $data['MAIL_PASSWORD']=$request->mail_password;
        $data['MAIL_FROM_ADDRESS']=$request->sender_email;

        $envFile = app()->environmentFilePath();
        if($envFile){
            $str = file_get_contents($envFile);
            if (count($data) > 0) {
                foreach ($data as $envKey => $envValue) {
                    $str .= "\n"; // In case the searched variable is in the last line without \n
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    // If key does not exist, add it
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
            }
            }
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)){ return false;  }
            else{   return redirect('OwnerSetting');   }
        }
    }

    public function savePointSettings(Request $request){
        $request->validate([
            'point_per_order' => 'required_if:enable_point,1',
            'value_per_point' => 'required_if:enable_point,1',
            'max_order_for_point' => 'required_if:enable_point,1',
            'min_cart_value_for_point' => 'required_if:enable_point,1',
            'max_redeem_amount' => 'required_if:enable_point,1',
        ]);

        $data = $request->all();
        if(isset($request->enable_point)){ $data['enable_point'] = 1; }
        else{ $data['enable_point'] = 0; }
        PointSetting::findOrFail(1)->update($data);
        return redirect('OwnerSetting');
    }

    public function saveSMSSettings(Request $request){
        $request->validate([
            'twilio_account_id' => 'required_if:sms_twilio,1',
            'twilio_auth_token' => 'required_if:sms_twilio,1',
            'twilio_phone_number' => 'required_if:sms_twilio,1',
        ]);

        $data = $request->all();
        if(isset($request->sms_twilio)){ $data['sms_twilio'] = 1; }
        else{ $data['sms_twilio'] = 0; }
        Setting::findOrFail(1)->update($data);
        return redirect('OwnerSetting');
    }

    public function saveSettings(Request $request){
        $request->validate([
            'currency' =>'bail|required',
            'request_duration' =>'bail|required',
            'sell_product' =>'bail|required',
            // 'default_food_order_status' =>'bail|required',
            'default_grocery_order_status' =>'bail|required',
        ]);

        $data = $request->all();
        Setting::findOrFail(1)->update($data);
        return redirect('OwnerSetting');
    }

    public function saveMapSettings(Request $request){
        $request->validate([
            'map_key' =>'bail|required',
        ]);
        $data = $request->all();
        Setting::findOrFail(1)->update($data);
        return redirect('OwnerSetting');
    }

    public function saveCommissionSettings(Request $request){
        $data = $request->all();
        Setting::findOrFail(1)->update($data);
        return redirect('OwnerSetting');
    }

    public function keySetting(){
        $data = PaymentSetting::findOrFail(1);
        $key = Setting::where('id',1)->first(['push_notification','request_duration','sell_product','onesignal_app_id','onesignal_project_number','currency','map_key']);
        $key['currency_symbol'] =  Currency::where('code',$key->currency)->first()->symbol;
        $setting = array_merge($data->toArray(), $key->toArray());
        return response()->json(['msg' => null, 'data' => $setting,'success'=>true], 200);
    }

    public function saveVerificationSettings(Request $request){
        $data = $request->all();
        if(isset($request->user_verify)){ $data['user_verify'] = 1; }
        else{ $data['user_verify'] = 0; }
        if(isset($request->phone_verify)){ $data['phone_verify'] = 1; }
        else{ $data['phone_verify'] = 0; }
        if(isset($request->email_verify)){ $data['email_verify'] = 1; }
        else{ $data['email_verify'] = 0; }
        Setting::findOrFail(1)->update($data);
        return redirect('OwnerSetting');
    }

}
