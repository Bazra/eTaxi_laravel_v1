<?php 

use Faker\Generator as Faker;

$factory->define(App\TaxiBooking::class, function (Faker $faker) {

	return [

		'taxiFareRate_id' => rand(1, 3),
		'driver_id' => rand(1, 5),
		'passenger_id' => rand(1, 10),
		'sourceLatitude' =>$faker->latitude,
        'sourceLongitude' => $faker->longitude,
		'destinationLatitude' =>$faker->latitude,
        'destinationLongitude' => $faker->longitude,
		'status' => $faker->boolean ? "confirm":"cancel",
		'amount' => rand(100, 1000),
		'shareable'=>rand(0, 10),
	];
});

?>