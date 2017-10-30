<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\v1\ETaxiService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Passenger;
use Illuminate\Support\Facades\Hash;


class PassengerController extends Controller
{

    protected $passengers;

    public function __construct(ETaxiService $service) {

        $this->passengers = $service;
        $this->middleware('auth:passenger-api', ['except' => ['store', 'login', 'index']]);
    }



    public function testIndex()
    {
        return view('passenger');
    }
    


    public function index()
    {
        $data = $this->passengers->getPassengers();
        return response()->json($data);
    }
    

    public function store(Request $request)
    {
        
        $this->passengers->validatePassenger($request->all());
        $response = array();
        $response['success'] = false;

        try {

            $passenger = $this->passengers->createPassenger($request);

            $response['success'] = true;
            return response()->json($response, 201);

        } catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    
    public function show($email)
    {
        $data = $this->passengers->getPassenger($email);

        return response()->json($data);
    }

    

    public function update(Request $request, $email)
    {
       
        $this->passengers->validatePassenger($request->all());

        $response = array();
        $response['success'] = false;

        try {

            $passenger = $this->passengers->updatePassenger($request, $email);

            $response = array();
            $response['success'] = true;
            
            return response()->json($response, 200);
        }
        catch(ModelNotFoundException $mnfe) {

            throw $mnfe;
        } 
        catch(Exception $e) {

            return response()->json($response, 500);
        }
    }

   

    public function destroy($id)
    {
        
        try {

            $passenger = $this->passengers->deletePassenger($id);
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
        $response['address'] = "";
        $response['mobileNumber'] = "";


        try {

            $passenger = Passenger::where('email', $email)->firstOrFail();

            if(Hash::check($password, $passenger->password)) {

                $response['success'] = true;
                $response['api_token'] = $passenger->api_token;
                $response['name'] = $passenger->name;
                $response['email'] = $passenger->email;
                $response['address'] = $passenger->address;
                $response['mobileNumber'] = $passenger->mobileNumber;
                
                return response()->json($response, 200);
            }

            return response()->json($response, 500);
        
        }catch(ModelNotFoundException $e) {

            return response()->json($response, 500);
        }
    }
}
