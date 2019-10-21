<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ProductTableSeeder extends Seeder
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


        $sharewaniColors = [
            'White',
            'Tan',
            'Yellow',
            'Orange',
            'Red',
            'Pink',
            'Purple',
            'Blue',
        ];


        $userId = \App\Laravue\Models\User::first()['id'];

        $imagesArray = config('dummyImages');

        shuffle($imagesArray);

        $images = array_slice($imagesArray, 0, 3);


        foreach ($sharewaniColors as $key => $sharewani) {
 
           $data[] = [
                'title' => "$sharewani Sherwani",
                'description' => $faker->text,
                'user_id' => $userId,
                'images' => json_encode($images),
                'number_of_items' => 1,
                'original_price' => 1000,
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ];
 
        };
        
        \App\Data\Models\Product::insertOnDuplicateKey($data);

}
}
