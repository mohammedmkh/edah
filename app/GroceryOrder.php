<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryOrder extends Model
{
    //
    protected $fillable = [
        'order_no', 'owner_id','shop_id','customer_id','deliveryBoy_id','payment','discount','payment_type',
        'order_status','payment_status','payment_token','review_status','delivery_charge','items','delivery_type',
        'coupon_id','coupon_price','time','date','order_otp','reject_by','address_id',
    ];

    protected $table = 'orders';



    public function customer() 
    {
        return $this->hasOne('App\User', 'id', 'customer_id');
    }

    public function deliveryGuy()
    {
        return $this->hasOne('App\User', 'id', 'deliveryBoy_id');
    }
    public function orderItem()
    {
        return $this->hasMany('App\GroceryOrderChild', 'order_id', 'id');
    }

    protected $appends = ['orderItems'];

    public function getOrderItemsAttribute()
    {
         return GroceryOrderChild::where('order_id',$this->attributes)->get();
       
    }


}
