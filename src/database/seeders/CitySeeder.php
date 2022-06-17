<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 30; $i++) {
            City::create([
                'name' => $faker->city,
            ]);
        }
    }
}
