<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\Bus;
use App\Models\Seat;
use App\Models\City;

use Illuminate\Database\Seeder;

class TripBusAndSeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $trip =Trip::create([
                'name' => 'temporary name',
            ]);

            $bus =Bus::create([
                'driver_name' => $faker->name,
                'trip_id' => $trip->id,
            ]);
            for($o = 0 ;$o < 12 ; $o++){
                Seat::create([
                    'bus_id' => $bus->id,
                ]);
            }

            $routeLenght = $faker->numberBetween(1, 30);
            $citiesIds = range(1, 30) ;
            shuffle($citiesIds);
            for($o = 0 ; $o <= $routeLenght ; $o++){
                $trip->cities()->attach($citiesIds[$o] , ['order' => $o]);
            }
            $trip->name = City::find($citiesIds[0])->name . ' - ' . City::find($citiesIds[$routeLenght])->name . ' Trip';
            $trip->save();
        }
    }
}
