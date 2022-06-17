<?php
namespace App\Services;
use App\Services\TripService;
use DB;
use App\Models\Seat;

class BookingService
{
    private $tripService;
    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }
    
    public function getAvailableSeats($startCityId , $endCityId)
    {
        
        $trips = $this->tripService->getTripsBetweenTwoCities($startCityId , $endCityId);
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
        return $trips;
    }

}