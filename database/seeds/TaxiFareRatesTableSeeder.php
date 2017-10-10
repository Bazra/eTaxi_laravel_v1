<?php

use Illuminate\Database\Seeder;

class TaxiFareRatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory (App\TaxiFareRate::class, 3)->create();
    }
}
