<?php 

namespace App\Services\v1;

use Validator;
use App\Driver;
use App\Passenger;
use App\TaxiBooking;
use App\TaxiFareRate;

class ETaxiService {


	protected $driverRules = [
		'name' => 'required',
		'email' => 'required',
		'password' => 'required',
		'mobileNumber' => 'required',
		'licenseNumber' => 'required',
		'taxiNumber' => 'required',
		'address' => 'required',
		'latitude' => 'required',
		'longitude' => 'required',
		'status' => 'required',
	];

	public function validateDriver($driver) {

		$validator = Validator::make($driver, $this->driverRules);
		$validator->validate();
	}

	public function getDrivers() {


 		return $this->filterDrivers(Driver::all());
 	}

 	public function getDriver($id) {

 		return $this->filterDrivers(Driver::where('id', $id)->get());
 	}

 	public function createDriver($request) {

		$driver = new Driver();
		$driver->name = $request->input('name');
		$driver->email = $request->input('email');
		$driver->password = bcrypt($request->input('password'));
		$driver->mobileNumber = $request->input('mobileNumber');
		$driver->licenseNumber = $request->input('licenseNumber');
		$driver->taxiNumber = $request->input('taxiNumber');
		$driver->address = $request->input('address');
		$driver->latitude = $request->input('latitude');
		$driver->longitude = $request->input('longitude');
		$driver->status = $request->input('status');

		$driver->save();
		return 'Driver Registered';
	}

	public function updateDriver($req, $id) {

		$driver = Driver::where('id', $id)->firstOrFail();
		$driver->name = $req->input('name');
		$driver->email = $req->input('email');
		$driver->password = bcrypt($req->input('password'));
		$driver->mobileNumber = $req->input('mobileNumber');
		$driver->licenseNumber = $req->input('licenseNumber');
		$driver->taxiNumber = $req->input('taxiNumber');
		$driver->address = $req->input('address');
		$driver->latitude = $req->input('latitude');
		$driver->longitude = $req->input('longitude');
		$driver->status = $req->input('status');

		$driver->save();
		return 'Driver '.$driver->name.' is updated successfully';
		//return $this->filterDrivers([$driver]);
	}

	public function deleteDriver($id) {

		$driver = Driver::where('id', $id)->firstOrFail();
		$name = $driver->name;
		$driver->delete();
		return 'Driver '.$name.' deleted successfully';
	}

	public function filterDrivers($drivers) {

		$data = [];

		foreach($drivers as $driver) {

			$entry = [

				'driver_id_href' => route('drivers.show', ['id' => $driver->id]),
				'name' => $driver->name,
				'email' => $driver->email,
				'mobileNumber' => $driver->mobileNumber,
				'licenseNumber' => $driver->licenseNumber,
				'taxiNumber' => $driver->taxiNumber,
				'address' => $driver->address,
				'latitude' => $driver->latitude,
				'longitude' => $driver->longitude,
				'status' => $driver->status
			];

			$data[] = $entry;
		}

		return $data;
	}




	protected $passengerRules = [
		'name' => 'required',
		'email' => 'required',
		'password' => 'required',
		'mobileNumber' => 'required',
		'address' => 'required',
		'latitude' => 'required',
		'longitude' => 'required',
	];

	public function validatePassenger($passenger) {

		$validator = Validator::make($passenger, $this->passengerRules);
		$validator->validate();
	}


 	public function getPassengers() {

 		return $this->filterPassengers(Passenger::all());
 	}

 	public function getPassenger($id) {

 		return $this->filterPassengers(Passenger::where('id', $id)->get());
 	}

 	public function createPassenger($request) {

		$passenger = new Passenger();
		$passenger->name = $request->input('name');
		$passenger->email = $request->input('email');
		$passenger->password = bcrypt($request->input('password'));
		$passenger->mobileNumber = $request->input('mobileNumber');
		$passenger->address = $request->input('address');
		$passenger->latitude = $request->input('latitude');
		$passenger->longitude = $request->input('longitude');

		$passenger->save();
		return 'Passenger Registered';
	}

