<?php

namespace App\Http\Controllers;

use App\Gallery;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Gallery::where('owner_id',Auth::user()->id)->orderBy('id', 'DESC')->get();

       
        return view('admin.gallery.viewGallery',['gallery'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $shop = Shop::where('user_id',Auth::user()->id)->get();
        // return view('admin.gallery.addImage',['shops'=>$shop]);
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
            'title' => 'bail|required',
            'shop_id' => 'bail|required',
            'image' => 'bail|required',
        ]);
        $data = $request->all();
        $data['owner_id'] = Auth::user()->id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }
        Gallery::create($data);
        return redirect('Gallery');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
      
        // $data = Gallery::findOrFail($id);
        // $shop = Shop::where('user_id',Auth::user()->id)->get();
      
        // return view('admin.gallery.editGallery',['data'=>$data,'shops'=>$shop]);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // $request->validate([
        //     'title' => 'bail|required',
        //     'shop_id' => 'bail|required',
        // ]);
        // $data = $request->all();
     
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $name = time() . '.' . $image->getClientOriginalExtension();
        //     $destinationPath = public_path('/images/upload');
        //     $image->move($destinationPath, $name);
        //     $data['image'] = $name;
        // }
        // Gallery::findOrFail($id)->update($data);
        // return redirect('Gallery');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // try {
            // $delete = Gallery::findOrFail($id);
            // $delete->delete();
            // return 'true';
        // } catch (\Exception $e) {
        //     return response('Data is Connected with other Data', 400);
        // }
    }
}
