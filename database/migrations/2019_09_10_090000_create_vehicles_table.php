<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('license_plate')->unique();
            $table->integer('year_of_purchase')->index();
            $table->unsignedBigInteger('owner_id')->index();
            $table->string('color');
            $table->unsignedInteger('fuel_type_id')->index();
            $table->unsignedInteger('transmission_type_id');
            $table->unsignedInteger('vehicle_model_id')->index();
            $table->integer('seats');
            $table->integer('doors');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('owners');
            $table->foreign('fuel_type_id')->references('id')->on('fuel_types');
            $table->foreign('transmission_type_id')->references('id')->on('transmission_types');
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
