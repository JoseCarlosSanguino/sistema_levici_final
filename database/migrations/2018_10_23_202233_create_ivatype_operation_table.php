<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvatypeOperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivatype_operation', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('ivatype_id')->unsigned();
            $table->integer('operation_id')->unsigned();
            $table->decimal('amount', 10,2);
            $table->foreign('ivatype_id')->references('id')->on('ivatypes');
            $table->foreign('operation_id')->references('id')->on('operations');
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
        Schema::dropIfExists('ivatype_operation');
    }
}
