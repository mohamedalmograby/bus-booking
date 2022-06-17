<?php
namespace App\Services;
use App\Models\Trip;
class TripService
{

    public function getTripsBetweenTwoCities($startCityId , $endCityId)
    {
        $trips = Trip::passThroughCities([$startCityId, $endCityId]);
        return $this->filterTripsByDirections($trips, $startCityId, $endCityId);
    }
    public function filterTripsByDirections($trips, $startCityId, $endCityId)
    {
        return $trips->filter(function ($trip) use ($startCityId, $endCityId) {
            $startCity = $trip->cities()->withPivot('order')->where('cities.id', $startCityId)->first();
            $endCity = $trip->cities()->withPivot('order')->where('cities.id', $endCityId)->first();
            return $startCity->pivot->order < $endCity->pivot->order;
        });
    }
}