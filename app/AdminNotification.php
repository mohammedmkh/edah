<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    //

    protected $fillable = [
        'owner_id','user_id', 'order_id','message',
    ];

    protected $table = 'admin_notification';

    protected $appends = ['imagePath','userData'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }

    public function getUserDataAttribute()
    {
        $user = User::where('id',$this->attributes['user_id'])->first();
        // $user['order_no'] = Order::where('id',$this->attributes['order_id'])->first()->order_no;
        return $user;
    }
}
