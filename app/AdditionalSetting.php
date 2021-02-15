<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalSetting extends Model
{
    //
    // use SoftDeletes;
    protected $fillable = [
      'code','the_key','value', 'status'
    ];
    protected $table = 'settings';


    protected $appends = [ 'status_name'] ;


    public function getStatusNameAttribute()
    {
        if($this->status == 1){
            return __('Active');
        }

        return __('Not Active');
    }


}