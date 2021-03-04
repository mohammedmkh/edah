<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class UserQuestionAnswer extends Model
{
    //
    protected $fillable = [
         'question_id','user_id','user_answer_id','user_answer'
    ];


    protected $table = 'user_question_answers';

    public $timestamps = false;










}
