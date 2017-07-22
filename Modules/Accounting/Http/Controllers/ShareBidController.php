<?php
namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\ShareBid;
use Modules\Accounting\Share;
use Modules\Accounting\Account;
use Modules\Accounting\Http\Controllers\ShareController;
use Illuminate\Http\Request;

class ShareBidController  extends Controller {
    
    public function getShareBidsAll(){
        $shareBids = \Illuminate\Support\Facades\DB::table(ShareBid::$TABLENAME)
            ->join(Share::$TABLENAME, Share::$TABLENAME.".".Share::$COL_ID, "=", ShareBid::$TABLENAME.".".ShareBid::$COL_SHARE_ID)
            ->join(Account::$TABLENAME, Share::$TABLENAME.".".Share::$COL_ACCOUNT, "=",Account::$TABLENAME.".".Account::$COL_ID)
            ->select(Account::$TABLENAME.'.'.Account::$COL_Name,
                    ShareBid::$TABLENAME.'.'.ShareBid::$COL_SHARE_ID,
                    ShareBid::$TABLENAME.'.'.ShareBid::$COL_ID,
                    ShareBid::$TABLENAME.'.'.ShareBid::$COL_SHARE_PRICE,
                    ShareBid::$TABLENAME.'.'.ShareBid::$COL_SHARE_UNIT,
                    ShareBid::$TABLENAME.'.'.ShareBid::$COL_SHARE_AMOUNT,
                    ShareBid::$TABLENAME.'.'.ShareBid::$COL_CREATED_AT,
                    Share::$TABLENAME.'.'.Share::$COL_CURRENCY)
            ->get();
        return $shareBids;
    }
    
    public static function getShareAccount() {
        $shares_account = \Illuminate\Support\Facades\DB::table(Share::$TABLENAME)
            ->join(Account::$TABLENAME, Share::$COL_ACCOUNT, '=', Account::$TABLENAME.'.'.Account::$COL_ID)
                ->select(Share::$TABLENAME.'.'.Share::$COL_ID,
                   Account::$TABLENAME.'.'.Account::$COL_Name)
            ->get();
        return $shares_account;
    }
    
    public function shareBidAdd(Request $request){
        $result = false;
        $this->validate($request, [
            ShareBid::$COL_SHARE_ID => 'required|numeric',
            ShareBid::$COL_SHARE_AMOUNT => 'required|numeric'
        ]);
        
        $bid = new ShareBid();
        $shareBid = self::putParamaters($request, $bid);

        if ($shareBid->save()) {
            if (true) {
                //Update share table by adding the amount
                $result = ShareController::onInsertShareBid($shareBid);
            }
        }

        return response()->json(['response' => $result]);
    }
    
    public function updateShareBid(){
        
    }
    
    public function shareBidDelete(Request $request){
        $result = false;
        $this->validate($request, [
            ShareBid::$COL_ID => 'required'
        ]);

        $bidId = $request[ShareBid::$COL_ID];

        $shareBid = ShareBid::find($bidId);
        
        if ($shareBid->delete()) {
            $result = ShareController::onDeleteShareBid($shareBid);
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, ShareBid $shareBid){
        $shareBid[ShareBid::$COL_SHARE_ID] = $request[ShareBid::$COL_SHARE_ID];
        //Assign constant value for Price
        $request[ShareBid::$COL_SHARE_PRICE] = 500;
        if ($request[ShareBid::$COL_SHARE_AMOUNT] > 0){
            $shareBid[ShareBid::$COL_SHARE_UNIT] = $request[ShareBid::$COL_SHARE_AMOUNT]/$request[ShareBid::$COL_SHARE_PRICE];
        }
        $shareBid[ShareBid::$COL_SHARE_PRICE] = $request[ShareBid::$COL_SHARE_PRICE];
        $shareBid[ShareBid::$COL_SHARE_AMOUNT] = $request[ShareBid::$COL_SHARE_AMOUNT];
        $shareBid[ShareBid::$COL_SHARE_PRICE] = $request[ShareBid::$COL_SHARE_PRICE];
        return $shareBid;
    }
}
