<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTrackingNumberToTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->string('tracking_number')->after('checkout_at')->nullable();
        });
        Schema::table('customer', function (Blueprint $table) {
            $table->string('province')->after('subdistrict_id')->nullable();
            $table->string('city')->after('province')->nullable();
            $table->string('district_name')->after('city')->nullable();
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
            $table->dropColumn('tracking_number');
        });

        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn('province');
            $table->dropColumn('city');
            $table->dropColumn('district_name');
        });
    }
}
