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

    protected $hidden = ['translationLng'] ;

    protected $table = 'category';

    protected $appends = [ 'imagePath' , 'name' ,'description'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/'.$this->image;
    }



    public function getDescriptionAttribute(){

        $description = $this->translationLang()->first()->description ?? '';

        return $description ;
    }


    public function getNameAttribute(){

       $name = $this->translationLang()->first()->name ?? '';

       return $name ;
    }

    public function translationLang()
    {


            $language = App::getLocale();
            $language = Language::where('name' , $language)->first();
            $language = $language->id ?? 1 ;


           return $this->hasOne(CategoryLangs::class , 'category_id' , 'id')->where('lang_id', '=', $language);

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

    public function categoryLang()
    {

        return $this->hasMany(CategoryLangs::class,'category_id','id');
    }




}
