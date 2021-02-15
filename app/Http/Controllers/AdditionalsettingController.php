<?php

namespace App\Http\Controllers;

use App\AdditionalSetting;
use App\Cities;
use App\CompanySetting;
use App\Currency;
use App\PointSetting;
use App\Language;
use App\OwnerSetting;
use App\PaymentSetting;
use App\Setting;
use Auth;
use Illuminate\Http\Request;

class AdditionalsettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = AdditionalSetting::orderBy('id', 'DESC')->paginate(20);
        return view('admin.additionalsettings.viewItem',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.additionalsettings.addItem');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'bail|required|unique:settings',

        ]);
        $data = $request->all();


        $AdditionalSetting =  AdditionalSetting::create($data);
        if(! $request->status ){
            $AdditionalSetting->status = 0 ;
        }
        $AdditionalSetting->save();

        return redirect('additionalsettings');
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
    public function edit($id)
    {

        $data = AdditionalSetting::findOrFail($id);
        return view('admin.additionalsettings.editItem',['data'=>$data ] );
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

        $data = $request->all();
        $Setting = AdditionalSetting::findOrFail($id);
        $Setting->update($data);
        if(! $request->status ){
            $Setting->status = 0 ;
        }
        $Setting->save();

        return redirect('additionalsettings');
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
