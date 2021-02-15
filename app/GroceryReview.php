<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryReview extends Model
{
    //
    protected $fillable = [
        'customer_id', 'order_id','shop_id', 'message','rate','deliveryBoy_id','item_id',
    ];
    protected $table = 'grocery_review';

    protected $appends = ['imagePath','customer','shopName'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }

    public function getCustomerAttribute()
    {
        return User::find($this->attributes['customer_id']);
    }
    public function getShopNameAttribute()
    {
        // dd($this->attributes['shop_id']);
        if($this->attributes['shop_id']!=null){
            return GroceryShop::find($this->attributes['shop_id'])->name;
        }
        else{
            return null;
        }
        
    }

}
