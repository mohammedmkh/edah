<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;

class Scheduling extends Model
{
    //
     use SoftDeletes;


    protected $table = 'remind_me_later';
    protected $fillable = [
        'date' ,'time' ,'user_id' ,'category_id'
    ];





}
