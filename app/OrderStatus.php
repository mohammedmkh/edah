<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{

    protected $fillable = [
      'status_name','deleted_at', 'created_at', 'updated_at'];


    protected $table = 'order_status';






}
