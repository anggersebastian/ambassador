<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->nullable();
            $table->string('token')->nullable();
            $table->string('invoice_number')->unique();
            $table->decimal('product_price');
            $table->string('shipping_type');
            $table->decimal('shipping_fee')->default(0);
            $table->decimal('cod_fee')->default(0);
            $table->decimal('total_price')->default(0);
            $table->decimal('total_weight')->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->string('paid_with')->nullable();
            $table->timestamp('checkout_at')->nullable();
            $table->timestamp('process_at')->nullable();
            $table->timestamp('shipping_at')->nullable();
            $table->timestamp('done_at')->nullable();
            $table->timestamp('cancel_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('customer', function(Blueprint $table){
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('subdistrict_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_detail', function(Blueprint $table){
            $table->increments('id');
            $table->string('token')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('product_id');
            $table->integer('product_model_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('price')->default(0);
            $table->decimal('weight')->default(0);
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
        Schema::dropIfExists('order');
        Schema::dropIfExists('customer');
        Schema::dropIfExists('order_detail');
    }
}
