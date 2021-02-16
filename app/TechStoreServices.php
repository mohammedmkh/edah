<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechStoreServices extends Model
{
    //

    protected $fillable = [
        'user_id', 'category_id'
    ];

    protected $table = 'tech_store_services';



}
