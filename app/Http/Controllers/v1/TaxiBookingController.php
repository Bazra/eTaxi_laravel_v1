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
    }


    public function index()
    {

        $data = $this->taxiBookings->getTaxiBookings();

        return response()->json($data);
    }



    public function store(Request $request)
    {
        
        $this->taxiBookings->validateTaxiBooking($request->all());
        try {

            $booking = $this->taxiBookings->createTaxiBooking($request);

            return response()->json($booking, 201);
        } catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

   
    public function show($id)
    {

        $data = $this->taxiBookings->getTaxiBooking($id);

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
}
