<?php

namespace App\Http\Controllers;

use App\Services\FlightScraperService;
use Illuminate\Http\JsonResponse;

class FlightController extends Controller
{
    public function __construct(
        private FlightScraperService $flightScraperService
    ) {}

    public function index()
    {
        return view('flights.index');
    }

    /**
     * Fetch flights from tiket.com via web scraping
     */
    public function fetch(): JsonResponse
    {
        $result = $this->flightScraperService->fetchFlights();

        return response()->json($result);
    }
}
