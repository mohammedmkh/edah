<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class TechStoreDocuments extends Model
{
    //
    // use SoftDeletes;


    protected $table = 'technicians_stores_documents';
    protected $fillable = [
        'user_id' , 'document_id' , 'document_description' ,'document_link'
    ];



}
