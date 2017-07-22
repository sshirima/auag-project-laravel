<?php

use Illuminate\Database\Migrations\Migration;

class DropTriggersShareoffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       DB::unprepared('DROP TRIGGER `before_insert_shareoffer`');
        DB::unprepared('DROP TRIGGER `before_update_shareoffer`');
        DB::unprepared('DROP TRIGGER `after_insert_shareoffer`');
        DB::unprepared('DROP TRIGGER `after_update_shareoffer`');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
        
        DB::unprepared('CREATE TRIGGER `after_insert_shareoffer` AFTER INSERT ON `share_offers`
 FOR EACH ROW BEGIN
  UPDATE shares
  SET shares.share_amount = shares.share_amount + NEW.offer_amount, 
  shares.share_units = shares.share_units + NEW.offer_units
  WHERE NEW.offer_shareid = share_id;
END');
        
        DB::unprepared('CREATE TRIGGER `after_update_shareoffer` AFTER UPDATE ON `share_offers`
 FOR EACH ROW BEGIN
 UPDATE shares
 SET shares.share_amount = shares.share_amount - OLD.offer_amount, 
 shares.share_units = shares.share_units - OLD.offer_units
 WHERE OLD.offer_shareid = share_id;

 UPDATE shares
 SET shares.share_amount = shares.share_amount + NEW.offer_amount, 
 shares.share_units = shares.share_units + NEW.offer_units
 WHERE OLD.offer_shareid = share_id;
END');
        
        DB::unprepared('CREATE TRIGGER `before_update_shareoffer` BEFORE UPDATE ON `share_offers`
 FOR EACH ROW BEGIN
IF (NEW.updated_at IS NULL) THEN
    SET NEW.updated_at = CURRENT_TIMESTAMP();
END IF;

IF (NEW.offer_amount IS NULL || NEW.offer_amount = "") THEN
 SET NEW.offer_amount = NEW.offer_units * NEW.offer_price;
END IF;

IF (NEW.offer_units IS NULL || NEW.offer_units = "") THEN
 SET NEW.offer_units = NEW.offer_amount / NEW.offer_price;
END IF;

IF NOT (NEW.offer_amount = OLD.offer_amount) THEN
  SET NEW.offer_units = NEW.offer_amount / NEW.offer_price;
 ELSEIF NOT (NEW.offer_units = OLD.offer_units) THEN
 SET NEW.offer_amount = NEW.offer_units * NEW.offer_price;
END IF;

END');
    }
}
