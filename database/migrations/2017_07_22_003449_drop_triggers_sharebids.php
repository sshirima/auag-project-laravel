<?php

use Illuminate\Database\Migrations\Migration;

class DropTriggersSharebids extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::unprepared('DROP TRIGGER `before_update_sharebids`');
        DB::unprepared('DROP TRIGGER `after_insert_sharebid`');
        DB::unprepared('DROP TRIGGER `after_update_sharebid`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {


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

        DB::unprepared('CREATE TRIGGER `after_insert_sharebid` AFTER INSERT ON `share_bids`
 FOR EACH ROW BEGIN
UPDATE shares
SET shares.share_amount = shares.share_amount - NEW.bid_amount, 
shares.share_units = shares.share_units - NEW.bid_units
WHERE NEW.bid_shareid = shares.share_id;
END');

        DB::unprepared('CREATE TRIGGER `after_update_sharebid` AFTER UPDATE ON `share_bids`
 FOR EACH ROW BEGIN
UPDATE shares
SET shares.share_amount = shares.share_amount + OLD.bid_amount, 
shares.share_units = shares.share_units + OLD.bid_units
WHERE NEW.bid_id = shares.share_id;

UPDATE shares
SET shares.share_amount = shares.share_amount - NEW.bid_amount, 
shares.share_units = shares.share_units - NEW.bid_units
WHERE NEW.bid_id = shares.share_id;
END');
        DB::unprepared('CREATE TRIGGER `before_update_sharebids` BEFORE UPDATE ON `share_bids`
 FOR EACH ROW BEGIN
IF (NEW.updated_at IS NULL) THEN
    SET NEW.updated_at = CURRENT_TIMESTAMP();
END IF;

IF (NEW.bid_amount IS NULL || NEW.bid_amount = "") THEN
 SET NEW.bid_amount = NEW.bid_units * NEW.bid_price;
END IF;

IF (NEW.bid_units IS NULL || NEW.bid_units = "") THEN
 SET NEW.bid_units = NEW.bid_amount / NEW.bid_price;
END IF;

IF NOT (NEW.bid_amount = OLD.bid_amount) THEN
  SET NEW.bid_units = NEW.bid_amount / NEW.bid_price;
 ELSEIF NOT (NEW.bid_units = OLD.bid_units) THEN
 SET NEW.bid_amount = NEW.bid_units * NEW.bid_price;
END IF;
END');
    }

}
