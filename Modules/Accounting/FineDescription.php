<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Fine;

class FineDescription extends Model
{
    public static $TABLENAME = 'fine_descriptions';
    public static $COL_ID = 'finedesc_id';
    public static $COL_DESCRIPTION = 'finedesc_desc';
    public static $COL_AMOUNT = 'finedesc_amount';
    
    public function fines(){
        return $this->hasMany('Modules\Accounting\Fine', Fine::$COL_DESCRIPTION);
    }
}
