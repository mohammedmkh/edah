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

       
        return redirect('countries');
       
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
        $data = Banner::findOrFail($id);
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
            'title' => 'bail|required|unique:countries,title,' . $id . ',id',
            'status' => 'bail|required',
        ]);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        Banner::findOrFail($id)->update($data);
        
        return redirect('Banner');

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
