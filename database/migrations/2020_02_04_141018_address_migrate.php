<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddressMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cities', function(Blueprint $table){
            $table->increments('id');
            $table->integer('province_id');
            $table->string('name');
            $table->string('type');
            $table->integer('postal_code');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subdistricts', function(Blueprint $table){
            $table->increments('id');
            $table->integer('province_id');
            $table->integer('city_id');
            $table->string('name');
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
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('subdistricts');
    }
}
