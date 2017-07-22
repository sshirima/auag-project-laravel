<?php
namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Accounting\FinePayment;
use Modules\Accounting\Fine;
use Modules\Accounting\Account;

class FinePaymentController  extends Controller {
    
    public function getFinePaymentsAll(){
        $finePayment = \Illuminate\Support\Facades\DB::table(FinePayment::$TABLENAME)
            ->join(Fine::$TABLENAME, Fine::$TABLENAME.".".Fine::$COL_ID, "=", FinePayment::$TABLENAME.".".FinePayment::$COL_FINE_ID)
            ->join(Account::$TABLENAME, Fine::$TABLENAME.".".Fine::$COL_ACCOUNT, "=",Account::$TABLENAME.".".Account::$COL_ID)
            ->select(Account::$TABLENAME.'.'.Account::$COL_ID,
                    Account::$TABLENAME.'.'.Account::$COL_Name,
                    FinePayment::$TABLENAME.'.'.FinePayment::$COL_ID,
                    FinePayment::$TABLENAME.'.'.FinePayment::$COL_FINE_ID,
                    FinePayment::$TABLENAME.'.'.FinePayment::$COL_AMOUNT,
                    FinePayment::$TABLENAME.'.'.FinePayment::$COL_CREATED_AT,
                    Account::$TABLENAME.'.'.Account::$COL_Currency)
            ->get();
        return $finePayment;
    }
    
    public function addFinePayment(){
        
    }
    
    public function updateFinePayment(){
        
    }
    
    public function deleteFinePayment(){
        
    }
   
}
