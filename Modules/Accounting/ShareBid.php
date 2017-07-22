<?php

namespace Modules\Accounting;

use Illuminate\Database\Eloquent\Model;

class ShareBid extends Model
{
    public static $TABLENAME = 'share_bids';
    public static $COL_ID = 'bid_id';
    public static $COL_SHARE_ID = 'bid_shareid';
    public static $COL_SHARE_UNIT = 'bid_units';
    public static $COL_SHARE_PRICE = 'bid_price';
    public static $COL_SHARE_AMOUNT = 'bid_amount';
    public static $COL_CREATED_AT = 'created_at';
    public static $COL_UPDATED_AT = 'updated_at';
    
    protected $primaryKey = 'bid_id';
    
    public function share()
    {
        return $this->belongsTo('Modules\Accounting\Share', self::$COL_SHARE_ID, Share::$COL_ID);
    }
    
}
