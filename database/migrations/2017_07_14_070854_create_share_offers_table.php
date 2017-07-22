<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Share;
use Modules\Accounting\ShareOffer;
class CreateShareOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ShareOffer::$TABLENAME, function (Blueprint $table) {
            $table->increments(ShareOffer::$COL_ID);
            $table->unsignedInteger(ShareOffer::$COL_SHARE_ID);
            $table->double(ShareOffer::$COL_SHARE_UNIT);
            $table->double(ShareOffer::$COL_SHARE_PRICE);
            $table->double(ShareOffer::$COL_SHARE_AMOUNT);
            $table->timestamps();
            
            $table->foreign(ShareOffer::$COL_SHARE_ID)->references(Share::$COL_ID)
                    ->on(Share::$TABLENAME)
                    ->onDelete('cascade');
        });
        
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `before_insert_shareoffer`');
        DB::unprepared('DROP TRIGGER `before_update_shareoffer`');
        DB::unprepared('DROP TRIGGER `after_insert_shareoffer`');
        DB::unprepared('DROP TRIGGER `after_update_shareoffer`');
        Schema::dropIfExists(ShareOffer::$TABLENAME);
    }
}
