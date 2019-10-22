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
            [
            'code' => 's',
            'name' => 'Small'
            ],
            [
            'code' => 'm',
            'name' => 'Medium'
            ],
            [
            'code' => 'l',
            'name' => 'Large'
            ],
            [
            'code' => 'xl',
            'name' => 'Extra Large'
            ],
            [
            'code' => 'xxl',
            'name' => 'Extra Extra Large'
            ],
            [
            'code' => 'xxxl',
            'name' => 'Extra Extra Extra Large'
            ],
            ];

        $data = [];

        foreach ($sizes as $size){

            $data[] = [
                'name' => $size['name'],
                'code' => $size['code'],
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL

            ];

        }

        \App\Data\Models\Size::insertOnDuplicateKey($data, ['name']);



    }
}
