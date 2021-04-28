<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPriceOffer extends Model
{

    protected $fillable = [
      'user_id','description','detail', 'price', 'document' , 'created_at' ,'order_id' , 'store_id'
    ];
    protected $table = 'supplier_price_offers';
    public $timestamps=false;

    protected $hidden = ['store'];


    protected $appends = ['status_name' ,'document_path'] ;

    public function getStatusNameAttribute(){
        if($this->status == 0){
            return 'new offer' ;
        }
        if($this->status == 1){
            return 'Respond to offer' ;
        }

        if($this->status == 2){
            return 'Accept offer' ;
        }

        return 'Reject offer' ;

    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function store()
    {
        return $this->belongsTo(User::class, 'store_id');
    }

    public function getDocumentPathAttribute(){
        if($this->document != ''){
            return url('/').'/'. $this->document;
        }


    }



}
