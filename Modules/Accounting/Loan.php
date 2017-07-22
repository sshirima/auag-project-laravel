<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public static $TABLENAME = 'loans';
    public static $COL_ID = 'loan_id';
    public static $COL_ACCOUNT = 'loan_account';
    public static $COL_PRINCIPLE = 'loan_principle';
    public static $COL_RATE = 'loan_rate';
    public static $COL_DURATION = 'loan_duration';
    public static $COL_BALANCE = 'loan_balance';
    public static $COL_PAID = 'loan_paid';
    public static $COL_PROGRESS = 'loan_progress';
    public static $COL_INTEREST = 'loan_interest';
    public static $COL_CREATED_AT = 'created_at';
    
    protected $primaryKey= 'loan_id';
    
    public function account() {
        return $this->belongsTo('Modules\Accounting\Account', Loan::$COL_ACCOUNT);
    }
}
