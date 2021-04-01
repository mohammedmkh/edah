<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Countries;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Countries::orderBy('id', 'DESC')->paginate(20);
        return view('admin.countries.viewItem',['items'=>$data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.countries.addItem');
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
            'name' => 'bail|required|unique:countries',
            'status' => 'bail|required',

        ]);
        $data = $request->all();


        Countries::create($data);


        return redirect(adminPath().'countries');

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
        $data = Countries::findOrFail($id);
        return view('admin.countries.editItem',['data'=>$data]);

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
            'name' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $data = $request->all();


        Countries::findOrFail($id)->update($data);



        return redirect(adminPath().'countries');

    }


    public function destroy($id)
    {
        //
        try {
            $delete = Countries::find($id);
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
