<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('operationtype_id');
            $table->unsignedSmallInteger('status_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('number',32);
            $table->timestamp('date_of');
            $table->decimal('amount',10,2)->default(0);
            $table->decimal('discount',10,2)->default(0);
            $table->text('observation');
            $table->unique(['operationtype_id','number'],'operationtype_number');
            $table->foreign('operationtype_id')->references('id')->on('operationtypes');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('operations');
    }
}
