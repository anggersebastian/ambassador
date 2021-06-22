<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReanmeOrderReadby extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_read_by', function (Blueprint $table) {
            $table->timestamp('is_read')->nullable()->after('admin_id');
        });

        Schema::rename('order_read_by', 'order_notification');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('order_read_by', function (Blueprint $table) {
        //     //
        // });
    }
}
