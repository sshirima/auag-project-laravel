<?php
namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Loan;
use Modules\Accounting\Account;
use Modules\Accounting\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanController extends Controller {
    
    public static function addLoan(Loan $loan) {
        return $loan->save();
    }

    public function getLoansAll() {
        $loans = self::getLoanAll();
        return response()->json($loans);
    }

    public static function getLoanAll() {
        $loans = \Illuminate\Support\Facades\DB::table(Loan::$TABLENAME)
            ->join(Account::$TABLENAME, Loan::$COL_ACCOUNT, '=', Account::$TABLENAME.'.'.Account::$COL_ID)
            ->join(Member::$TABLENAME, Account::$TABLENAME.'.'.Account::$COL_MemberID, '=', Member::$TABLENAME.'.'.Member::$COL_ID)
            ->select(Loan::$TABLENAME.'.'.Loan::$COL_ID,
                    Loan::$TABLENAME.'.'.Loan::$COL_ACCOUNT,
                    Loan::$TABLENAME.'.'.Loan::$COL_BALANCE,
                    Loan::$TABLENAME.'.'.Loan::$COL_PRINCIPLE,
                    Loan::$TABLENAME.'.'.Loan::$COL_RATE,
                    Loan::$TABLENAME.'.'.Loan::$COL_DURATION,
                    Loan::$TABLENAME.'.'.Loan::$COL_INTEREST,
                    Loan::$TABLENAME.'.'.Loan::$COL_PAID,
                    Loan::$TABLENAME.'.'.Loan::$COL_PROGRESS,
                    Loan::$TABLENAME.'.'.Loan::$COL_CREATED_AT,
                   Member::$TABLENAME.'.'.Member::$COL_Firstname,
                   Member::$TABLENAME.'.'.Member::$COL_Lastname)
            ->get();
        return $loans;
    }

    public function loanAdd(Request $request) {
        $result = false;
        $this->validate($request, [
            Loan::$COL_ACCOUNT => 'required'
        ]);

        $loan = new Loan();
        $sh = self::putParamaters($request, $loan);

        if (self::addLoan($sh)) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function loanUpdate(Request $request) {
       $result = false;
        $this->validate($request, [
            Loan::$COL_ID => 'required',
            Loan::$COL_ACCOUNT => 'required'
        ]);
        
        $submitedId = $request[Loan::$COL_ID];

        $loan = Loan::find($submitedId);
       
        $sh = self::putParamaters($request, $loan);
       
        if ($sh->update()) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function loanDelete(Request $request) {
        $result = false;
        $this->validate($request, [
            Loan::$COL_ID => 'required'
        ]);

        $submitedId = $request[Loan::$COL_ID];

        $loan = Loan::find($submitedId);
        
        if ($loan->delete()) {
            $result = true;
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, Loan $loan){
        $loan[Loan::$COL_ACCOUNT] = $request[Loan::$COL_ACCOUNT];
        $loan[Loan::$COL_AMOUNT_PURCHASED] = $request[Loan::$COL_AMOUNT_PURCHASED];
         return $loan;
    }
}