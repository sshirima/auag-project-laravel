<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Accounting\Group;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Group::$TABLENAME, function (Blueprint $table) {
            $table->increments(Group::$COL_ID);
            $table->string(Group::$COL_NAME);
            $table->double(Group::$COL_SHARE_UNIT_PRICE)->default(0);
            $table->unsignedInteger(Group::$COL_SHARE_MAX_OFFER)->default(0);
            $table->unsignedInteger(Group::$COL_SHARE_LOOP_DURATION)->default(0);
            $table->double(Group::$COL_LOAN_RATE)->default(0);
        });
        
        DB::table(Group::$TABLENAME)->insert(
            array(
                Group::$COL_NAME => 'Default-Groupname'
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Group::$TABLENAME);
    }
}
