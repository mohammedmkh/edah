<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class TechnicianEvaluation extends Model
{

    protected $fillable = [
      'technical_id','user_id','evaluation_no','evaluation_text','deleted_at', 'created_at', 'updated_at'];


    protected $table = 'technican_evaluations';






}
