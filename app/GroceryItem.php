<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroceryItem extends Model
{
    //
     protected $fillable = [
        'name', 'user_id','description', 'image', 'fake_price','sell_price','category_id','shop_id','subcategory_id','status',
        'brand','weight','stoke',
    ];

    protected $table = 'grocery_item';

    public function category()
    {
        return $this->hasOne('App\GroceryCategory', 'id', 'category_id');
    }

    public function subcategory()
    {
        return $this->hasOne('App\GrocerySubCategory', 'id', 'subcategory_id');
    }

    protected $appends = [ 'imagePath','rate','totalReview'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }


    public function getRateAttribute()
    {       
        $review =  GroceryReview::where('item_id', $this->attributes['id'])->get(['rate']);
        if(count($review)>0){
            $totalRate = 0;
            foreach ($review as $r) {
                $totalRate=$totalRate+$r->rate;
            }
            return round( $totalRate / count($review), 1);
        }else{
            return 0;
        } 
    }
    public function getTotalReviewAttribute()
    {               
        $review =  GroceryReview::where('item_id', $this->attributes['id'])->get(['rate']);
        if(count($review)>0){
            return count($review);
        }else{
            return 0;
        } 
    }

}
