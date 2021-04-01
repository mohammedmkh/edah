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
     * Show the form for editing the specified resource.
     *
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
        return redirect(adminPath().'OwnerSetting');
    }

}
