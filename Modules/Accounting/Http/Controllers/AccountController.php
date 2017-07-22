<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller {

    public static function addAccount(Account $account) {
        return $account->save();
    }

    public function getAccountsAll() {
        $accounts = self::getAccountAll();
        return response()->json($accounts);
    }

    public static function getAccountAll() {
        $accounts = Account::select(Account::$COL_ID, Account::$COL_Name, Account::$COL_Currency, Account::$COL_Fines, Account::$COL_Loan, Account::$COL_Shares, Account::$COL_MemberID)
                ->orderBy(Account::$COL_Name, 'asc')
                ->get();
        return $accounts;
    }

    public function accountAdd(Request $request) {
        $result = false;
        $this->validate($request, [
            Account::$COL_MemberID => 'required',
            Account::$COL_Name => 'required'
        ]);

        $acc = new Account();
        $account = self::putParamaters($request, $acc);

        if (self::addAccount($account)) {
            if (true) {
               $result =  $this->addShareFromAccount($account);
            }
            
        }

        return response()->json(['response' => $result]);
    }

    public function accountUpdate(Request $request) {
       $result = false;
        $this->validate($request, [
            Account::$COL_ID => 'required',
            Account::$COL_MemberID => 'required',
            Account::$COL_Name => 'required'
        ]);
        
        $submitedId = $request[Account::$COL_ID];

        $acc = Account::find($submitedId);
       
        $account = self::putParamaters($request, $acc);
       
        if ($account->update()) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function accountDelete(Request $request) {
        $result = false;
        $this->validate($request, [
            Account::$COL_ID => 'required'
        ]);

        $submitedId = $request[Account::$COL_ID];

        $account = Account::find($submitedId);
        
        if ($account->delete()) {
            $result = true;
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, Account $account){
        $account[Account::$COL_MemberID] = $request[Account::$COL_MemberID];
        $account[Account::$COL_Name] = $request[Account::$COL_Name];
        $account[Account::$COL_Shares] = $request[Account::$COL_Shares] == null ? 0:$request[Account::$COL_Shares] ;
        $account[Account::$COL_Fines] = $request[Account::$COL_Fines] == null ? 0:$request[Account::$COL_Fines] ;
        $account[Account::$COL_Loan] = $request[Account::$COL_Loan] == null ? 0:$request[Account::$COL_Loan] ;
        $account[Account::$COL_Currency] = $request[Account::$COL_Currency] == null ? 'TZH':$request[Account::$COL_Currency] ;
        return $account;
    }
    
    private function addShareFromAccount($account){
        return ShareController::addShareFromAccount($account);
    }

}
