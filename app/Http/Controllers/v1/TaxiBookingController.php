<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\v1\ETaxiService;
use App\Http\Requests;

class TaxiBookingController extends Controller
{

    protected $taxiBookings;

    public function __construct(ETaxiService $service) {

        $this->taxiBookings = $service;
        $this->middleware('auth:passenger-api'/*, ['except'=>['show']]*/);
    }


    public function index()
    {

        $data = $this->taxiBookings->getTaxiBookings();

        return response()->json($data);
    }



    public function store(Request $request)
    {
        
        $this->taxiBookings->validateTaxiBooking($request->all());
        $response = array();
        $response['success'] = false;
        try {

            $booking = $this->taxiBookings->createTaxiBooking($request);
            $response['success'] = true;
            return response()->json($response, 201);
        } catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

   
    public function show($passengerEmail)
    {

        $data = $this->taxiBookings->getTaxiBooking($passengerEmail);

        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
               
        $this->taxiBookings->validateTaxiBooking($request->all());
        try {

            $booking = $this->taxiBookings->updateTaxiBooking($request, $id);
            
            return response()->json($booking, 200);
        }
        catch(ModelNotFoundException $mnfe) {

            throw $mnfe;
        } 
        catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try {

            $booking = $this->bookings->deleteTaxiBooking($id);
            return response()->make('', 204);
        }
        catch(ModelNotFoundException $mnfe) {

            throw $mnfe;
        } 
        catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function history(Request $request) {

        $passengerEmail = $request->input('passengerEmail');

        $response = $this->taxiBookings->getTaxiBooking($passengerEmail);

        return response()->json($response);


        // $response['success'] = false;
        // $response['date'] = "";
        // $response['sourceLatitude'] = "";
        // $response['sourceLongitude'] = "";
        // $response['destinationLatitude'] = "";
        // $response['destinationLongitude'] = "";
        // $response['amount'] = "";

        // try {

        //     $passenger = Passenger::where('email', $passengerEmail)->firstOrFail();

        //     $booking = TaxiBooking::where('passenger_id', $passenger->id)->get();

        //     $response['success'] = true;
        //     $response['api_token'] = $passenger->api_token;
        //     $response['name'] = $passenger->name;
        //     $response['email'] = $passenger->email;
                
        //     return response()->json($response, 200);
        //     }

        //     return response()->json($response, 500);
        // }catch(ModelNotFoundException $e) {

        //     return response()->json($response, 500);
        // }
    }
}
