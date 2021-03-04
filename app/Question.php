<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
class Question extends Model
{
    //
    protected $fillable = [
         'q_name','q_type'
    ];


    protected $table = 'questions';










}
