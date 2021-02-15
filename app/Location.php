<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    //
    // use SoftDeletes;
    protected $fillable = [
        'name', 'description', 'popular','status','latitude','longitude','radius',
    ];

    protected $table = 'location';
}
