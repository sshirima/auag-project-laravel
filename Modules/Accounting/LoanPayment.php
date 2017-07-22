<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    public static $TABLENAME = 'loan_payments';
    public static $COL_ID = 'loanpay_id';
    public static $COL_LOAN_ID = 'loanpay_loanid';
    public static $COL_AMOUNT = 'loanpay_amount';
    public static $COL_CREATED_AT = 'created_at';
    public static $COL_UPDATED_AT = 'updated_at';
    
    protected $primaryKey = 'loanpay_id';
}
