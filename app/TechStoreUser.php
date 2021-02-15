<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechStoreUser extends Model
{
    //

    protected $fillable = [
        'phone' ,'type' , 'min_order_value' , 'tech_store_email' ,'priority' , 'vat_no' ,'have_vehicle' ,'type_vehicle'
    ];

    protected $table = 'technicians_stores';

    protected $appends = [ 'imagePath' , 'cats'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }

    public function getCatsAttribute()
    {
        if($this->services != ''){
            return  json_decode($this->services);
        }
        return [] ;
    }
}
