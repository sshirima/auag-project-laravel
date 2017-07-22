<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Share;
use Modules\Accounting\Account;

class CreateSharesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(Share::$TABLENAME, function (Blueprint $table) {
            $table->increments(Share::$COL_ID);
            $table->unsignedInteger(Share::$COL_ACCOUNT);
            $table->double(Share::$COL_UNIT)->default(0);
            $table->double(Share::$COL_AMOUNT_PURCHASED)->default(0);
            $table->string(Share::$COL_CURRENCY,10)->default('TZH');
            $table->timestamps();
            
            $table->foreign(Share::$COL_ACCOUNT)->references(Account::$COL_ID)
                    ->on('accounts')
                    ->onDelete('cascade');
        });
        DB::unprepared('CREATE TRIGGER `before_insert_share` BEFORE INSERT ON `shares`
        FOR EACH ROW BEGIN
            IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
            SET NEW.created_at = CURRENT_TIMESTAMP();
            SET NEW.updated_at = CURRENT_TIMESTAMP();
            END IF;
        END');
        
        DB::unprepared('CREATE TRIGGER `before_update_share` BEFORE UPDATE ON `shares`
        FOR EACH ROW 
        BEGIN
            IF (NEW.updated_at IS NULL) THEN
            SET NEW.updated_at = CURRENT_TIMESTAMP();
            END IF;
        END');
        
       DB::unprepared('CREATE TRIGGER `after_update_share` AFTER UPDATE ON `shares`
        FOR EACH ROW 
        BEGIN
            UPDATE accounts
            SET accounts.acc_shares = NEW.share_amount
            WHERE NEW.share_account = accounts.acc_id;
        END');
       
       DB::unprepared('CREATE TRIGGER `after_delete_share` AFTER DELETE ON `shares`
        FOR EACH ROW BEGIN
            UPDATE accounts
            SET accounts.acc_shares = 0
            WHERE OLD.share_account = accounts.acc_id;
        END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::unprepared('DROP TRIGGER `before_insert_share`');
        DB::unprepared('DROP TRIGGER `before_update_share`');
        DB::unprepared('DROP TRIGGER `after_update_share`');
        DB::unprepared('DROP TRIGGER `after_delete_share`');
        Schema::dropIfExists(Share::$TABLENAME);
    }

}
