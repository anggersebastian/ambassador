<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFacebookReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_report', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('product_id');
            $table->date('report_date');
            $table->decimal('ad_spent', 12, 2)->default(0);
            $table->integer('view_content');
            $table->integer('add_to_cart');
            $table->integer('initiate_checkout');
            $table->integer('lead');
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
        Schema::dropIfExists('facebook_report');
    }
}
