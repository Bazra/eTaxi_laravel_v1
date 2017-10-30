<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\v1\ETaxiService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Driver;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{

    protected $drivers;

    public function __construct(ETaxiService $service) {

        $this->drivers = $service;
        $this->middleware('auth:driver-api', ['except' => ['store', 'login', 'freeDrivers']]);
    }    


    public function testIndex()
    {
        return view('driver');
    }


    public function index()
    {
        
        $data = $this->drivers->getDrivers();

        return response()->json($data);
    }


    public function store(Request $request)
    {
        
        $this->drivers->validateDriver($request->all());
        $response = array();
        $response['success'] = false;
        try {

            $driver = $this->drivers->createDriver($request);
            $response['success'] = true;
            return response()->json($response, 201);

        } catch(Exception $e) {

            return response()->json($response, 500);
        }
    }


    public function show($id)
    {

        $data = $this->drivers->getDriver($id);

        return response()->json($data);
    }


    public function update(Request $request, $email)
    {
        
        $this->drivers->validateDriver($request->all());
        $response['success'] = false;
        try {

            $driver = $this->drivers->updateDriver($request, $email);
            $response['success'] = true;
            
            return response()->json($response, 200);
        }
        catch(ModelNotFoundException $mnfe) {

            throw $mnfe;
        } 
        catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        
        try {

            $driver = $this->drivers->deleteDriver($id);
            return response()->make('', 204);
        }
        catch(ModelNotFoundException $mnfe) {

            throw $mnfe;
        } 
        catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function login(Request $request) {

        $email = $request->input('email');
        $password = $request->input('password');
        // $response = array();
        // $response[]
        $response = array();
        $response['success'] = false;
        $response['name'] = "";
        $response['email'] = "";
        $response['api_token'] = "";
        $response['mobileNumber'] = "";
        $response['taxiNumber'] = "";
        $response['licenseNumber'] = "";
        $response['address'] = "";

        try {

            $driver = Driver::where('email', $email)->firstOrFail();

            if(Hash::check($password, $driver->password)) {

                $response['success'] = true;
                $response['api_token'] = $driver->api_token;
                $response['name'] = $driver->name;
                $response['email'] = $driver->email;
                $response['mobileNumber'] = $driver->mobileNumber;
                $response['taxiNumber'] = $driver->taxiNumber;
                $response['licenseNumber'] = $driver->licenseNumber;
                $response['address'] = $driver->address;

                
                return response()->json($response, 200);
            }

            return response()->json($response, 500);
        
        }catch(ModelNotFoundException $e) {

            return response()->json($response, 500);
        }
    }

    public function freeDrivers() {

        $data = $this->drivers->getFreeDrivers();
        return response()->json($data);
    }
}
