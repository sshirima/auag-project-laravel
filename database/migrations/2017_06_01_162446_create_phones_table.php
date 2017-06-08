<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhonesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('phones', function (Blueprint $table) {
            $table->engine = 'MyISAM';//Done
            $table->charset = 'utf8';//Done
            $table->collation = 'utf8_general_ci';//Done
            $table->text('ID'); //Done
            $table->timestamp('UpdatedInDB')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));//Done
            $table->timestamp('InsertIntoDB')->nullable();//Done
            $table->timestamp('TimeOut')->nullable();//Done
            $table->enum('Send', ['yes', 'no'])->default('no'); //Done
            $table->enum('Receive', ['yes', 'no'])->default('no'); //Done
            $table->string('IMEI', 35);
            $table->text('Client');
            $table->integer('Battery')->default(-1); //Done
            $table->integer('Signal')->default(-1); //Done
            $table->integer('Sent')->default(0); //Done
            $table->integer('Received')->default(0); //Done
            $table->primary('IMEI'); //Done
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('phones');
    }

}
