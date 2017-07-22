<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller {

    public static function addTransaction(Transaction $transaction) {
        return $transaction->save();
    }

    public function getTransactionsAll() {
        $transactions = self::getTransactionAll();
        return response()->json($transactions);
    }

    public static function getTransactionAll() {
        $shares = \Illuminate\Support\Facades\DB::table(Share::$TABLENAME)
            ->join(Account::$TABLENAME, Share::$COL_ACCOUNT, '=', Account::$TABLENAME.'.'.Account::$COL_ID)
            ->join(Member::$TABLENAME, Account::$TABLENAME.'.'.Account::$COL_MemberID, '=', Member::$TABLENAME.'.'.Member::$COL_ID)
            ->select(Share::$TABLENAME.'.'.Share::$COL_ID,
                    Share::$TABLENAME.'.'.Share::$COL_ACCOUNT,
                    Share::$TABLENAME.'.'.Share::$COL_UNIT,
                    Share::$TABLENAME.'.'.Share::$COL_AMOUNT_PURCHASED,
                    Share::$TABLENAME.'.'.Share::$COL_CREATED_AT,
                   Member::$TABLENAME.'.'.Member::$COL_Firstname,
                   Member::$TABLENAME.'.'.Member::$COL_Lastname)
            ->get();
        return $shares;
    }

    public function transactionAdd(Request $request) {
        $result = false;
        $this->validate($request, [
            Transaction::$COL_Amount => 'required',
            Transaction::$COL_Account => 'required'
        ]);

        $trans = new Transaction();
        $transaction = self::putParamaters($request, $trans);

        if (self::addTransaction($transaction)) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function transactionUpdate(Request $request) {
       $result = false;
        $this->validate($request, [
            Transaction::$COL_ID => 'required',
            Transaction::$COL_Amount => 'required',
            Transaction::$COL_Account => 'required'
        ]);
        
        $submitedId = $request[Transaction::$COL_ID];

        $trans = Transaction::find($submitedId);
       
        $transaction = self::putParamaters($request, $trans);
       
        if ($transaction->update()) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function transactionDelete(Request $request) {
        $result = false;
        $this->validate($request, [
            Transaction::$COL_ID => 'required'
        ]);

        $submitedId = $request[Transaction::$COL_ID];

        $trans = Transaction::find($submitedId);
        
        if ($trans->delete()) {
            $result = true;
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, Transaction $transaction){
        $transaction[Transaction::$COL_Account] = $request[Transaction::$COL_Account];
        $transaction[Transaction::$COL_Amount] = $request[Transaction::$COL_Amount];
        $transaction[Transaction::$COL_Category] = $request[Transaction::$COL_Category] == null ? 'SHARES':$request[Transaction::$COL_Category] ;
        $transaction[Transaction::$COL_Currency] = $request[Transaction::$COL_Currency] == null ? 'TZH':$request[Transaction::$COL_Currency] ;
        return $transaction;
    }

}
