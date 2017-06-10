<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePbkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pbk', function (Blueprint $table) {
            $table->engine = 'MyISAM'; //Done
            $table->charset = 'utf8'; //Done
            $table->collation = 'utf8_general_ci'; //Done
            $table->increments('ID');
            $table->integer('GroupID')->default(-1);
            $table->text('Name');
            $table->text('Number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pbk');
    }
}
