<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTriggerBeforeInsertPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER `before_insert_shareoffer` BEFORE INSERT ON `share_offers`
 FOR EACH ROW BEGIN
IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
	SET NEW.created_at = CURRENT_TIMESTAMP();
    SET NEW.updated_at = CURRENT_TIMESTAMP();
END IF;

IF (NEW.offer_amount IS NULL || NEW.offer_amount = "") THEN
 SET NEW.offer_amount = NEW.offer_units * NEW.offer_price;
END IF;
IF (NEW.offer_units IS NULL || NEW.offer_units = "") THEN
 SET NEW.offer_units = NEW.offer_amount / NEW.offer_price;
END IF;
END');
         DB::unprepared('CREATE TRIGGER `before_insert_sharebid` BEFORE INSERT ON `share_bids`
 FOR EACH ROW BEGIN
IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
  SET NEW.created_at = CURRENT_TIMESTAMP();
  SET NEW.updated_at = CURRENT_TIMESTAMP();
END IF;
IF (NEW.bid_amount IS NULL || NEW.bid_amount = "") THEN
  SET NEW.bid_amount = NEW.bid_units * NEW.bid_price;
END IF;
 IF NOT (NEW.bid_units IS NULL || NEW.bid_units = "") THEN
  SET NEW.bid_units = NEW.bid_amount / NEW.bid_price;
END IF;
END');
         DB::unprepared('CREATE TRIGGER `before_insert_loanpayment` BEFORE INSERT ON `loan_payments`
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
    public function down()
    {
        DB::unprepared('DROP TRIGGER `before_insert_shareoffer`');
        DB::unprepared('DROP TRIGGER `before_update_sharebids`');
        DB::unprepared('DROP TRIGGER `before_insert_loanpayment`');
    }
}
