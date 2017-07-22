<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Fine;
use Modules\Accounting\Account;

class CreateFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Fine::$TABLENAME, function (Blueprint $table) {
            $table->increments(Fine::$COL_ID);
            $table->unsignedInteger(Fine::$COL_ACCOUNT);
            $table->double(Fine::$COL_AMOUNT);
            $table->string(Fine::$COL_DESCRIPTION)->default('NO_DESCRIPTION');
            $table->double(Fine::$COL_OUTSTANDING);
            $table->double(Fine::$COL_PAID_AMOUNT)->default(0);
            $table->timestamps();
            
            $table->foreign(Fine::$COL_ACCOUNT)
                    ->references(Account::$COL_ID)
                    ->on('accounts')
                    ->onDelete('cascade');
        });
        DB::unprepared('CREATE TRIGGER `before_insert_fine` BEFORE INSERT ON `fines`
        FOR EACH ROW BEGIN
            IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
            SET NEW.created_at = CURRENT_TIMESTAMP();
            SET NEW.updated_at = CURRENT_TIMESTAMP();
            END IF;
            SET NEW.fine_outstanding = NEW.fine_amount - NEW.fine_paid;
        END');
        
        DB::unprepared('CREATE TRIGGER `after_insert_fine` AFTER INSERT ON `fines`
        FOR EACH ROW 
        BEGIN
            UPDATE accounts
            SET accounts.acc_fines = accounts.acc_fines + NEW.fine_amount
            WHERE NEW.fine_account = accounts.acc_id;
           
        END');
        
        DB::unprepared('CREATE TRIGGER `before_update_fine` BEFORE UPDATE ON `fines`
        FOR EACH ROW 
        BEGIN
            IF (NEW.updated_at IS NULL) THEN
            SET NEW.updated_at = CURRENT_TIMESTAMP();
            END IF;
            SET NEW.fine_outstanding = NEW.fine_amount - NEW.fine_paid;
        END');
        
        DB::unprepared('CREATE TRIGGER `after_update_fine` AFTER UPDATE ON `fines`
        FOR EACH ROW 
        BEGIN
            UPDATE accounts
            SET accounts.acc_fines = accounts.acc_fines + NEW.fine_outstanding - OLD.fine_outstanding
            WHERE NEW.fine_account = accounts.acc_id;
        END');
        
        DB::unprepared('CREATE TRIGGER `after_delete_fine` AFTER DELETE ON `fines`
        FOR EACH ROW BEGIN
            UPDATE accounts
            SET accounts.acc_fines = accounts.acc_fines - OLD.fine_amount
            WHERE OLD.fine_account = accounts.acc_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `before_insert_fine`');
        DB::unprepared('DROP TRIGGER `after_insert_fine`');
        DB::unprepared('DROP TRIGGER `before_update_fine`');
        DB::unprepared('DROP TRIGGER `after_update_fine`');
        DB::unprepared('DROP TRIGGER `after_delete_fine`');
        Schema::dropIfExists(Fine::$TABLENAME);
    }
}
