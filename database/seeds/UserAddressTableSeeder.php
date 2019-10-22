<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        $date = \Carbon\Carbon::now()->toDateTimeString();

        $users = \App\Data\Models\User::all();

        foreach ($users as $key => $user) {

        	$input[] = [
        		'address' => $faker->address,
        		'address_secondary' => $faker->streetAddress(),
        		'nearest_check_point' => $faker->streetName(),
        		'user_id' => $user['id'],
        		'city_id' => 1,
        		'created_at' => $date,
        		'updated_at' => $date,
        	];
            
        }

        \App\Data\Models\UserAddress::insert($input);

    }
}
