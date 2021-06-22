<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnJurnalUpdatedAtToLogisticOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_order', function (Blueprint $table) {
            $table->timestamp('jurnal_updated_at')->nullable()->after('pickup_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logistic_order', function($table) {
            $table->dropColumn('jurnal_updated_at');
         });
    }
}
