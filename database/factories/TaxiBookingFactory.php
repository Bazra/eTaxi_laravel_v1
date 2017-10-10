<?php 

use Faker\Generator as Faker;

$factory->define(App\TaxiBooking::class, function (Faker $faker) {

	return [

		'taxiFareRate_id' => rand(1, 3),
		'driver_id' => rand(1, 5),
		'passenger_id' => rand(1, 10),
		'destinationLatitude' =>$faker->latitude,
        'destinationLongitude' => $faker->longitude,
		'status' => $faker->boolean ? "confirm":"cancel",
		'shareable'=>rand(0, 10),
	];
});

?>