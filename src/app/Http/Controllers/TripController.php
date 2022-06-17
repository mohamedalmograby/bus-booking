<?php

namespace App\Http\Controllers;
use App\Models\Trip;
use App\Models\Reservation;

use Illuminate\Http\Request;

class TripController extends Controller
{
        
    public function index()
    {
        $trips = Trip::with('cities:id,name' , 'buses.seats' )->get();
        $bookingArray = [[]];
        foreach($trips as $trip){
            $bus = $trip->buses()->first();   // for simplicity, we assume there is only one bus per trip
            $citiesids = $trip->cities()->get()->pluck('id')->toArray();
            $reservation  = Reservation::where('trip_id' ,$trip->id)->get();
            foreach($reservation as $res){
                $seat = $res->seat()->first();
                $startCityId = $res->start_city_id;
                $endCityId = $res->end_city_id;
                for($i=array_search($startCityId,$citiesids);$i<=array_search($endCityId,$citiesids);$i++){
                    $bookingArray[$seat->id][$citiesids[$i]] = 1;
                }
            }
        }

        return view('trips.index', compact('trips','bookingArray'));
    }
}
