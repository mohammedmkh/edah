<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class CompanySetting extends Model
{
    //
    // use SoftDeletes;
    protected $fillable = [
        'name', 'address', 'location', 'phone', 'email', 'logo', 'favicon', 'description', 'website',
    ];

    protected $table = 'company_setting';
}
