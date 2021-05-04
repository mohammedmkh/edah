<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class QuestionsOption extends Model
{
    //
    protected $fillable = ['question_id', 'created_at', 'updated_at', 'deleted_at'
    ];


    protected $table = 'questions_options';


    protected $appends = ['name'];
    public $timestamps = false;


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


        return $this->hasOne(QuestionOptionLang::class, 'questions_options_id', 'id')->where('lang_id', '=', $language);

    }

    public function translation($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
            $language = Language::where('name', $language)->first();
            $language = $language->id ?? 1;
        }
        // dd(  $language );


        return $this->hasMany(QuestionOptionLang::class)->where('lang_id', '=', $language)->first();
    }




    public function questionLang()
    {

        return $this->hasMany(QuestionOptionLang::class, 'questions_options_id', 'id');
    }


}



