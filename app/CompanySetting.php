<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Lang;
class CompanySetting extends Model
{
    //
    // use SoftDeletes;
    protected $fillable = [
        'name', 'address', 'location', 'phone', 'email', 'logo', 'favicon', 'description',
        'fees','website','profit_ratio' , 'conditions_ar' ,'conditions_en' ,'taxes'
    ];

    protected $table = 'company_setting';

    protected $appends = ['conditions'];

    public function getConditionsAttribute(){

        $lang = Lang::getLocale();
        if($lang == 'english'){
            return $this->conditions_en ;
        }

          return $this->conditions_ar ;

    }

}
