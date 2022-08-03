<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBinStatusOnFlowrateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flowrates', function (Blueprint $table) {
            $table->string('bin_alarm', 15)->after('alarm')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flowrates', function (Blueprint $table) {
            $table->dropColumn('bin_alarm');
        });
    }
}
