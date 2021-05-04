<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class QuestionLang extends Model
{
    //
    protected $fillable = [
         'question_id','lang_id','name','created_at','updated_at','deleted_at'
    ];


    protected $table = 'question_langs';










}
