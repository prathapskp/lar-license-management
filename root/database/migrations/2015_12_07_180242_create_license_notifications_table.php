<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('license_type_id')->unsigned()->index();
            $table->foreign('license_type_id')->references('id')->on('license_types')->onDelete('cascade');
            $table->integer('vehicle_id')->unsigned()->index();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->integer('sent_to');//user_id
            $table->dateTime('sent_on');
            $table->text('message');
            $table->string('type', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('license_notifications');
    }
}
