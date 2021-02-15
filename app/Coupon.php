<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    //
    // use SoftDeletes;
    protected $fillable = [
        'name', 'code', 'total_apply', 'description', 'type', 'discount', 'max_use', 'start_date', 'end_date','status','use_count','use_for','image',
    ];

    protected $table = 'coupon';

    protected $appends = [ 'imagePath'];



    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }
}
