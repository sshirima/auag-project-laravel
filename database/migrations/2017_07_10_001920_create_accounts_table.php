<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Account;

class CreateAccountsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(Account::$TABLENAME, function (Blueprint $table) {
            $table->increments(Account::$COL_ID);
            $table->string(Account::$COL_Name, 55);
            $table->unsignedInteger(Account::$COL_MemberID);
            $table->integer(Account::$COL_Shares)->default(0);
            $table->double(Account::$COL_Fines)->nullable()->default(0);
            $table->double(Account::$COL_Loan)->nullable()->default(0);
            $table->string(Account::$COL_Currency, 10)->nullable()->default('TZH');
            $table->timestamps();

            $table->foreign(Account::$COL_MemberID)->references(\Modules\Accounting\Member::$COL_ID)
                    ->on('members');
        });
        DB::unprepared('CREATE TRIGGER `before_insert_account` BEFORE INSERT ON `accounts`
        FOR EACH ROW BEGIN
            IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
            SET NEW.created_at = CURRENT_TIMESTAMP();
            SET NEW.updated_at = CURRENT_TIMESTAMP();
            END IF;
        END');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::unprepared('DROP TRIGGER `before_insert_account`');
        Schema::dropIfExists(Account::$TABLENAME);
    }

}
