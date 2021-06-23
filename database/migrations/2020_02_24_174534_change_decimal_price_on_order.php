<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\{DB, Log};


class ChangeDecimalPriceOnOrder extends Migration
{
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->decimal('total_price', 12, 2)->change();
            $table->decimal('cod_fee', 12, 2)->change();
            $table->decimal('unique_fee', 12, 2)->change();
            $table->decimal('shipping_fee', 12, 2)->change();
            $table->decimal('product_price', 12, 2)->change();
        });

        Schema::table('product', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
            $table->decimal('cogs', 12, 2)->change();
        });
        Schema::table('price_range', function (Blueprint $table) {
            $table->decimal('price', 12, 2)->change();
        });
        Schema::table('payment_confirmation', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
}