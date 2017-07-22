<?php
namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\ShareOffer;
use Modules\Accounting\Share;
use Modules\Accounting\Account;
use Modules\Accounting\Http\Controllers\ShareController;
use Illuminate\Http\Request;

class ShareOfferController  extends Controller {
    
    public function getShareOffersAll(){
        $shareOffers = \Illuminate\Support\Facades\DB::table(ShareOffer::$TABLENAME)
            ->join(Share::$TABLENAME, Share::$TABLENAME.".".Share::$COL_ID, "=", ShareOffer::$TABLENAME.".".ShareOffer::$COL_SHARE_ID)
            ->join(Account::$TABLENAME, Share::$TABLENAME.".".Share::$COL_ACCOUNT, "=",Account::$TABLENAME.".".Account::$COL_ID)
            ->select(Account::$TABLENAME.'.'.Account::$COL_Name,
                    ShareOffer::$TABLENAME.'.'.ShareOffer::$COL_SHARE_ID,
                    ShareOffer::$TABLENAME.'.'.ShareOffer::$COL_ID,
                    ShareOffer::$TABLENAME.'.'.ShareOffer::$COL_SHARE_PRICE,
                    ShareOffer::$TABLENAME.'.'.ShareOffer::$COL_SHARE_UNIT,
                    ShareOffer::$TABLENAME.'.'.ShareOffer::$COL_SHARE_AMOUNT,
                    ShareOffer::$TABLENAME.'.'.ShareOffer::$COL_CREATED_AT,
                    Share::$TABLENAME.'.'.Share::$COL_CURRENCY)
            ->get();
        return $shareOffers;
    }
    
    public static function getShareAccount() {
        $shares_account = \Illuminate\Support\Facades\DB::table(Share::$TABLENAME)
            ->join(Account::$TABLENAME, Share::$COL_ACCOUNT, '=', Account::$TABLENAME.'.'.Account::$COL_ID)
                ->select(Share::$TABLENAME.'.'.Share::$COL_ID,
                   Account::$TABLENAME.'.'.Account::$COL_Name)
            ->get();
        return $shares_account;
    }
    
    public function shareOfferAdd(Request $request){
        $result = false;
        $this->validate($request, [
            ShareOffer::$COL_SHARE_ID => 'required|numeric',
            ShareOffer::$COL_SHARE_AMOUNT => 'required|numeric'
        ]);
        
        $offer = new ShareOffer();
        $shareOffer = self::putParamaters($request, $offer);

        if ($shareOffer->save()) {
            if (true) {
                //Update share table by adding the amount
                $result = ShareController::onInsertShareOffer($shareOffer);
            }
        }

        return response()->json(['response' => $result]);
    }
    
    public function updateShareOffer(){
        
    }
    
    public function shareOfferDelete(Request $request){
        $result = false;
        $this->validate($request, [
            ShareOffer::$COL_ID => 'required'
        ]);

        $offerId = $request[ShareOffer::$COL_ID];

        $shareOffer = ShareOffer::find($offerId);
        
        if ($shareOffer->delete()) {
            $result = ShareController::onDeleteShareOffer($shareOffer);
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, ShareOffer $shareOffer){
        $shareOffer[ShareOffer::$COL_SHARE_ID] = $request[ShareOffer::$COL_SHARE_ID];
        //Assign constant value for Price
        $request[ShareOffer::$COL_SHARE_PRICE] = 500;
        if ($request[ShareOffer::$COL_SHARE_AMOUNT] > 0){
            $shareOffer[ShareOffer::$COL_SHARE_UNIT] = $request[ShareOffer::$COL_SHARE_AMOUNT]/$request[ShareOffer::$COL_SHARE_PRICE];
        }
        $shareOffer[ShareOffer::$COL_SHARE_PRICE] = $request[ShareOffer::$COL_SHARE_PRICE];
        $shareOffer[ShareOffer::$COL_SHARE_AMOUNT] = $request[ShareOffer::$COL_SHARE_AMOUNT];
        $shareOffer[ShareOffer::$COL_SHARE_PRICE] = $request[ShareOffer::$COL_SHARE_PRICE];
        return $shareOffer;
    }
}
