<?php 

use Faker\Generator as Faker;

$factory->define(App\Passenger::class, function (Faker $faker) {

	static $password;

	return [

		'name' => $faker->name,
	    'email' => $faker->unique()->safeEmail,
	    'password' => $password ?: $password = bcrypt('secret'),
	    'mobileNumber' => $faker->phoneNumber, 
	    'address' => $faker->address,
	    'latitude' =>$faker->latitude,
        'longitude' => $faker->longitude,
	    'remember_token' => str_random(60),
	];
});

?>