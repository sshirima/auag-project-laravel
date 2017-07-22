<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Share;
use Modules\Accounting\ShareOffer;
use Modules\Accounting\Account;
use Modules\Accounting\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShareController extends Controller {

    public static function addShare(Share $share) {
        return $share->save();
    }

    public function getSharesAll() {
        $shares = self::getShareAll();
        return response()->json($shares);
    }

    public static function getShareAll() {
        $shares = \Illuminate\Support\Facades\DB::table(Share::$TABLENAME)
                ->join(Account::$TABLENAME, Share::$COL_ACCOUNT, '=', Account::$TABLENAME . '.' . Account::$COL_ID)
                ->join(Member::$TABLENAME, Account::$TABLENAME . '.' . Account::$COL_MemberID, '=', Member::$TABLENAME . '.' . Member::$COL_ID)
                ->select(Share::$TABLENAME . '.' . Share::$COL_ID, Share::$TABLENAME . '.' . Share::$COL_ACCOUNT, Share::$TABLENAME . '.' . Share::$COL_UNIT, Share::$TABLENAME . '.' . Share::$COL_AMOUNT_PURCHASED, Share::$TABLENAME . '.' . Share::$COL_UPDATED_AT, Share::$TABLENAME . '.' . Share::$COL_CURRENCY, Account::$TABLENAME . '.' . Account::$COL_Name)
                ->get();
        return $shares;
    }

    public function shareAdd(Request $request) {
        $result = false;
        $this->validate($request, [
            Share::$COL_ACCOUNT => 'required'
        ]);

        $share = new Share();
        $sh = self::putParamaters($request, $share);

        if (self::addShare($sh)) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public static function addShareFromAccount(Account $account) {
        $share = new Share();
        $share[Share::$COL_ACCOUNT] = $account[Account::$COL_ID];
        return $share->save();
    }

    public function shareUpdate(Request $request) {
        $result = false;
        $this->validate($request, [
            Share::$COL_ID => 'required',
            Share::$COL_ACCOUNT => 'required'
        ]);

        $submitedId = $request[Share::$COL_ID];

        $share = Share::find($submitedId);

        $sh = self::putParamaters($request, $share);

        if ($sh->update()) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function shareDelete(Request $request) {
        $result = false;
        $this->validate($request, [
            Share::$COL_ID => 'required'
        ]);

        $submitedId = $request[Share::$COL_ID];

        $share = Share::find($submitedId);

        if ($share->delete()) {
            $result = true;
        }
        return response()->json(['response' => $result]);
    }

    private static function putParamaters(Request $request, Share $share) {
        $share[Share::$COL_ACCOUNT] = $request[Share::$COL_ACCOUNT];
        $share[Share::$COL_AMOUNT_PURCHASED] = $request[Share::$COL_AMOUNT_PURCHASED];
        return $share;
    }

    public static function onInsertShareOffer(ShareOffer $shareOffer) {
        $shareOffer->share[Share::$COL_AMOUNT_PURCHASED] = $shareOffer->share[Share::$COL_AMOUNT_PURCHASED] + $shareOffer[ShareOffer::$COL_SHARE_AMOUNT];
        $shareOffer->share[Share::$COL_UNIT] = $shareOffer->share[Share::$COL_UNIT] + $shareOffer[ShareOffer::$COL_SHARE_UNIT];
        return $shareOffer->share->save();
    }

    public static function onDeleteShareOffer(ShareOffer $shareOffer) {
        if ($shareOffer->share[Share::$COL_AMOUNT_PURCHASED] > $shareOffer[ShareOffer::$COL_SHARE_AMOUNT] &&
                $shareOffer->share[Share::$COL_UNIT] > $shareOffer[ShareOffer::$COL_SHARE_UNIT]) {
            $shareOffer->share[Share::$COL_AMOUNT_PURCHASED] = $shareOffer->share[Share::$COL_AMOUNT_PURCHASED] - $shareOffer[ShareOffer::$COL_SHARE_AMOUNT];
            $shareOffer->share[Share::$COL_UNIT] = $shareOffer->share[Share::$COL_UNIT] - $shareOffer[ShareOffer::$COL_SHARE_UNIT];
            $shareOffer->share->save();
        } else {
            return false;
        }
    }

}
