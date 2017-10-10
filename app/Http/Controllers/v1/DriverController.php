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
        $this->middleware('auth:driver-api', ['except' => ['store', 'login']]);
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
        try {

            $driver = $this->drivers->createDriver($request);

            return response()->json($driver, 201);
        } catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {

        $data = $this->drivers->getDriver($id);

        return response()->json($data);
    }


    public function update(Request $request, $id)
    {
        
        $this->drivers->validateDriver($request->all());
        try {

            $driver = $this->drivers->updateDriver($request, $id);
            
            return response()->json($driver, 200);
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

        try {

            $driver = Driver::where('email', $email)->firstOrFail();

            if(Hash::check($password, $driver->password)) {
                
                return $driver->api_token;
            }

            return 'Invalid password';
        
        }catch(ModelNotFoundException $e) {

            return 'Invalid email';
        }
    }


}
