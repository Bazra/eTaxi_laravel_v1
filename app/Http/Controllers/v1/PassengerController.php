<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\v1\ETaxiService;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PassengerController extends Controller
{

    protected $passengers;

    public function __construct(ETaxiService $service) {

        $this->passengers = $service;
        $this->middleware('auth:passenger-api');
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
        try {

            $passenger = $this->passengers->createPassenger($request);

            return response()->json($passenger, 201);

        } catch(Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    
    public function show($id)
    {
        $data = $this->passengers->getPassenger($id);

        return response()->json($data);
    }

    

    public function update(Request $request, $id)
    {
       
        $this->passengers->validatePassenger($request->all());
        try {

            $passenger = $this->passengers->updatePassenger($request, $id);
            
            return response()->json($passenger, 200);
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

        try {

            $passenger = Passenger::where('email', $email)->firstOrFail();

            if(Hash::check($password, $passenger->password)) {
                
                return $passenger->api_token;
            }

            return 'Invalid password';
        
        }catch(ModelNotFoundException $e) {

            return 'Invalid email';
        }
    }

}
