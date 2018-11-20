<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('ivacondition_id');
            $table->unsignedSmallInteger('province_id');
            $table->unsignedSmallInteger('city_id');
            $table->unsignedSmallInteger('persontype_id');
            $table->foreign('ivacondition_id')->references('id')->on('ivaconditions');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('persontype_id')->references('id')->on('persontypes');
            $table->string('cuit',15)->unique();
            $table->string('provider', 32)->default('');
            $table->string('address',255)->default('');
            $table->string('telephone', 64)->default('');
            $table->string('web',128)->default('');
            $table->decimal('markup', 10,2)->default(0);
            $table->unsignedTinyInteger('current_account')->default(0);
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
        Schema::drop('persons');
    }
}
