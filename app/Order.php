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


    public function userOrder()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function categoryOrder()
    {

        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


}
