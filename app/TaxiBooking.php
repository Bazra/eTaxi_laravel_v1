<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxiBooking extends Model
{
    public function driver() {
		return $this->belongsTo(Driver::class/*'App\Driver', 'driver_id'*/);
	}

	public function passenger() {
		return $this->belongsTo(Passenger::class/*'App\Passenger', 'passenger_id'*/);
	}

	public function taxiFareRate() {
		return $this->belongsTo(TaxiFareRate::class/*'App\TaxiFareRate', 'taxiFareRate_id'*/);
	}
}
