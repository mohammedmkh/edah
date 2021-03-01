<?php

namespace App\Http\Controllers;

use App\CompanySetting;
use App\Currency;
use App\PointSetting;
use App\Language;
use App\OwnerSetting;
use App\PaymentSetting;
use App\Setting;
use Auth;
use Illuminate\Http\Request;

class OwnerSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = OwnerSetting::where('user_id',Auth::user()->id)->first();
        $companySetting = CompanySetting::findOrFail(1);
        $paymentSetting = PaymentSetting::findOrFail(1);
        $setting = Setting::findOrFail(1);
      //  $currency = Currency::get();
        $language = Language::get();
      //  $point =PointSetting::find(1);
        
        // return view('mainAdmin.setting.settings', ['companyData' => $companySetting, 'language' => $language, 'paymentData' => $paymentSetting, 'setting' => $setting, 'currency' => $currency]);
        return view('admin.setting.setting',['data'=>$data,'companyData' => $companySetting, 'language' => $language, 'paymentData' => $paymentSetting, 'setting' => $setting]);
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
     * @param  \App\OwnerSetting  $ownerSetting
     * @return \Illuminate\Http\Response
     */
    public function show(OwnerSetting $ownerSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OwnerSetting  $ownerSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(OwnerSetting $ownerSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OwnerSetting  $ownerSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //dd('mm');
        $data = $request->all();
        
        if(isset($request->web_notification)){   $data['web_notification'] = 1; }
        else{ $data['web_notification'] = 0; }

        if(isset($request->play_sound)){   $data['play_sound'] = 1; }
        else{ $data['play_sound'] = 0; }
        
        if(isset($request->coupon)){   $data['coupon'] = 1; }
        else{ $data['coupon'] = 0; }

        OwnerSetting::findOrFail($id)->update($data);
        return redirect('OwnerSetting');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OwnerSetting  $ownerSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(OwnerSetting $ownerSetting)
    {
        //
    }
}
