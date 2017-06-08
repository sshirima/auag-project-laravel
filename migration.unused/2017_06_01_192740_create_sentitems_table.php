<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentitems', function (Blueprint $table) {
            $table->engine = 'MyISAM'; //Done
            $table->charset = 'utf8'; //Done
            $table->collation = 'utf8_general_ci'; //Done
            $table->timestamp('UpdatedInDB')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')); //Done
            $table->timestamp('InsertIntoDB')->nullable(); //Done
            $table->timestamp('SendingDateTime')->nullable(); //Done
            $table->text('Text'); //Done
            $table->string('DestinationNumber', 20)->default('');
            $table->enum('Coding', ['Default_No_Compression', 'Unicode_No_Compression', '8bit', 'Default_Compression', 'Unicode_Compression'])->default('Default_No_Compression'); //Done
            $table->text('UDH'); //Done
            $table->string('SMSCNumber',20)->default(''); //Done
            $table->interger('Class')->default(-1);
            $table->text('TextDecoded')->default('');
            $table->increments('ID'); //Done
            $table->string('SenderID', 255); //Done
            $table->integer('SequencePosition')->default(1); //Done
            $table->enum('Status', ['SendingOK','SendingOKNoReport','SendingError','DeliveryOK','DeliveryFailed','DeliveryPending','DeliveryUnknown','Error'])->default('SendingOK'); //Done
            $table->integer('StatusError')->default(-1); //Done
            $table->integer('TPMR')->default(-1); //Done
            $table->integer('RelativeValidity')->default(-1); //Done
            $table->text('CreatorID'); //Done
            //Create indexes
            $table->index('DeliveryDateTime', 'sentitems_date');
            $table->index('TPMR', 'sentitems_tpmr');
            $table->index('DestinationNumber', 'sentitems_dest');
            $table->index('SenderID', 'sentitems_sender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sentitems');
    }
}
