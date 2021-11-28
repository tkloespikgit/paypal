<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_infos', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('porder_no')->nullable()->comment('paypal 订单号');
            $table->string('email');
            $table->string('name');
            $table->decimal('total_amount',10,2);
            $table->decimal('discount_amount',10,2);
            $table->tinyInteger('status')->default(0)->comment('订单状态');
            $table->string('express')->nullable()->comment('快递公司');
            $table->string('express_no')->nullable()->comment('快递单号');
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
        Schema::dropIfExists('order_infos');
    }
}
