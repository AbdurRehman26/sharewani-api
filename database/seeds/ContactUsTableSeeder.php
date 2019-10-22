<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ContactUsTableSeeder extends Seeder
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
        		'name' => $faker->name,
        		'subject' => $faker->company,
        		'message' => $faker->realText(),
        		'user_id' => $key % 2 == 0 ? $user['id'] : null,
        		'email' => $key % 2 == 0 ? $user['email'] : $faker->email,
        		'created_at' => $date,
        		'updated_at' => $date,
        	];
            
        }

        \App\Data\Models\ContactUs::insert($input);
    	
    }
}
