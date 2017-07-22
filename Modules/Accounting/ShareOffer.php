<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Share;

class ShareOffer extends Model
{
    public static $TABLENAME = 'share_offers';
    public static $COL_ID = 'offer_id';
    public static $COL_SHARE_ID = 'offer_shareid';
    public static $COL_SHARE_UNIT = 'offer_units';
    public static $COL_SHARE_PRICE = 'offer_price';
    public static $COL_SHARE_AMOUNT = 'offer_amount';
    public static $COL_CREATED_AT = 'created_at';
    
    protected $primaryKey = 'offer_id';
    
    public function share()
    {
        return $this->belongsTo('Modules\Accounting\Share', self::$COL_SHARE_ID, Share::$COL_ID);
    }
}
