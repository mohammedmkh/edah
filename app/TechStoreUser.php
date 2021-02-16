<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechStoreUser extends Model
{
    //

    protected $fillable = [
        'order_min', 'phone' ,'type' , 'min_order_value' , 'driver_radius','tech_store_email' ,'work_time_from','work_time_to','priority' , 'vat_no' ,'have_vehicle' ,'type_vehicle','bank_account',"owner_account","bank_name"
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
