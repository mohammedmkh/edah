<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    //
    // use SoftDeletes;
    protected $fillable = [
        'owner_id', 'shop_id', 'image', 'title', 
    ];

    protected $table = 'gallery';

    protected $appends = [ 'imagePath','shopName'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }
    public function getShopNameAttribute()
    {
        // return Shop::findOrFail($this->attributes['shop_id'])->name;
    }
}
