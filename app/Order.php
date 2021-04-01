<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    protected $fillable = [
      'user_id','technical_id','category_id', 'status','is_immediately'
        ,'time','price','deleted_at', 'created_at', 'updated_at' , 'distance'];

    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];

    protected $table = 'orders';

    protected  $appends= [ 'is_evaluated_user'  ];

    public function getIsEvaluatedUserAttribute(){
        $is_ev = UserEvaluation::where('order_id' , $this->id)->where('type' ,2)->first();
        if($is_ev){
            return 1 ;
        }
        return 0 ;
    }

    public function statusname(){
        return $this->belongsTo(OrderStatus::class, 'status', 'id');
    }

    public function userOrder()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function categoryOrder()
    {

        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function technician()
    {

        return $this->belongsTo(User::class, 'technical_id', 'id');
    }




}
