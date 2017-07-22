<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Share;
use Modules\Accounting\ShareBid;
class CreateShareBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ShareBid::$TABLENAME, function (Blueprint $table) {
            $table->increments(ShareBid::$COL_ID);
            $table->unsignedInteger(ShareBid::$COL_SHARE_ID);
            $table->double(ShareBid::$COL_SHARE_UNIT);
            $table->double(ShareBid::$COL_SHARE_PRICE);
            $table->double(ShareBid::$COL_SHARE_AMOUNT);
            $table->timestamps();
            
            $table->foreign(ShareBid::$COL_SHARE_ID)->references(Share::$COL_ID)
                    ->on(Share::$TABLENAME)
                    ->onDelete('cascade');
        });
        
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `before_insert_sharebid`');
        DB::unprepared('DROP TRIGGER `before_update_sharebid`');
        DB::unprepared('DROP TRIGGER `after_insert_sharebid`');
        DB::unprepared('DROP TRIGGER `after_update_sharebid`');
        Schema::dropIfExists(ShareBid::$TABLENAME);
    }
}