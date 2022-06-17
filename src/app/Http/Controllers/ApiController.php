<?php
namespace App\Http\Controllers;
use App\Models\Trip;
use App\Models\Seat;
use App\Models\Reservation;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\BookingService;

class ApiController extends Controller
{
    private $bookingService ;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function trips()
    {
        $trips = Trip::with('cities:id,name')->get();
        return response()->json($trips);
    }

    public function availableSeats(Request $request)
    {   
        $body = $request->all();
        $response = [
            'trips' => $this->bookingService->getAvailableSeats($body['start_city_id'], $body['end_city_id'])
        ];
        return response()->json($response);
    }

    public function makeReservation(Request $request)
    {
        $body = $request->all();

        $startCityId = $body['start_city_id'];
        $endCityId = $body['end_city_id'];
        $seatId = $body['seat_id'];
        $userId = Auth::user()->id;
        
        $seat = Seat::find($seatId);
        $bus = $seat->bus()->first();
        $trip = $bus->trip()->first();


        $reservation = Reservation::create([
            'start_city_id' => $startCityId,
            'end_city_id' => $endCityId,
            'seat_id' => $seatId,
            'user_id' => $userId,
            'trip_id' => $trip->id,
        ]);
        return response()->json($reservation);
    }
}
