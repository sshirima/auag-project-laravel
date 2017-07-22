<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class FinePayment extends Model
{
    public static $TABLENAME = 'fine_payments';
    public static $COL_ID = 'finepay_id';
    public static $COL_FINE_ID = 'finepay_fineid';
    public static $COL_AMOUNT = 'finepay_amount';
    public static $COL_CREATED_AT = 'created_at';
    public static $COL_UPDATED_AT= 'updated_at';
    
    protected $primaryKey = 'finepay_id';
}
