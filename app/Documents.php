<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Documents extends Model
{
    //
    // use SoftDeletes;


    protected $table = 'documents';
    protected $fillable = [
        'type' , 'is_required' , 'document_description'
    ];

    protected $hidden = ['created_at' , 'updated_at' , 'deleted_at'];


    protected $appends = ['is_required_name' , 'type_name'] ;


    public function getIsRequiredNameAttribute()
    {
       if($this->is_required == 1){
           return __('Required');
       }

        return __('Not Required');
    }

    public function getTypeNameAttribute()
    {
        if($this->type == 1){
            return __('Technical');
        }

        return __('Store Owner');
    }

}
