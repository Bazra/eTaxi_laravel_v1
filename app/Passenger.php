<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Passenger extends Authenticatable
{

	protected $guard = 'passenger';

	protected $fillable = [
        'name', 'email', 'password', 'mobileNumber', 'address', 'latitude', 'longitude',
    ];

    protected $hidden = [

    	'password', 'remeber_token',
    ];
	//public function acceptTaxiBooking() {
	//	return $this->hasOne(TaxiBooking::class/*'App\TaxiBooking', 'passenger_id'*/);
	//}



	public function save(array $options = []) {

        if(empty($this->api_token)) {

            $this->api_token = str_random(60);
        }

        return parent::save($options);
    }
}
