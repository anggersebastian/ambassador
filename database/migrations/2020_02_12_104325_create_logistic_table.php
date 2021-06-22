<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogisticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistic_batch', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->date('request_date');
            $table->string('created_by');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('logistic_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('batch_token')->nullable();
            $table->integer('logistic_batch_id');
            $table->string('order_id')->unique();
            $table->string('product_name');
            $table->integer('quantity');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('full_address');
            $table->string('province');
            $table->string('city');
            $table->string('subdistrict');
            $table->string('zip');

            $table->string('payment_status');
            $table->string('payment_method');
            $table->string('bump');
            $table->string('bump_price');
            $table->string('discount');
            $table->string('product_price');
            $table->string('cogs');

            $table->string('courier');
            $table->string('logistic_status')->default('');
            $table->string('shipping_cost');
            $table->string('cod_cost');
            $table->string('gross_revenue');
            $table->string('net_revenue');

            $table->dateTime('order_created_at');
            $table->dateTime('order_processed_at');
            $table->string('handled_by');

            $table->string('coupon');
            $table->string('utm_campaign');
            $table->string('utm_medium');
            $table->string('utm_source');
            $table->string('utm_content');
            $table->string('utm_term');
            $table->string('tags');

            $table->string('comments');
            $table->string('variation');

            $table->string('receipt_number');
            $table->string('pickup_address');

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
        //
    }
}
