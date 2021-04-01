<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devicetoken extends Model
{
    public $table = 'devicetoken';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'ddevice_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
