<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\FinePayment;
use Modules\Accounting\Fine;
use Modules\Accounting\Account;
use Illuminate\Http\Request;
use Modules\Accounting\FineDescription;

class FinePaymentController extends Controller {

    public function getFinePaymentsAll() {
        $finePayment = \Illuminate\Support\Facades\DB::table(FinePayment::$TABLENAME)
                ->join(Fine::$TABLENAME, Fine::$TABLENAME . "." . Fine::$COL_ID, "=", FinePayment::$TABLENAME . "." . FinePayment::$COL_FINE_ID)
                ->join(Account::$TABLENAME, Fine::$TABLENAME . "." . Fine::$COL_ACCOUNT, "=", Account::$TABLENAME . "." . Account::$COL_ID)
                ->join(FineDescription::$TABLENAME, Fine::$TABLENAME . "." . Fine::$COL_DESCRIPTION, "=", FineDescription::$TABLENAME . "." . FineDescription::$COL_ID)
                ->select(Account::$TABLENAME . '.' . Account::$COL_ID, Account::$TABLENAME . '.' . Account::$COL_Name, FinePayment::$TABLENAME . '.' . FinePayment::$COL_ID, FinePayment::$TABLENAME . '.' . FinePayment::$COL_FINE_ID, FineDescription::$TABLENAME . '.' . FineDescription::$COL_DESCRIPTION, FinePayment::$TABLENAME . '.' . FinePayment::$COL_AMOUNT, FinePayment::$TABLENAME . '.' . FinePayment::$COL_CREATED_AT, Account::$TABLENAME . '.' . Account::$COL_Currency)
                ->get();
        return $finePayment;
    }

    public function addFinePayment(Request $request) {
        $result = false;
        $this->validate($request, [
            FinePayment::$COL_FINE_ID => 'required',
            FinePayment::$COL_AMOUNT => 'required'
        ]);
        
        if (self::saveNewPayment($request)) {
            $result = self::afterInstertFinePayment($request);
        }

        return response()->json(['response' => $result]);
    }

    public function updateFinePayment() {
        
    }

    public function deleteFinePayment(Request $request) {
        $result = false;
        $this->validate($request, [
            FinePayment::$COL_ID => 'required'
        ]);
        $finepayment = FinePayment::find($request[FinePayment::$COL_ID]);
        if ($finepayment->delete()) {
            $result = self::afterDeleteFinePayment($request);
        }
        return response()->json(['response' => $result]);
    }

    private static function saveNewPayment(Request $request) {
        $payment = new FinePayment();
        $payment[FinePayment::$COL_FINE_ID] = $request[FinePayment::$COL_FINE_ID];
        $payment[FinePayment::$COL_AMOUNT] = $request[FinePayment::$COL_AMOUNT];
        return $payment->save();
    }

    private static function afterInstertFinePayment(Request $request) {
        $fine = Fine::find($request[FinePayment::$COL_FINE_ID]);
        $fine[Fine::$COL_PAID_AMOUNT] = $fine[Fine::$COL_PAID_AMOUNT] + $request[FinePayment::$COL_AMOUNT];
        return $fine->update();
    }
    
    private static function afterDeleteFinePayment(Request $request) {
        $fine = Fine::find($request[FinePayment::$COL_FINE_ID]);
        $fine[Fine::$COL_PAID_AMOUNT] = $fine[Fine::$COL_PAID_AMOUNT] - $request[FinePayment::$COL_AMOUNT];
        return $fine->update();
    }

}
