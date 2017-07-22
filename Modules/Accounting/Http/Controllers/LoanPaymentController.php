<?php
namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\LoanPayment;
use Modules\Accounting\Loan;
use Modules\Accounting\Account;

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
    
    public function addLoanPayment(){
        
    }
    
    public function updateLoanPayment(){
        
    }
    
    public function deleteLoanPayment(){
        
    }
   
}
