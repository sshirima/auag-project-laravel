<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Modules\Accounting\Fine;
use Modules\Accounting\FinePayment;

class CreateFinePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(FinePayment::$TABLENAME, function (Blueprint $table) {
            $table->increments(FinePayment::$COL_ID);
            $table->unsignedInteger(FinePayment::$COL_FINE_ID);
            $table->double(FinePayment::$COL_AMOUNT);
            $table->timestamps();
            
            $table->foreign(FinePayment::$COL_FINE_ID)->references(Fine::$COL_ID)
                    ->on(Fine::$TABLENAME)
                    ->onDelete('cascade');
        });
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `before_insert_finepayment`');
        DB::unprepared('DROP TRIGGER `after_insert_finepayment`');
        DB::unprepared('DROP TRIGGER `after_update_finepayment`');
        Schema::dropIfExists(FinePayment::$TABLENAME);
    }
}
