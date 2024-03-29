<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    protected $fillable = [
      'user_id','technical_id','category_id', 'status','is_immediately'
        ,'time','price','note' ,'deleted_at', 'created_at', 'updated_at' , 'distance','lat','lang','profit_ratio','is_posting'];

    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at' ,'statusname'];

    protected $table = 'orders';

    protected  $appends= [ 'is_evaluated_user' , 'additional_price' , 'statusname_text' ];

    public function getIsEvaluatedUserAttribute(){
        $is_ev = UserEvaluation::where('order_id' , $this->id)->where('type' ,2)->first();
        if($is_ev){
            return 1 ;
        }
        return 0 ;
    }

    public function getAdditionalPriceAttribute(){
        $sum_additional = SupplierPriceOffer::where('order_id' , $this->id)->where('status' ,2)->sum('price');

        return $sum_additional  ;
    }


    public function getStatusnameTextAttribute(){

        return $this->statusname->status_name  ?? 'Not Ready'  ;
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

    public function additionals()
    {

        return $this->hasMany(SupplierPriceOffer::class, 'order_id', 'id')->where('status' , 2 );
    }


}
