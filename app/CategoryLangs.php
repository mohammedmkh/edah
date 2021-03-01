<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use App;
class CategoryLangs extends Model
{

    protected $table = 'category_langs';

    public function category()
    {

        return $this->belongsTo(Category::class,'category_id','id');
    }





    public function translation($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
            $language = Language::where('name' , $language)->first();
            $language = $language->id ?? 1 ;
        }
        // dd(  $language );


        return $this->where('lang_id', '=', $language)->first();
    }




}
