<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Cities;
use App\Countries;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Cities::orderBy('id', 'DESC')->paginate(20);
        return view('admin.cities.viewItem',['cities'=>$data]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $countries = Countries::all();
        return view('admin.cities.addItem',['countries'=>$countries]);
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
            'name' => 'bail|required|unique:cities',

        ]);
        $data = $request->all();

        //dd( $request->all());
        $country = Countries::where('id' , $request->country_id)->first();


       $city =  Cities::create($data);

       $city->country_code = $country->code ;
       $city->save();
       // dd( $country ,    $city);
       
        return redirect(adminPath().'cities');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $countries = Countries::all();
        $data = Cities::findOrFail($id);
        return view('admin.cities.editItem',['data'=>$data ,'countries'=>  $countries] );
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'bail|required|unique:cities,name,' . $id . ',id',

        ]);
        $data = $request->all();

        $city = Cities::findOrFail($id);
        $city->update($data);
        $country = Countries::where('id' , $request->country_id)->first();
        $city->country_code = $country->code ;
        $city->save();
        return redirect(adminPath().'cities');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $delete = Cities::find($id);
            $delete->delete();
            return 'true';
           
        } catch (\Exception $e) {
            return response('Data is Connected with other Data', 400);
        }
    }
    
    public function bannerImage(){
        $data = Banner::orderBy('id', 'DESC')->get(); 
        return response()->json(['data' =>$data ,'success'=>true], 200);
    }
}
