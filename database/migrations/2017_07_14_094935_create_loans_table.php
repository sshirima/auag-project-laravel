<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Loan;
use Modules\Accounting\Account;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Loan::$TABLENAME, function (Blueprint $table) {
            $table->increments(Loan::$COL_ID);
            $table->unsignedInteger(Loan::$COL_ACCOUNT);
            $table->double(Loan::$COL_PRINCIPLE);
            $table->double(Loan::$COL_DURATION);
            $table->double(Loan::$COL_BALANCE);
            $table->double(Loan::$COL_PAID)->default(0);
            $table->double(Loan::$COL_RATE);
            $table->double(Loan::$COL_INTEREST)->default(0);
            $table->double(Loan::$COL_PROGRESS)->deafult(0);
            $table->timestamps();
            
            $table->foreign(Loan::$COL_ACCOUNT)
                    ->references(Account::$COL_ID)
                    ->on('accounts')
                    ->onDelete('cascade');
        });
        
        DB::unprepared('CREATE TRIGGER `before_insert_loan` BEFORE INSERT ON `loans`
        FOR EACH ROW BEGIN
            IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
            SET NEW.created_at = CURRENT_TIMESTAMP();
            SET NEW.updated_at = CURRENT_TIMESTAMP();
            END IF;
            
            SET NEW.loan_interest = NEW.loan_principle * NEW.loan_rate * NEW.loan_duration/12/100;
            SET NEW.loan_balance = NEW.loan_interest + NEW.loan_principle;
            SET NEW.loan_progress = NEW.loan_paid/(NEW.loan_principle + NEW.loan_interest);
        END');
        
        DB::unprepared('CREATE TRIGGER `before_update_loan` BEFORE UPDATE ON `loans`
        FOR EACH ROW 
        BEGIN
            IF (NEW.updated_at IS NULL) THEN
            SET NEW.updated_at = CURRENT_TIMESTAMP();
            END IF;
            
            IF NOT (NEW.loan_principle = OLD.loan_principle && NEW.loan_rate = OLD.loan_rate &&
            NEW.loan_duration = OLD.loan_duration) THEN 
             SET NEW.loan_interest = NEW.loan_principle * NEW.loan_rate * NEW.loan_duration/12/100;
             SET NEW.loan_balance = NEW.loan_interest + NEW.loan_principle - NEW.loan_paid;
             SET NEW.loan_progress = NEW.loan_paid/(NEW.loan_principle + NEW.loan_interest)*100;
            END IF;
            
            IF NOT (NEW.loan_paid = OLD.loan_paid) THEN 
               SET NEW.loan_balance = NEW.loan_interest + NEW.loan_principle - NEW.loan_paid;
               SET NEW.loan_progress = NEW.loan_paid/(NEW.loan_principle + NEW.loan_interest)*100;
            END IF;
            
        END');
        
        DB::unprepared('CREATE TRIGGER `after_update_loan` AFTER UPDATE ON `loans`
        FOR EACH ROW 
        BEGIN
            UPDATE accounts
            SET accounts.acc_loan = NEW.loan_balance
            WHERE NEW.loan_account = accounts.acc_id;
        END');
        
        DB::unprepared('CREATE TRIGGER `after_delete_loan` AFTER DELETE ON `loans`
        FOR EACH ROW BEGIN
            UPDATE accounts
            SET accounts.acc_loan = 0
            WHERE OLD.loan_account = accounts.acc_id;
        END');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `before_insert_loan`');
        DB::unprepared('DROP TRIGGER `before_update_loan`');
        DB::unprepared('DROP TRIGGER `after_update_loan`');
        DB::unprepared('DROP TRIGGER `after_delete_loan`');
        Schema::dropIfExists(Loan::$TABLENAME);
    }
}
