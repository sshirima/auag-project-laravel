<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Account;
use Modules\Accounting\ShareOffer;
use Modules\Accounting\ShareBid;

class Share extends Model {

    public static $TABLENAME = 'shares';
    public static $COL_ID = 'share_id';
    public static $COL_ACCOUNT = 'share_account';
    public static $COL_AMOUNT_PURCHASED = 'share_amount';
    public static $COL_UNIT = 'share_units';
    public static $COL_PRICE = 'share_price';
    public static $COL_CURRENCY = 'share_currency';
    public static $COL_CREATED_AT = 'created_at';
    public static $COL_UPDATED_AT = 'updated_at';
    protected $primaryKey = 'share_id';

    public function account() {
        return $this->belongsTo('Modules\Accounting\Account', Share::$COL_ACCOUNT, Account::$COL_ID);
    }
    
    public function shareoffers()
    {
        return $this->hasMany('Modules\Accounting\ShareOffer', ShareOffer::$COL_SHARE_ID, self::$COL_ID);
    }
    
    public function sharebids()
    {
        return $this->hasMany('Modules\Accounting\ShareBid', ShareBid::$COL_SHARE_ID, self::$COL_ID);
    }
}
