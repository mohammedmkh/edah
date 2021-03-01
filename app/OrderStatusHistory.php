<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatusHistory extends Model
{

    protected $fillable = [
      'order_id','order_status_id','deleted_at', 'created_at', 'updated_at'];


    protected $table = 'order_status_history';






}
