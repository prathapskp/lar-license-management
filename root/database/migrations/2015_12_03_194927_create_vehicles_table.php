<?php

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
            $table->increments('id');
            $table->string('plate_number');
            $table->integer('vehicle_type_id');
            $table->integer('license_type_id');
            $table->string('registration_number');
            $table->string('owner_name');
            $table->string('owner_email');
            $table->string('owner_phone');
            $table->string('location');
            $table->string('chassis_number');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vehicles');
    }
}
