<?php
namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\LoanPayment;
use Modules\Accounting\Loan;
use Modules\Accounting\Account;
use Illuminate\Http\Request;

class LoanPaymentController  extends Controller {
    
    public function getLoanPaymentsAll(){
        $loanPayment = \Illuminate\Support\Facades\DB::table(LoanPayment::$TABLENAME)
            ->join(Loan::$TABLENAME, Loan::$TABLENAME.".".Loan::$COL_ID, "=", LoanPayment::$TABLENAME.".".LoanPayment::$COL_LOAN_ID)
            ->join(Account::$TABLENAME, Loan::$TABLENAME.".".Loan::$COL_ACCOUNT, "=",Account::$TABLENAME.".".Account::$COL_ID)
            ->select(Account::$TABLENAME.'.'.Account::$COL_ID,
                    Account::$TABLENAME.'.'.Account::$COL_Name,
                    LoanPayment::$TABLENAME.'.'.LoanPayment::$COL_ID,
                    LoanPayment::$TABLENAME.'.'.LoanPayment::$COL_LOAN_ID,
                    LoanPayment::$TABLENAME.'.'.LoanPayment::$COL_AMOUNT,
                    LoanPayment::$TABLENAME.'.'.LoanPayment::$COL_CREATED_AT,
                    Account::$TABLENAME.'.'.Account::$COL_Currency)
            ->get();
        return $loanPayment;
    }
    
    public static function getLoanAccount(){
        $loan_account = \Illuminate\Support\Facades\DB::table(Loan::$TABLENAME)
            ->join(Account::$TABLENAME, Loan::$COL_ACCOUNT, '=', Account::$TABLENAME.'.'.Account::$COL_ID)
                ->select(Loan::$TABLENAME.'.'.Loan::$COL_ID,
                   Account::$TABLENAME.'.'.Account::$COL_Name)
            ->get();
        return $loan_account;
    }

    public function addLoanPayment(Request $request){
        $result = false;
        $this->validate($request, [
            LoanPayment::$COL_LOAN_ID => 'required|numeric',
            LoanPayment::$COL_AMOUNT => 'required|numeric'
        ]);
        
        $payment = new LoanPayment();
        $loanPayment = self::putParamaters($request, $payment);

        if ($loanPayment->save()) {
            if (true) {
                //Update share table by adding the amount
                $result = LoanController::onInsertLoanPayment($loanPayment);
            }
        }

        return response()->json(['response' => $result]);
    }
    
    public function updateLoanPayment(){
        
    }
    
    public function deleteLoanPayment(Request $request){
        $result = false;
        $this->validate($request, [
            LoanPayment::$COL_ID => 'required'
        ]);

        $offerId = $request[LoanPayment::$COL_ID];

        $shareOffer = LoanPayment::find($offerId);
        
        if ($shareOffer->delete()) {
            $result = LoanController::onDeleteLoanPayment($shareOffer);
        }
        return response()->json(['response' => $result]);
    }
    
    private static function putParamaters(Request $request, LoanPayment $loanPayment){
        $loanPayment[LoanPayment::$COL_LOAN_ID] = $request[LoanPayment::$COL_LOAN_ID];
        $loanPayment[LoanPayment::$COL_AMOUNT] = $request[LoanPayment::$COL_AMOUNT];
        return $loanPayment;
    }
   
}
