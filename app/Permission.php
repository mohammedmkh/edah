<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //

    protected $fillable = [
        'name', 'status',
    ];
     protected $table = 'permission';
}
    