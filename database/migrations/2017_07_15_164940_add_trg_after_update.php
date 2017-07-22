<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrgAfterUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER `after_insert_share` AFTER INSERT ON `shares`
        FOR EACH ROW 
        BEGIN
            UPDATE accounts
            SET accounts.acc_shares = NEW.share_amount
            WHERE NEW.share_account = accounts.acc_id;
           
        END');
        DB::unprepared('CREATE TRIGGER `after_insert_loan` AFTER INSERT ON `loans`
        FOR EACH ROW 
        BEGIN
            UPDATE accounts
            SET accounts.acc_loan = NEW.loan_balance
            WHERE NEW.loan_account = accounts.acc_id;
           
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `after_insert_loan`');
        DB::unprepared('DROP TRIGGER `after_insert_share`');
    }
}
