<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryLangs;
use App\Cities;
use App\GroceryShop;
use App\GroceryItem;
use Illuminate\Http\Request;
use \Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Category::where('parent',0)->orderBy('id', 'DESC')->paginate(7);
       // dd('CategoryCategory');

        return view('mainAdmin.GroceryCategory.viewGroceryCategory',['categories'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


        return view('mainAdmin.GroceryCategory.addGroceryCategory');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(),
            [
                'name.*' => 'bail|required|unique:category_langs,name',
                'status' => 'bail|required' ,
            ]
        );
        $validator->validate();



       $data = $request->all();


        if ($request->hasFile('image')) {

            $validator = Validator::make($request->all(),
                [
                    'image' => 'max:2000',
                ]
            );
            $validator->validate();

            $image = $request->file('image');
            $image =  uploadFile($image );
            $data['image'] =  $image;


        }



        $category_no_langs = Category::create($data);
        $this->addUpdateTranslation( $category_no_langs , $data );

       // dd($category_no_langs);
        return redirect('GroceryCategory');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroceryCategory  $groceryCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroceryCategory  $groceryCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Category::findOrFail($id);
        return view('mainAdmin.GroceryCategory.editGroceryCategory',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroceryCategory  $groceryCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($id);
        $request->validate([
            'name.*' => 'bail|required|unique:category_langs,name,' . $id . ',category_id',
            'status' => 'bail|required',
        ]);
        $data = $request->all();
        $category = Category::findOrFail($id);
        if ($request->hasFile('image')) {

            $validator = Validator::make($request->all(),
                [
                    'image' => 'max:2000',
                ]
            );
            $validator->validate();

            $image = $request->file('image');
            $image =  uploadFile($image );
            $data['image'] =  $image;



            // remove old image

            removeFile( $category['image']);


        }
       // dd('unlink ooo' , $category);

        $category_no_langs = $category->update($data);
        $category_no_langs = Category::find($id);
        $this->addUpdateTranslation( $category_no_langs , $data );
        return redirect('GroceryCategory');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroceryCategory  $groceryCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            $item = Category::where('parent',$id)->get();
            if(count($item)==0){
                $delete = Category::find($id);
                $delete->delete();
                return 'true';
            }     
            else{
                return response('Data is Connected with other Data', 400);
            }                               
        } catch (\Exception $e) {
            return response('Data is Connected with other Data', 400);
        }
    }



    public function addUpdateTranslation($category , $data){

        //dd( $data);
        foreach ($data['name'] as  $key => $value){
            // check if data is exist or  not
            $category_lang = CategoryLangs::where('lang_id' , $key )->where('category_id' , $category->id)->first();
            if(!$category_lang)  $category_lang = new CategoryLangs ;
            $category_lang->name = $value ;
            $category_lang->lang_id = $key ;
            $category_lang->category_id =  $category->id ;
            $category_lang->save();

        }

        foreach ($data['description'] as  $key => $value){
            // check if data is exist or  not
            $category_lang = CategoryLangs::where('lang_id' , $key )->where('category_id' , $category->id)->first();
            if(!$category_lang)  $category_lang = new CategoryLangs ;
            $category_lang->description = $value ;
            $category_lang->lang_id = $key ;
            $category_lang->category_id =  $category->id ;
            $category_lang->save();

        }
    }
}
