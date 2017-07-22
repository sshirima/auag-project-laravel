<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    public static $TABLENAME = 'fines';
    public static $COL_ID = 'fine_id';
    public static $COL_ACCOUNT = 'fine_account';
    public static $COL_AMOUNT = 'fine_amount';
    public static $COL_DESCRIPTION = 'fine_description';
    public static $COL_PAID_AMOUNT = 'fine_paid';
    public static $COL_OUTSTANDING = 'fine_outstanding';
    public static $COL_CREATED_AT = 'created_at';
    
    protected $primaryKey= 'fine_id';
    
    public function account() {
        return $this->belongsTo('Modules\Accounting\Account', Fine::$COL_ACCOUNT);
    }
}
