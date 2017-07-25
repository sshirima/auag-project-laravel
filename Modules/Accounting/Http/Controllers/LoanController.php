<?php
namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Loan;
use Modules\Accounting\Account;
use Modules\Accounting\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

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
            ->join(Account::$TABLENAME, Loan::$COL_ACCOUNT, '=', Account::$TABLENAME.'.'.Account::$COL_ID)->join(Member::$TABLENAME, Account::$TABLENAME.'.'.Account::$COL_MemberID, '=', Member::$TABLENAME.'.'.Member::$COL_ID)
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
                    Account::$TABLENAME.'.'. Account::$COL_Name)
            ->get();
        return $loans;
    }

    public function loanAdd(Request $request) {
        $result = false;
        $this->validate($request, [
            Loan::$COL_ACCOUNT => 'required|unique:loans',
            Loan::$COL_PRINCIPLE => 'required|numeric',
            Loan::$COL_DURATION => 'required|numeric'
        ]);

        $loanRequest = new Loan();

        if (self::addLoan(self::putParamaters($request, $loanRequest))) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function loanUpdate(Request $request) {
       $result = false;
        $this->validate($request, [
            Loan::$COL_ID => 'required',
            Loan::$COL_PRINCIPLE => 'required|numeric',
            Loan::$COL_ACCOUNT => ['required', Rule::unique('loans')->ignore($request[Loan::$COL_ID],Loan::$COL_ID)],
            Loan::$COL_DURATION => 'required|numeric'
        ]);

        $oldLoan = Loan::find($request[Loan::$COL_ID]);
        
        if (self::putParamaters($request, $oldLoan)->update()) {
            $result = true;
        }

        return response()->json(['response' => $result]);
    }

    public function loanDelete(Request $request) {
        $result = false;
        $this->validate($request, [
            Loan::$COL_ID => 'required'
        ]);
        
        if (Loan::find($request[Loan::$COL_ID])->delete()) {
            $result = true;
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, Loan $loan){
        $loan[Loan::$COL_ACCOUNT] = $request[Loan::$COL_ACCOUNT];
        $loan[Loan::$COL_PRINCIPLE] = $request[Loan::$COL_PRINCIPLE];
        $loan[Loan::$COL_DURATION] = $request[Loan::$COL_DURATION];
        
        //Default values for loans
        if (!$loan[Loan::$COL_PAID] > 0){
            $loan[Loan::$COL_PAID] = 0;
        }
        $loan[Loan::$COL_RATE] = 15;
         return $loan;
    }
    
    public static function onInsertLoanPayment(\Modules\Accounting\LoanPayment $loanPayment){
        $loanPayment->loan[Loan::$COL_PAID] = $loanPayment->loan[Loan::$COL_PAID] + $loanPayment[\Modules\Accounting\LoanPayment::$COL_AMOUNT];
        return $loanPayment->loan->save();
    }
    
    public static function onDeleteLoanPayment(\Modules\Accounting\LoanPayment $loanPayment){
        $loanPayment->loan[Loan::$COL_PAID] = $loanPayment->loan[Loan::$COL_PAID] - $loanPayment[\Modules\Accounting\LoanPayment::$COL_AMOUNT];
        return $loanPayment->loan->save();
    }
}