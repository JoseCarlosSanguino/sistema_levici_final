<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('producttype_id');
            $table->unsignedSmallInteger('ivatype_id');
            $table->unsignedSmallInteger('unittype_id');
            $table->unsignedInteger('trademark_id')->nullable();
            $table->string('code',32)->unique();
            $table->string('product',64);
            $table->string('description',255);
            $table->string('image',255);
            $table->string('position',255);
            $table->decimal('min_stock',10,2)->default(0);
            $table->decimal('max_stock',10,2)->default(99999);
            $table->decimal('stock',10,2);
            $table->decimal('last_cost',10,2)->nullable();
            $table->decimal('cost',10,2)->nullable();
            $table->decimal('last_price',10,2)->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('producttype_id')->references('id')->on('producttypes');
            $table->foreign('ivatype_id')->references('id')->on('ivatypes');
            $table->foreign('unittype_id')->references('id')->on('unittypes');
            $table->foreign('trademark_id')->references('id')->on('trademarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
