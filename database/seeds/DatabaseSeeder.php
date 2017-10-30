<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //$this->call(DriversTableSeeder::class);
        //$this->call(PassengersTableSeeder::class);
        //$this->call(TaxiFareRatesTableSeeder::class);
        $this->call(TaxiBookingsTableSeeder::class);
    }
}
