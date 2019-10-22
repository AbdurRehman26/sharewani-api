<?php

use Illuminate\Database\Seeder;
use App\Laravue\Acl;
use App\Laravue\Models\Role;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     
        $faker = Faker::create();
   
        $userList = [
            "Kazmi",
            "Ali",
            "Talmeez",
            "Arsal",
            "Nabeel",
            "Mohtashim",
        ];


        $admin = \App\Laravue\Models\User::create([
            'name' => 'Admin',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'admin@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
            'image' => $faker->imageUrl(300, 450, 'people')
            
        ]);
        $manager = \App\Laravue\Models\User::create([
            'name' => 'Manager',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'manager@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
            'image' => $faker->imageUrl(300, 450, 'people')
            
        ]);
        $editor = \App\Laravue\Models\User::create([
            'name' => 'Editor',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'editor@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
            'image' => $faker->imageUrl(300, 450, 'people')
            
        ]);
        $user = \App\Laravue\Models\User::create([
            'name' => 'User',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'user@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
            'image' => $faker->imageUrl(300, 450, 'people')
            
        ]);
        $visitor = \App\Laravue\Models\User::create([
            'name' => 'Visitor',
            'phone_number' => mt_rand(100000, 999999),
            'email' => 'visitor@sharewani.com',
            'password' => Hash::make('sharewani123!@#'),
            'image' => $faker->imageUrl(300, 450, 'people') 
        ]);


        foreach ($userList as $fullName) {
            $name = str_replace(' ', '.', $fullName);
            $user = \App\Laravue\Models\User::create([
                'name' => $fullName,
                'phone_number' => mt_rand(100000, 999999),
                'email' => strtolower($name) . '@sharewaani.com',
                'password' => \Illuminate\Support\Facades\Hash::make('sharewaani123!@#'),
                'image' => $faker->imageUrl(300, 450, 'people')
            ]);

        }
    }
}
