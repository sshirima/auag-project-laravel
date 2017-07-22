<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //Columns names
    public static $TABLENAME = 'transactions';
    public static $COL_ID = 'trans_id';
    public static $COL_AccountID = 'trans_account';
    public static $COL_Amount = 'trans_amount';
    public static $COL_Curreny = 'trans_currency';
    public static $COL_Category = 'trans_category';
}
