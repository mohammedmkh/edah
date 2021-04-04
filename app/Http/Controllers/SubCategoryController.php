<?php

namespace App\Http\Controllers;

use App\CategoryLangs;
use App\GrocerySubCategory;
use App\Category;
use Auth;
use App\GroceryItem;
use App\GroceryShop;
use Illuminate\Http\Request;
use \Validator;
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::where('parent' ,'<>' , 0)->orderBy('id', 'DESC')->paginate(7);
        return view('admin.SubCategory.viewSubCategory',['categories'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('id', 'DESC')->get();
        return view('admin.SubCategory.addSubCategory',['category'=>$category]);
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
            'name.*' => 'bail|required|unique:category_langs,name',
            'status' => 'bail|required',
            'category_id' => 'bail|required',
        ]);

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

        $category_no_langs->parent = $request->category_id;
        $category_no_langs->save();
       // dd( $category_no_langs);
        $this->addUpdateTranslation( $category_no_langs , $data );

        return redirect(adminPath().'SubCategory');




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GrocerySubCategory  $grocerySubCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GrocerySubCategory  $grocerySubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Category::findOrFail($id);
        $category = Category::where('parent', 0)->get();

        return view('admin.SubCategory.editSubCategory',['category'=>$category,'data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GrocerySubCategory  $grocerySubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name.*' => 'bail|required|unique:category_langs,name,' . $id . ',category_id',
            'status' => 'bail|required',
            'category_id' => 'bail|required',
        ]);
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
        $category_no_langs = Category::findOrFail($id) ;
        $category_no_langs->update($data);
        $this->addUpdateTranslation( $category_no_langs , $data );
        return redirect(adminPath().'SubCategory');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GrocerySubCategory  $grocerySubCategory
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        //
        try {
            // todo check if any orders here
            $item = Category::where('id',$id)->get();
           // if(count($item)==0){
                $delete = Category::find($id);
                $delete->delete();
                return 'true';
           // }
         //   else{
                return response('Data is Connected with other Data', 400);
          // }
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