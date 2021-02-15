<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    
        $request->validate([
            'lang_name' => 'bail|required|unique:language,name',                       
            'file' => 'bail|required',  
            'icon' => 'bail|required',                       
        ]); 
       
        $data['name'] = $request->lang_name;
        $data['status'] = 1;
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = $request->lang_name. '.' . $image->getClientOriginalExtension();
            $destinationPath =resource_path('/lang');                 
            $image->move($destinationPath, $name);              
            $data['file'] = $name;          
        }    
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $iconName = time() . '.' . $icon->getClientOriginalExtension();
            $iconPath = public_path('/images/upload');
            $icon->move($iconPath, $iconName);
            $data['icon'] = $iconName;
        }               
        $a = Language::create($data);    
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show(Language $language)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Language $language)
    {
        //
    }

    /**
     * Remove the specified resource from storage.  
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $language)
    {
        //
    }

    public function changelangStatus(Request $request){        
        Language::findOrFail($request->id)->update(['status'=>$request->status]);
        $data = Language::findOrFail($request->id);
        return response()->json(['success'=>true,'msg'=>null ,'data' =>$data ], 200);        
    }
}
