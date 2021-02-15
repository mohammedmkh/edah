<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGallery extends Model
{
    //
    protected $fillable = [
        'user_id', 'image',
    
    ];

    protected $table = 'user_gallery';

    protected $appends = ['imagePath'];

    public function getImagePathAttribute()
    {
        return url('images/upload') . '/';
    }
}
