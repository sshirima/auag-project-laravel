<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Fine;

class RemoveColumnAmountFines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Fine::$TABLENAME, function (Blueprint $table) {
           $table->dropColumn(Fine::$COL_AMOUNT);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Fine::$TABLENAME, function (Blueprint $table) {
             $table->double(Fine::$COL_AMOUNT);
        });
    }
}
