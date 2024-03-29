<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Question extends Model
{
    //
    protected $fillable = ['id', 'created_at', 'updated_at', 'deleted_at'
    ];


    protected $table = 'questions';


    protected $appends = ['name'];


    public function getDescriptionAttribute()
    {

        $description = $this->translationLang()->first()->description ?? '';

        return $description;
    }


    public function getNameAttribute()
    {

        $name = $this->translationLang()->first()->name ?? '';

        return $name;
    }

    public function translationLang()
    {


        $language = App::getLocale();
        $language = Language::where('name', $language)->first();
        $language = $language->id ?? 1;


        return $this->hasOne(QuestionLang::class, 'question_id', 'id')->where('lang_id', '=', $language);

    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
            $language = Language::where('name', $language)->first();
            $language = $language->id ?? 1;
        }
        // dd(  $language );


        return $this->hasMany(CategoryLangs::class)->where('lang_id', '=', $language)->first();
    }




    public function questionLang()
    {

        return $this->hasMany(CategoryLangs::class, 'question_id', 'id');
    }


}



