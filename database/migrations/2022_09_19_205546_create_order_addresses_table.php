<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('order_no');
            $table->string('pp_order_no');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address_name');
            $table->string('address_country_code');
            $table->string('address_country');
            $table->string('address_state');
            $table->string('address_city');
            $table->string('address_street');
            $table->string('address_zip');
            $table->string('payer_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_addresses');
    }
}
