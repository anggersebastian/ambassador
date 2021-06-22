<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnJurnalUpdatedAtToTaleListBatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logistic_batch', function (Blueprint $table) {
            $table->timestamp('jurnal_updated_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logistic_batch', function (Blueprint $table) {
            $table->dropColumn('jurna_updated_at');
        });
    }
}
