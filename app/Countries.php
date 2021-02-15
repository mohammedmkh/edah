<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Countries extends Model
{
    //
    // use SoftDeletes;


    protected $table = 'countries';

    protected $fillable = [
        'name' , 'status'
    ];
    protected $appends = [ 'statusName',];

    public function getStatusNameAttribute()
    {
       if($this->status == 1){
           return __('Active');
       }
        return __('Deactive');
    }

    public $timestamps = false;

}
