<?php

use Illuminate\Database\Migrations\Migration;

class CreateTriggersForSmsd extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::unprepared('
        CREATE TRIGGER inbox_timestamp BEFORE INSERT ON inbox
FOR EACH ROW
BEGIN
    IF NEW.ReceivingDateTime = "0000-00-00 00:00:00" THEN
        SET NEW.ReceivingDateTime = CURRENT_TIMESTAMP();
    END IF;
END');

        DB::unprepared('CREATE TRIGGER outbox_timestamp BEFORE INSERT ON outbox
FOR EACH ROW
BEGIN
    IF NEW.InsertIntoDB = "0000-00-00 00:00:00" THEN
        SET NEW.InsertIntoDB = CURRENT_TIMESTAMP();
    END IF;
    IF NEW.SendingDateTime = "0000-00-00 00:00:00" THEN
        SET NEW.SendingDateTime = CURRENT_TIMESTAMP();
    END IF;
    IF NEW.SendingTimeOut = "0000-00-00 00:00:00" THEN
        SET NEW.SendingTimeOut = CURRENT_TIMESTAMP();
    END IF;
END');

        DB::unprepared('CREATE TRIGGER phones_timestamp BEFORE INSERT ON phones
FOR EACH ROW
BEGIN
    IF NEW.InsertIntoDB = "0000-00-00 00:00:00" THEN
        SET NEW.InsertIntoDB = CURRENT_TIMESTAMP();
    END IF;
    IF NEW.TimeOut = "0000-00-00 00:00:00" THEN
        SET NEW.TimeOut = CURRENT_TIMESTAMP();
    END IF;
END');

        DB::unprepared('CREATE TRIGGER sentitems_timestamp BEFORE INSERT ON sentitems
FOR EACH ROW
BEGIN
    IF NEW.InsertIntoDB = "0000-00-00 00:00:00" THEN
        SET NEW.InsertIntoDB = CURRENT_TIMESTAMP();
    END IF;
    IF NEW.SendingDateTime = "0000-00-00 00:00:00" THEN
        SET NEW.SendingDateTime = CURRENT_TIMESTAMP();
    END IF;
END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() { {
            DB::unprepared('DROP TRIGGER `inbox_timestamp`');
            DB::unprepared('DROP TRIGGER `outbox_timestamp`');
            DB::unprepared('DROP TRIGGER `sentitems_timestamp`');
            DB::unprepared('DROP TRIGGER `inbox_timestamp`');
        }
    }

}
