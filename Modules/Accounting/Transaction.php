<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    //Columns names
    public static $TABLENAME = 'transactions';
    public static $COL_ID = 'trans_id';
    public static $COL_CATEGORY_REF = 'trans_cat_ref';
    public static $COL_REFERENCE = 'trans_reference';
    public static $COL_AMOUNT = 'trans_amount';
    public static $COL_CATEGORY = 'trans_category';
    public static $COL_CURRENCY = 'trans_currency';
    public static $COL_DESCRIPTION = 'trans_description';
    public static $COL_TYPE = 'trans_type';
    public static $COL_CREATED_AT = 'created_at';
    public static $COL_UPDATED_AT = 'updated_at';
    
    protected $primaryKey= 'trans_id';
}
