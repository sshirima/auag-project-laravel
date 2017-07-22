<?php
namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Fine;
use Modules\Accounting\Account;
use Modules\Accounting\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FineController extends Controller {
    
    public static function addFine(Fine $fine) {
        return $fine->save();
    }

    public function getFinesAll() {
        $fines = self::getFineAll();
        return response()->json($fines);
    }

    public static function getFineAll() {
        $fines = \Illuminate\Support\Facades\DB::table(Fine::$TABLENAME)
            ->join(Account::$TABLENAME, Fine::$COL_ACCOUNT, '=', Account::$TABLENAME.'.'.Account::$COL_ID)
            ->join(Member::$TABLENAME, Account::$TABLENAME.'.'.Account::$COL_MemberID, '=', Member::$TABLENAME.'.'.Member::$COL_ID)
            ->select(Fine::$TABLENAME.'.'.Fine::$COL_ID,
                    Fine::$TABLENAME.'.'.Fine::$COL_ACCOUNT,
                    Fine::$TABLENAME.'.'.Fine::$COL_AMOUNT,
                    Fine::$TABLENAME.'.'.Fine::$COL_DESCRIPTION,
                    Fine::$TABLENAME.'.'.Fine::$COL_OUTSTANDING,
                    Fine::$TABLENAME.'.'.Fine::$COL_PAID_AMOUNT,
                    Fine::$TABLENAME.'.'.Fine::$COL_CREATED_AT,
                   Member::$TABLENAME.'.'.Member::$COL_Firstname,
                   Member::$TABLENAME.'.'.Member::$COL_Lastname)
            ->get();
        return $fines;
    }

    public function fineAdd(Request $request) {
        $result = false;
        $this->validate($request, [
            Fine::$COL_ACCOUNT => 'required'
        ]);

        $fine = new Fine();
        $sh = self::putParamaters($request, $fine);

        if (self::addFine($sh)) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function fineUpdate(Request $request) {
       $result = false;
        $this->validate($request, [
            Fine::$COL_ID => 'required',
            Fine::$COL_ACCOUNT => 'required'
        ]);
        
        $submitedId = $request[Fine::$COL_ID];

        $fine = Fine::find($submitedId);
       
        $sh = self::putParamaters($request, $fine);
       
        if ($sh->update()) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function fineDelete(Request $request) {
        $result = false;
        $this->validate($request, [
            Fine::$COL_ID => 'required'
        ]);

        $submitedId = $request[Fine::$COL_ID];

        $fine = Fine::find($submitedId);
        
        if ($fine->delete()) {
            $result = true;
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, Fine $fine){
        $fine[Fine::$COL_ACCOUNT] = $request[Fine::$COL_ACCOUNT];
        $fine[Fine::$COL_AMOUNT_PURCHASED] = $request[Fine::$COL_AMOUNT_PURCHASED];
         return $fine;
    }
}