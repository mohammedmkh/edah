<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    public $table = 'notifications';

    public $timestamps =false ;



    protected $fillable = [
        'action_type',
        'user_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getIsReadAttribute($value)
    {
        return (integer) $value;
    }
    public function getActionIdAttribute($value)
    {
        return (integer) $value;
    }

    public function getUserIdAttribute($value)
    {
        return (integer) $value;
    }





}
