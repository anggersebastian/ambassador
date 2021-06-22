<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMyshortcart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myshortcart', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('order_id');
            $table->string('transidmerchant');
            $table->string('status');
            $table->timestamp('starttime')->nullable();
            $table->decimal('totalamount', 12, 2)->default(0);
            $table->string('trxtype')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_log_payment', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('order_id');
            $table->text('dump')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('order', function (Blueprint $table) {
            $table->string('paid_by')->nullable()->after('paid_with');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('myshortcart');
        Schema::dropIfExists('order_log_payment');
        Schema::table('order', function (Blueprint $table) {
            $table->dropColumn('paid_by');
        });
    }
}
