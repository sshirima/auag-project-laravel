<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Transaction;
use Modules\Accounting\Account;

class CreateTableTransctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Transaction::$TABLENAME, function (Blueprint $table) {
            $table->increments(Transaction::$COL_ID);
            $table->unsignedInteger(Transaction::$COL_CATEGORY_REF);
            $table->unsignedInteger(Transaction::$COL_REFERENCE);
            $table->string(Transaction::$COL_DESCRIPTION)->default('NO_DESCRIPTION');
            $table->double(Transaction::$COL_AMOUNT);
            $table->string(Transaction::$COL_CURRENCY,10)->default('TZH');
            $table->enum(Transaction::$COL_TYPE, ['WITHDRAW', 'DEPOSIT']);
            $table->enum(Transaction::$COL_CATEGORY, ['SHARES', 'FINES','LOANS','CONTRIBUTIONS']);
            $table->timestamps();
        });
        
        DB::unprepared('DROP TRIGGER `after_insert_shareoffer`');
        DB::unprepared('DROP TRIGGER `after_update_shareoffer`');
        DB::unprepared('CREATE TRIGGER `after_insert_shareoffer` AFTER INSERT ON `share_offers`
 FOR EACH ROW BEGIN
  UPDATE shares
  SET shares.share_amount = shares.share_amount + NEW.offer_amount, 
  shares.share_units = shares.share_units + NEW.offer_units
  WHERE NEW.offer_shareid = shares.share_id;
  
  INSERT INTO transactions (trans_cat_ref,trans_reference,trans_amount, trans_type,trans_category, trans_description) 
  VALUES  (NEW.offer_shareid, NEW.offer_id,NEW.offer_amount,"DEPOSIT","SHARES", "Bought shares");
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
 
 UPDATE transactions
 SET transactions.trans_amount =  NEW.offer_amount
 WHERE (transactions.trans_cat_ref = NEW.offer_shareid) AND
 (transactions.trans_reference = NEW.offer_id) AND
 (transactions.trans_type = "DEPOSIT") AND 
 (transactions.trans_category = "SHARES");
END');
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists(Transaction::$TABLENAME);
        DB::unprepared('DROP TRIGGER `after_insert_shareoffer`');
        DB::unprepared('DROP TRIGGER `after_update_shareoffer`');
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
        
        DB::unprepared('CREATE TRIGGER `after_insert_shareoffer` AFTER INSERT ON `share_offers`
 FOR EACH ROW BEGIN
  UPDATE shares
  SET shares.share_amount = shares.share_amount + NEW.offer_amount, 
  shares.share_units = shares.share_units + NEW.offer_units
  WHERE NEW.offer_shareid = share_id;
END');
    }
}
