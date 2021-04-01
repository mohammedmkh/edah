<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class UserEvaluation extends Model
{

    protected $fillable = [
      'evaluated_user_id','evaluator_user_id',
        'evaluation_no','evaluation_text','type','order_id'];


    protected $table = 'user_evaluations';






}
