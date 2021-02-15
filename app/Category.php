<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class Category extends Model
{
    //
    protected $fillable = [
         'status', 'image', 'sort'
    ];

    protected $table = 'category';

    protected $appends = [ 'imagePath'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }


    public function translation($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
            $language = Language::where('name' , $language)->first();
            $language = $language->id ?? 1 ;
        }
       // dd(  $language );
        return $this->hasMany(CategoryLangs::class)->where('lang_id', '=', $language)->first();
    }


    public function categoryName()
    {
        return $this->hasOne('App\Category', 'id', 'parent');
    }





}
