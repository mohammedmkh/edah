<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryShop extends Model
{
    //

    protected $fillable = [
        'name', 'description', 'location','category_id','image', 'address', 'latitude', 'longitude','phone','website','radius',
        'delivery_type', 'delivery_charge', 'status','user_id','open_time','close_time','cover_image',
    ];

    protected $table = 'grocery_shop';
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function locationData()
    {
        return $this->hasOne('App\Location', 'id', 'location');
    }

    protected $appends = [ 'imagePath','rate','totalReview'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }

    public function getRateAttribute()
    {
        $review =  GroceryReview::where('shop_id', $this->attributes['id'])->get(['rate']);
        if(count($review)>0){
            $totalRate = 0;
            foreach ($review as $r) {
                $totalRate=$totalRate+$r->rate;
            }
            return round($totalRate / count($review), 1);
        }else{
            return 0;
        } 
    }

    public function getTotalReviewAttribute()
    {
        $review =  GroceryReview::where('shop_id', $this->attributes['id'])->get(['rate']);
        if(count($review)>0){
            return count($review);
        }else{
            return 0;
        } 
    }

}
