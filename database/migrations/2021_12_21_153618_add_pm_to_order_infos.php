<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPmToOrderInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_infos', function (Blueprint $table) {
            //
            $table->string('pm')->default('paypal')->after('porder_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_infos', function (Blueprint $table) {
            //
            $table->dropColumn('pm');
        });
    }
}
