<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    protected $fillable = [
      'user_id','technical_id','category_id', 'status','is_immediately','time','price','deleted_at', 'created_at', 'updated_at'];

    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];

    protected $table = 'orders';






}
