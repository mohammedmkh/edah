<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointSetting extends Model
{
    //
    protected $fillable = [
        'enable_point', 'point_per_order','value_per_point', 'max_order_for_point','min_cart_value_for_point','max_redeem_amount',
    ];
    protected $table = 'point_setting';

}
