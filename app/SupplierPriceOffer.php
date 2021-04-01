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


    protected $appends = ['status_name' ,'document_path'] ;

    public function getStatusNameAttribute(){
        if($this->status == 0){
            return 'new order' ;
        }
        if($this->status == 1){
            return 'Accept order' ;
        }
        return 'Reject order' ;

    }
    public function technician()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getDocumentPathAttribute(){
        if($this->document != ''){
            return url('/').'/'. $this->document;
        }


    }



}
