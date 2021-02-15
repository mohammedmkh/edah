<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GrocerySubCategory extends Model
{
    //
    protected $fillable = [
        'name','category_id','owner_id', 'status', 'image','shop_id',
    ];

    protected $table = 'grocery_sub_category';

    protected $appends = [ 'imagePath','categoryName'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }

    public function getCategoryNameAttribute()
    {
        return Category::find($this->attributes['category_id'])->name;
    }
}
