<?php 

use Faker\Generator as Faker;
    
$factory->define(App\Driver::class, function (Faker $faker) {

        static $password;

	return [

	'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'mobileNumber' => $faker->phoneNumber,
        'licenseNumber' => $faker->numerify('lic#####'), 
        'taxiNumber' => $faker->numerify('ga#pa ####'), 
        'address' => $faker->address,
        'latitude' =>$faker->latitude,
        'longitude' => $faker->longitude,
        'status' => $faker->boolean ? "free":"busy",
        'remember_token' => str_random(60),
	];
});

?>