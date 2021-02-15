<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Cities extends Model
{
    //
    // use SoftDeletes;


    protected $table = 'cities';
    protected $fillable = [
        'name'
    ];


    public function country()
    {
        return $this->hasOne('App\Countries', 'code', 'country_code');
    }


}
