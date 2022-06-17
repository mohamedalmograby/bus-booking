<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $hidden = ['pivot' , 'created_at' , "updated_at"];

    function cities()
    {
        return $this->belongsToMany(City::class)->orderBy('order');
    }

    function buses(){
        return $this->hasMany(Bus::class);
    }

    static function passThroughCities($citiesIds){
        foreach ($citiesIds as $key => $cityId) {
            if ($key == 0) {
                $trips = Trip::whereHas('cities', function ($query) use ($cityId) {
                    $query->where('cities.id', $cityId);
                });
            } else {
                $trips = $trips->whereHas('cities', function ($query) use ($cityId) {
                    $query->where('cities.id', $cityId);
                });
            }
        }
        return $trips->get();
    }
}
