<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('importir_product_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('price_type', ['FIX', 'RANGE', 'OTHERS'])->default('FIX');
            $table->decimal('price')->default(0);
            $table->decimal('weight')->default(0);
            $table->decimal('cogs')->default(0);
            $table->string('main_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('visit_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_image', function(Blueprint $table){
            $table->increments('id');
            $table->integer('product_id');
            $table->string('url');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_model', function(Blueprint $table){
            $table->increments('id');
            $table->integer('product_id');
            $table->string('key');
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('price_range', function(Blueprint $table){
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('start');
            $table->integer('end');
            $table->decimal('price');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('category', function(Blueprint $table){
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tag', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_category', function(Blueprint $table){
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('category_id');
        });

        Schema::create('product_tag', function(Blueprint $table){
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('tag_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
        Schema::dropIfExists('product_image');
        Schema::dropIfExists('product_model');
        Schema::dropIfExists('price_range');
        Schema::dropIfExists('category');
        Schema::dropIfExists('product_category');
        Schema::dropIfExists('product_tag');
    }
}
