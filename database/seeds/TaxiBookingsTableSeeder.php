<?php

use Illuminate\Database\Seeder;

class TaxiBookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory (App\TaxiBooking::class, 5)->create();
    }
}
