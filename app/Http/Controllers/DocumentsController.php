<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Cities;
use App\Countries;
use App\Documents;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Documents::orderBy('id', 'DESC')->paginate(20);
        return view('admin.documents.viewItem',['cities'=>$data]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       // $countries = Countries::all();
        return view('admin.documents.addItem');
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

       // dd($request->all());
        $request->validate([
            'document_description' => 'bail|required',

        ]);
        $data = $request->all();

        //dd( $request->all());


        $Documents =  Documents::create($data);
        if(! $request->is_required ){
            $Documents->is_required = 0 ;
        }
        $Documents->save();
       
        return redirect('documents');
       
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
        $data = Documents::findOrFail($id);
        return view('admin.documents.editItem',['data'=>$data ] );
        
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

        $data = $request->all();

        $Documents = Documents::findOrFail($id);
        if(! $request->is_required ){
            $Documents->is_required = 0 ;
        }
        $Documents->update($data);
        $Documents->save();
        return redirect('documents');

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
            $delete = Documents::find($id);
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
