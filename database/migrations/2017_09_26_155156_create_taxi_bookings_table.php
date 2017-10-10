<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxiBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxi_bookings', function (Blueprint $table) {
            
            $table->increments('id');

            $table->integer('taxiFareRate_id')->unsigned();
            $table->foreign('taxiFareRate_id')
                    ->references('id')
                    ->on('taxi_fare_rates')
                    ->onDelete('cascade');
            $table->integer('driver_id')->unsigned();
            $table->foreign('driver_id')
                    ->references('id')
                    ->on('drivers')
                    ->onDelete('cascade');
            $table->integer('passenger_id')->unsigned();
            $table->foreign('passenger_id')
                    ->references('id')
                    ->on('passengers')
                    ->onDelete('cascade');
            $table->decimal('destinationLatitude', 8, 6);
            $table->decimal('destinationLongitude', 9, 6);
            $table->string('status');
            $table->integer('shareable')->unsigned()->nullable();
            
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
        Schema::dropIfExists('taxi_bookings');
    }
}
