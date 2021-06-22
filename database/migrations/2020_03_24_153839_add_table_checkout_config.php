<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableCheckoutConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_config', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_id');
            $table->text('dump')->nullalbel();
            $table->timestamps();
            $table->softDeletes();

        });
        Schema::create('product_cs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_id');
            $table->bigInteger('user_id');
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkout_config');
        Schema::dropIfExists('product_cs');
    }
}
