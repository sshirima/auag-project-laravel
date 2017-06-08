<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboxMultipartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('outbox_multipart', function (Blueprint $table) {
            $table->engine = 'MyISAM'; //Done
            $table->charset = 'utf8'; //Done
            $table->collation = 'utf8_general_ci'; //Done
            $table->interger('Version')->default(-1);
            $table->string('Text')->nullable();
            $table->enum('Coding', ['Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression'])->default('Default_No_Compression');
            $table->text('UDH');
            $table->integer('Class');
            $table->text('TextDecoded')->default();
            $table->integer('ID');
            $table->increment('SequencePosition')->default(1);
            $table->primary(['ID', 'SequencePosition']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outbox_multipart');
    }
}
