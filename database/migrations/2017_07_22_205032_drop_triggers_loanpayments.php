<?php

use Illuminate\Database\Migrations\Migration;

class DropTriggersLoanpayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::unprepared('DROP TRIGGER `before_insert_loanpayment`');
        DB::unprepared('DROP TRIGGER `after_insert_loanpayment`');
        DB::unprepared('DROP TRIGGER `after_update_loanpayment`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
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
}
