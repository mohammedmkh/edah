<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeachnicalPosting extends Model
{
    //
    protected $fillable = [
        'first_order_id', 'last_order_id', 'total_technical','technical_id','created_at','updated_at','deleted_at',
    ];

    protected $table = 'teachnical_postings';
}
