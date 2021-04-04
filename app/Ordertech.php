<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Ordertech extends Model
{

    protected $fillable = [
      'order_id', 'tech_id' ,'status' ,'distance'];


    protected $table = 'order_techs';


    public function technician()
    {

        return $this->belongsTo(User::class, 'tech_id', 'id');
    }



}
