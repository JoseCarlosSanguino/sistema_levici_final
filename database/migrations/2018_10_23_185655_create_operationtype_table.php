<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationtypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operationtypes', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('operationtype',32);
            $table->unsignedTinyInteger('is_fiscal')->default(0);
            $table->unsignedTinyInteger('stock_affected')->default(1);
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
        Schema::dropIfExists('operationtypes');
    }
}
