<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToLandingProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('landing_product', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->after('id');
            $table->text('css_content')->nullable()->after('html_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('landing_product', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('css_content');
        });
    }
}
