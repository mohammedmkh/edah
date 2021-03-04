<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierPriceOffer extends Model
{

    protected $fillable = [
      'user_id','description','detail', 'price', 'document_path'
    ];
    protected $table = 'supplier_price_offers';
    public $timestamps=false;




}
