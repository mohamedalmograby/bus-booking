<?php
namespace App\Http\Controllers;
use App\Models\Trip;
use App\Models\Seat;
use App\Models\Reservation;
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function trips()
    {
        $trips = Trip::with('cities:id,name')->get();
        return response()->json($trips);
    }

    public function availableSeats(Request $request)
    {   
        $body = $request->all();

        $startCityId = $body['start_city_id'];
        $endCityId = $body['end_city_id'];

        $trips = Trip::whereHas('cities', function ($query) use ($startCityId) {
            $query->where('cities.id', $startCityId);
        })->whereHas('cities', function ($query) use ($endCityId) {
            $query->where('cities.id', $endCityId);
        })->get();

        $trips = $trips->filter(function ($trip) use ($startCityId, $endCityId) {
            $startCity = $trip->cities()->withPivot('order')->where('cities.id', $startCityId)->first();
            $endCity = $trip->cities()->withPivot('order')->where('cities.id', $endCityId)->first();
            return $startCity->pivot->order < $endCity->pivot->order;
        })->values();

        foreach ($trips as $trip) {
            foreach($trip->buses as $bus){
            
                $startCityOrder = $trip->cities()->withPivot('order')->where('cities.id', $startCityId)->first()->pivot->order;
                $endCityOrder = $trip->cities()->withPivot('order')->where('cities.id', $endCityId)->first()->pivot->order;
                
                $busySeatsIds = DB::table('reservations')->where('reservations.trip_id', $trip->id)->
                join('city_trip as sC', function($join){
                    $join->on('reservations.start_city_id', '=', 'sC.city_id');
                    $join->on('sC.trip_id', '=', 'reservations.trip_id');
                })->
                join('city_trip as eC', function($join) {
                    $join->on('reservations.end_city_id', '=', 'eC.city_id');
                    $join->on('eC.trip_id', '=', 'reservations.trip_id');
                })->
                where(function($query) use($startCityOrder,$endCityOrder){
                    $query->
                    where(function($query) use($startCityOrder,$endCityOrder){
                        $query->where('sC.order', '<=', $endCityOrder);
                        $query->where('sC.order', '>=', $startCityOrder);
                    })->
                    orWhere(function($query) use($startCityOrder,$endCityOrder){
                        $query->where('eC.order', '<=', $endCityOrder);
                        $query->where('eC.order', '>=', $startCityOrder);
                    })->
                    orWhere(function($query) use($startCityOrder,$endCityOrder){
                        $query->where('sC.order', '<=', $startCityOrder);
                        $query->where('eC.order', '>=', $endCityOrder);
                    });
                })->pluck('reservations.seat_id')->unique()->toArray();
                
                $freeSeats = Seat::where('bus_id' , $bus->id)->whereNotIn('id', $busySeatsIds)->get();
                $bus['free_seats_ids'] = $freeSeats->pluck('id');
                unset($bus['trip_id']);
            }
        }
        return response()->json($trips);
    }

    public function makeReservation(Request $request)
    {
        $body = $request->all();

        $startCityId = $body['start_city_id'];
        $endCityId = $body['end_city_id'];
        $seatId = $body['seat_id'];
        $userId = $body['user_id'];
        
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
