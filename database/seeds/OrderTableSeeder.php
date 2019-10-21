<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class OrderTableSeeder extends Seeder
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
        $toDate = Carbon::now()->addDays(3)->toDateTimeString();


        for($i=0; $i<50; $i++){

        $userId = \App\Laravue\Models\User::inRandomOrder()->first()['id'];
		    $productId = \App\Data\Models\Product::inRandomOrder()->first()['id'];

        $data[] = [
            'product_id' => $productId,	
            'user_id' => $userId,
            'from_date' => $date,
            'to_date' => $toDate,
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => NULL
        ];

        }

        
        \App\Data\Models\Order::insertOnDuplicateKey($data);


}
}
