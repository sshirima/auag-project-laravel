<?php
namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Fine;
use Modules\Accounting\Account;
use Modules\Accounting\FineDescription;
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
            ->join(FineDescription::$TABLENAME, Fine::$COL_DESCRIPTION, '=', FineDescription::$TABLENAME.'.'.FineDescription::$COL_ID)
            ->select(Fine::$TABLENAME.'.'.Fine::$COL_ID,
                    Fine::$TABLENAME.'.'.Fine::$COL_ACCOUNT,
                    Account::$TABLENAME.'.'.Account::$COL_Name,
                    FineDescription::$TABLENAME.'.'.FineDescription::$COL_AMOUNT,
                    FineDescription::$TABLENAME.'.'.FineDescription::$COL_DESCRIPTION,
                    Fine::$TABLENAME.'.'.Fine::$COL_OUTSTANDING,
                    Fine::$TABLENAME.'.'.Fine::$COL_PAID_AMOUNT,
                    Fine::$TABLENAME.'.'.Fine::$COL_CREATED_AT)
            ->get();
        return $fines;
    }
    
    public static function getFinesWithAccount() {
        $fines = \Illuminate\Support\Facades\DB::table(Fine::$TABLENAME)
            ->join(Account::$TABLENAME, Fine::$COL_ACCOUNT, '=', Account::$TABLENAME.'.'.Account::$COL_ID)
            ->select(Fine::$TABLENAME.'.'.Fine::$COL_ID,
                    Account::$TABLENAME.'.'.Account::$COL_Name)
            ->get();
        return $fines;
    }

    public function fineAdd(Request $request) {
        $result = false;
        $this->validate($request, [
            Fine::$COL_ACCOUNT => 'required',
            FineDescription::$COL_DESCRIPTION => 'required'
        ]);

        $fine = new Fine();
        $fn = self::putParamaters($request, $fine);

        if (self::addFine($fn)) {
            $result = self::afterInsertFine($fn);
        }

        return response()->json(['response' => $result]);
    }

    public function fineUpdate() {
       
        return response()->json(['response' => false]);
    }

    public function fineDelete(Request $request) {
        $result = false;
        $this->validate($request, [
            Fine::$COL_ID => 'required'
        ]);

        $submitedId = $request[Fine::$COL_ID];

        $fine = Fine::find($submitedId);
        
        if ($fine->delete()) {
            $result = self::afterDeleteFine($fine);
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, Fine $fine){
        $fine[Fine::$COL_ACCOUNT] = $request[Fine::$COL_ACCOUNT];
        $fine[Fine::$COL_DESCRIPTION] = $request[FineDescription::$COL_DESCRIPTION];
        $fine[Fine::$COL_OUTSTANDING] = 0;
         return $fine;
    }
    
    private static function afterInsertFine(Fine $fine){
        //Update account fines amount
        $fn = Fine::find($fine[Fine::$COL_ID]);
        $amount = $fn->finedescription[FineDescription::$COL_AMOUNT];
        $fn->account[Account::$COL_Fines] = $fn->account[Account::$COL_Fines] + $amount;
        return $fn->account->update();
    }
    private static function afterDeleteFine(Fine $fine){
        //Update account fines amount
        $fine->account[Account::$COL_Fines] = $fine->account[Account::$COL_Fines] - $fine->finedescription[FineDescription::$COL_AMOUNT];
        return $fine->account->update();
    }
}