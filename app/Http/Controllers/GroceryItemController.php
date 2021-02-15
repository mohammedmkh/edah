<?php

namespace App\Http\Controllers;

use App\GroceryItem;
use App\GroceryCategory;
use App\GrocerySubCategory;
use App\Setting;
use App\GroceryOrderChild;
use App\Currency;
use App\GroceryShop;
use Auth;
use Illuminate\Http\Request;

class GroceryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $category = GroceryCategory::orderBy('id', 'DESC')->get();
        // $subcategory = GrocerySubCategory::orderBy('id', 'DESC')->get();
        $currency_code = Setting::where('id',1)->first()->currency;
        $currency = Currency::where('code',$currency_code)->first()->symbol;
        $item = GroceryItem::with(['category'])->where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->paginate(7);
        return view('admin.GroceryItem.viewGroceryItem',['items'=>$item,'currency'=>$currency]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category = GroceryCategory::orderBy('id', 'DESC')->get();
        $subcategory = GrocerySubCategory::where('owner_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
        $shop = GroceryShop::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
          return view('admin.GroceryItem.addGroceryItem',['shop'=>$shop,'category'=>$category,'subcategory'=>$subcategory]);
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
            'name' => 'bail|required',
            'fake_price' => 'bail|required',
            'sell_price' => 'bail|required',
            'description' => 'bail|required',
            'category_id' => 'bail|required',
            'subcategory_id' => 'bail|required',
            'shop_id' => 'bail|required',
            'status' => 'bail|required',
            'image' => 'bail|required',
            'stoke' => 'bail|required',
            'brand' => 'bail|required',
            'weight' => 'bail|required',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        $data = GroceryItem::create($data);
        return redirect('GroceryItem');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroceryItem  $groceryItem
     * @return \Illuminate\Http\Response
     */
    public function show(GroceryItem $groceryItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroceryItem  $groceryItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $shop = GroceryShop::where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
        $item = GroceryItem::with(['category'])->find($id);
        $category = GroceryShop::find($item->shop_id)->category_id; 
        $category = GroceryCategory::whereIn('id',explode(",",$category))->get();
        $subcategory = GrocerySubCategory::where('category_id',$item->category_id)->orderBy('id', 'DESC')->get();
        return view('admin.GroceryItem.editGroceryItem',['category'=>$category,'subcategory'=>$subcategory,'shop'=>$shop,'data'=>$item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroceryItem  $groceryItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'name' => 'bail|required',
            'fake_price' => 'bail|required',
            'sell_price' => 'bail|required',
            'description' => 'bail|required',
            'category_id' => 'bail|required',
            'subcategory_id' => 'bail|required',
            'shop_id' => 'bail|required',
            'status' => 'bail|required',
            'stoke' => 'bail|required',
            'brand' => 'bail|required',
            'weight' => 'bail|required',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/upload');
            $image->move($destinationPath, $name);
            $data['image'] = $name;
        }

        $data = GroceryItem::find($id)->update($data);
        return redirect('GroceryItem');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroceryItem  $groceryItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {        
            $delete = GroceryItem::find($id);
            $child = GroceryOrderChild::where('item_id',$id)->get();
            if(count($child)==0){
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
    
    public function viewGroceryItem(){
        $currency_code = Setting::where('id',1)->first()->currency;
        $currency = Currency::where('code',$currency_code)->first()->symbol;
        $item = GroceryItem::with(['category'])->orderBy('id', 'DESC')->paginate(7);
        return view('mainAdmin.item.viewGroceryItem',['items'=>$item,'currency'=>$currency]);
    }
}
