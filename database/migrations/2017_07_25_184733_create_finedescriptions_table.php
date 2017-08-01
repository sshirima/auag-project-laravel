<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Fine;
use Modules\Accounting\FineDescription;

class CreateFinedescriptionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(FineDescription::$TABLENAME, function (Blueprint $table) {
            $table->increments(FineDescription::$COL_ID);
            $table->string(FineDescription::$COL_DESCRIPTION);
            $table->double(FineDescription::$COL_AMOUNT);
            $table->timestamps();
        });

        Schema::table(Fine::$TABLENAME, function (Blueprint $table) {
            $table->dropColumn(Fine::$COL_DESCRIPTION);
        });
        
        Schema::table(Fine::$TABLENAME, function (Blueprint $table) {
            $table->unsignedInteger(Fine::$COL_DESCRIPTION);
            
            $table->foreign(Fine::$COL_DESCRIPTION)
                    ->references(FineDescription::$COL_ID)
                    ->on(FineDescription::$TABLENAME)
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        
        Schema::table(Fine::$TABLENAME, function (Blueprint $table) {
            $table->dropForeign('fines_fine_description_foreign');
            
            $table->dropColumn(Fine::$COL_DESCRIPTION);
        });
        Schema::table(Fine::$TABLENAME, function (Blueprint $table) {
            $table->string(Fine::$COL_DESCRIPTION)->default('NO_DESCRIPTION')->change();
        });
        
        Schema::dropIfExists(FineDescription::$TABLENAME);
    }

}
