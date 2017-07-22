<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\LoanPayment;
use Modules\Accounting\Loan;

class CreateLoanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(LoanPayment::$TABLENAME, function (Blueprint $table) {
            $table->increments(LoanPayment::$COL_ID);
            $table->unsignedInteger(LoanPayment::$COL_LOAN_ID);
            $table->double(LoanPayment::$COL_AMOUNT);
            $table->timestamps();
            
            $table->foreign(LoanPayment::$COL_LOAN_ID)->references(Loan::$COL_ID)
                    ->on(Loan::$TABLENAME)
                    ->onDelete('cascade');
        });
        
        DB::unprepared('CREATE TRIGGER `before_insert_loanpayment` BEFORE INSERT ON `loan_payments`
        FOR EACH ROW BEGIN
        IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
	SET NEW.created_at = CURRENT_TIMESTAMP();
        SET NEW.updated_at = CURRENT_TIMESTAMP();
        END IF;
        END');
        
        DB::unprepared('CREATE TRIGGER `after_insert_loanpayment` AFTER INSERT ON `loan_payments`
        FOR EACH ROW BEGIN
        UPDATE loans
        SET loans.loan_paid = loans.loan_paid+ NEW.loanpay_amount
        WHERE NEW.loanpay_loanid = loans.loan_id;
        END');
        
        DB::unprepared('CREATE TRIGGER `after_update_loanpayment` AFTER UPDATE ON `loan_payments`
        FOR EACH ROW BEGIN
        UPDATE loans
        SET loans.loan_paid = loans.loan_paid + NEW.loanpay_amount - OLD.loanpay_amount
        WHERE NEW.loanpay_loanid = loans.loan_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `before_insert_loanpayment`');
        DB::unprepared('DROP TRIGGER `after_insert_loanpayment`');
        DB::unprepared('DROP TRIGGER `after_update_loanpayment`');
        Schema::dropIfExists(LoanPayment::$TABLENAME);
    }
}
