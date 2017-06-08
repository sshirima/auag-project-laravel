<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox', function (Blueprint $table) {
            $table->engine = 'MyISAM';//Done
            $table->charset = 'utf8';//Done
            $table->collation = 'utf8_general_ci';//Done
            $table->timestamp('UpdatedInDB')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));//Done
            $table->timestamp('ReceivingDateTime')->nullable();//Done
            $table->text('Text'); //Done
            $table->string('SenderNumber', 20)->default('');
            $table->enum('Coding', ['Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression'])->default('Default_No_Compression'); //Done
            $table->text('UDH'); //Done
            $table->string('SMSCNumber', 20)->default(''); //Done
            $table->interger('Class')->default(-1);
            $table->text('TextDecoded')->default('');
            $table->increments('ID'); //Done
            $table->text('RecipientID'); //Done
            $table->enum('Processed',['false','true'])->default('false'); //Done
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inbox');
    }
}
