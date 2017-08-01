<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveTriggersFinepayments extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::unprepared('DROP TRIGGER `before_insert_finepayment`');
        DB::unprepared('DROP TRIGGER `after_insert_finepayment`');
        DB::unprepared('DROP TRIGGER `after_update_finepayment`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::unprepared('CREATE TRIGGER `before_insert_finepayment` BEFORE INSERT ON `fine_payments`
        FOR EACH ROW BEGIN
        IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
	SET NEW.created_at = CURRENT_TIMESTAMP();
        SET NEW.updated_at = CURRENT_TIMESTAMP();
        END IF;
        END');
        DB::unprepared('CREATE TRIGGER `after_insert_finepayment` AFTER INSERT ON `fine_payments`
        FOR EACH ROW BEGIN
        UPDATE fines
        SET fines.fine_paid = fines.fine_paid+ NEW.finepay_amount
        WHERE NEW.finepay_fineid = fines.fine_id;
        END');
        DB::unprepared('CREATE TRIGGER `after_update_finepayment` AFTER UPDATE ON `fine_payments`
        FOR EACH ROW BEGIN
        UPDATE fines
        SET fines.fine_paid = fines.fine_paid + NEW.finepay_amount - OLD.finepay_amount
        WHERE NEW.finepay_fineid = fines.fine_id;
        END');
    }

}