	public function updatePassenger($req, $id) {

		$passenger = Passenger::where('id', $id)->firstOrFail();
		$passenger->name = $req->input('name');
		$passenger->email = $req->input('email');
		$passenger->password = bcrypt($req->input('password'));
		$passenger->mobileNumber = $req->input('mobileNumber');
		$passenger->address = $req->input('address');
		$passenger->latitude = $req->input('latitude');
		$passenger->longitude = $req->input('longitude');

		$passenger->save();
		return 'Passenger '.$passenger->name.' is updated successfully';
	}

	public function deletePassenger($id) {

		$passenger = Passenger::where('id', $id)->firstOrFail();
		$name = $passenger->name;
		$passenger->delete();
		return 'Passenger '.$name.' deleted successfully';
	}

	public function filterPassengers($passengers) {

		$data = [];

		foreach($passengers as $passenger) {

			$entry = [

				'passenger_id_href' => route('passengers.show', ['id' => $passenger->id]),
				'name' => $passenger->name,
				'email' => $passenger->email,
				'mobileNumber' => $passenger->mobileNumber,
				'address' => $passenger->address,
				'latitude' => $passenger->latitude,
				'longitude' => $passenger->longitude,
			];

			$data[] = $entry;
		}

		return $data;
	}





 	public function getTaxiFareRates() {

 		return TaxiFareRate::all();
 	}

 	public function getTaxiFareRate($id) {

 		return $this->filterTaxiFareRate(TaxiFareRate::where('id', $id)->get());
 	}

	public function filterTaxiFareRate($rates) {

		$data = [];

		foreach($rates as $taxiRate) {

			$entry = [

				'taxiFareRate_id_href' => route('taxi_fare_rates.show', ['id' => $taxiRate->id]),
            	'roadType' => $taxiRate->roadType,
            	'rate' => $taxiRate->rate
			];

			$data[] = $entry;
		}

		return $data;
	}




	protected $taxiBookingRules = [
		'rate_id' => 'required',
		'driver_id' => 'required',
		'passenger_id' => 'required',
		'latitude' => 'required',
		'longitude' => 'required',
	];

	public function validateTaxiBooking($booking) {

		$validator = Validator::make($booking, $this->taxiBookingRules);
		$validator->validate();
	}

 	public function getTaxiBookings() {

 		return TaxiBooking::all();
 	}

 	public function getTaxiBooking($id) {

 		return TaxiBooking::where('id', $id)->get();
 	}

 	public function createTaxiBooking($request) {

		$booking = new TaxiBooking();
		$booking->taxiFareRate_id = $request->input('rate_id');
		$booking->driver_id = $request->input('driver_id');
		$booking->passenger_id = $request->input('passenger_id');
		$booking->destinationLatitude = $request->input('latitude');
		$booking->destinationLongitude = $request->input('longitude');
		$booking->status = $request->input('status');
		$booking->shareable = $request->input('shareable');

		$booking->save();
		return 'Taxi Booking Done';
	}

	public function updateTaxiBooking($request, $id) {

		$booking = TaxiBooking::where('id', $id)->firstOrFail();

		$booking->taxiFareRate_id = $request->input('rate_id');
		$booking->driver_id = $request->input('driver_id');
		$booking->passenger_id = $request->input('passenger_id');
		$booking->destinationLatitude = $request->input('latitude');
		$booking->destinationLongitude = $request->input('longitude');
		$booking->status = $request->input('status');
		$booking->shareable = $request->input('shareable');
		$booking->save();
		return 'Booking ID '.$booking->id.' is updated successfully';
	}

	public function deleteTaxiBooking($id) {

		$booking = TaxiBooking::where('id', $id)->firstOrFail();
		$id = $booking->id;
		$booking->delete();
		return 'Taxi Booking ID '.$id.' deleted successfully';
	}
}

?>