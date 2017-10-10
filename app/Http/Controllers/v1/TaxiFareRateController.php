<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Services\v1\ETaxiService;

class TaxiFareRateController extends Controller
{

    protected $taxiFareRates;

    public function __construct(ETaxiService $service) {

        $this->taxiFareRates = $service;
    }
    
    public function index()
    {
        $data = $this->taxiFareRates->getTaxiFareRates();
        return response()->json($data);
    }


    public function show($id)
    {
        
        $data = $this->taxiFareRates->getTaxiFareRate($id);

        return response()->json($data);
    }
}
