<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboxTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('outbox', function (Blueprint $table) {
            $table->engine = 'MyISAM'; //Done
            $table->charset = 'utf8'; //Done
            $table->collation = 'utf8_general_ci'; //Done
            $table->timestamp('UpdatedInDB')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')); //Done
            $table->timestamp('InsertIntoDB')->nullable(); //Done
            $table->timestamp('SendingDateTime')->nullable(); //Done
            $table->time('SendBefore')->default('23:59:59'); //Done
            $table->time('SendAfter')->default('00:00:00'); //Done
            $table->text('Text')->nullable(); //Done
            $table->string('DestinationNumber', 20)->default('');
            $table->enum('Coding', ['Default_No_Compression', 'Unicode_No_Compression', '8bit', 'Default_Compression', 'Unicode_Compression'])->default('Default_No_Compression'); //Done
            $table->text('UDH')->nullable(); //Done
            $table->integer('Class')->default(-1)->nullable();
            $table->text('TextDecoded');
            $table->increments('ID'); //Done
            $table->enum('MultiPart', ['false', 'true'])->default('false')->nullable(); //Done
            $table->integer('RelativeValidity')->default(-1)->nullable(); //Done
            $table->string('SenderID', 255)->nullable(); //Done
            $table->timestamp('SendingTimeOut')->nullable(); //Done
            $table->enum('DeliveryReport', ['default','yes','no'])->default('default')->nullable(); //Done
            $table->text('CreatorID'); //Done
            //Create indexes
            $table->index(['SendingDateTime','SendingTimeOut'], 'outbox_date');
            $table->index('SenderID', 'outbox_sender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('outbox');
    }

}
