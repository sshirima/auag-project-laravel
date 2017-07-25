<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class Account extends Model {

    protected $primaryKey= 'acc_id';
    //Columns names
    public static $TABLENAME = 'accounts';
    public static $COL_ID = 'acc_id';
    public static $COL_Name = 'acc_name';
    public static $COL_MemberID = 'acc_member';
    public static $COL_Shares = 'acc_shares';
    public static $COL_Loan = 'acc_loan';
    public static $COL_Fines = 'acc_fines';
    public static $COL_Currency = 'acc_currency';

    public function member() {
        return $this->belongsTo('Modules\Accounting\Member', Account::$COL_MemberID);
    }
    
    public function shares(){
        return $this->hasMany('Modules\Accounting\Share', Share::$COL_ACCOUNT, Account::$COL_ID);
    }
    
    public function loans(){
        return $this->hasMany('Modules\Accounting\Loan', Loan::$COL_ACCOUNT, Account::$COL_ID);
    }
    
    public function fines(){
        return $this->hasMany('Modules\Accounting\Fine', Fine::$COL_ACCOUNT, Account::$COL_ID);
    }

}
