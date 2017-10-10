<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{

	protected $guard = 'driver';

	protected $fillable = [
        'name', 'email', 'password', 'mobileNumber', 'licenseNumber', 'taxiNumber', 'address', 'latitude', 'longitude', 'status',
    ];

    protected $hidden = [

    	'password', 'remeber_token',
    ];

	//public function acceptTaxiBooking() {
	//	return $this->hasMany(/*TaxiBooking::class*/'App\TaxiBooking', 'driver_id');
	//}


	    public function save(array $options = []) {

        if(empty($this->api_token)) {

            $this->api_token = str_random(60);
        }

        return parent::save($options);
    }
}
