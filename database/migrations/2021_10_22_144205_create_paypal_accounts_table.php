<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_name')->comment('账户名称');
            $table->string('account_email')->comment('账户邮箱');
            $table->text('account_html')->comment('账户付款网页');
            $table->integer('status')->comment('账户状态 0-停用 1-启用 2-禁用');
            $table->integer('last_resp')->comment('上次使用时间');
            $table->decimal('balance')->comment('余额')->default(0);
            $table->string('currency')->comment('币种')->default('USD');
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
        Schema::dropIfExists('paypal_accounts');
    }
}
