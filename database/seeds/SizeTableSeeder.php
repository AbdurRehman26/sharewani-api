<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SizeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = Carbon::now()->toDateTimeString();

        $sizes = [
            'Small',
            'Medium',
            'Large',
            'Extra Large (XL)',
            'Extra Extra Large (XXL)',
            'Extra Extra Extra Large (XXXL)'
        ];

        $data = [];

        foreach ($sizes as $size){

            $data[] = [

                'name' => $size,
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL

            ];

        }

        \App\Data\Models\Size::insertOnDuplicateKey($data, ['name']);



    }
}
