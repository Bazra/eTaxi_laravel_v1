<?php 

use Faker\Generator as Faker;
    
$factory->define(App\TaxiFareRate::class, function (Faker $faker) {

	$roadType = array ('Highway','City Road','Off Road');
	$rate = array (17, 26, 30);

	return [

	       'roadType' => $faker->unique()->randomElement($roadType),
            'rate' => $faker->unique()->randomElement($rate),
        ];
});

?>