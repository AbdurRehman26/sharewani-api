<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $date = Carbon::now()->toDateTimeString();

        for($i = 0; $i < 20; $i++){


        $data[] = [

            'name' => ucwords($faker->safeColorName()),
            'code' => $faker->safeHexColor(),
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => NULL

        ];




        }

        \App\Data\Models\Color::insertOnDuplicateKey($data, ['name']);

    }
}
