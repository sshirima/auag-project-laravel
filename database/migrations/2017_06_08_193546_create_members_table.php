<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname', 25);
            $table->string('lastname', 25);
            $table->string('phonenumber', 20);
            $table->timestamps();
            $table->rememberToken();
        });
        
        DB::unprepared('CREATE TRIGGER `before_insert_member` BEFORE INSERT ON `members`
        FOR EACH ROW 
        IF (NEW.created_at IS NULL || NEW.updated_at IS NULL) THEN
            SET NEW.created_at = CURRENT_TIMESTAMP();
            SET NEW.updated_at = CURRENT_TIMESTAMP();
        END IF');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `before_insert_member`');
        Schema::dropIfExists('members');
    }
}
