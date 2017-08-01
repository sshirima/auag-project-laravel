<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTriggersFines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP TRIGGER `before_insert_fine`');
        DB::unprepared('DROP TRIGGER `after_insert_fine`');
        DB::unprepared('DROP TRIGGER `before_update_fine`');
        DB::unprepared('DROP TRIGGER `after_update_fine`');
        DB::unprepared('DROP TRIGGER `after_delete_fine`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
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
}
