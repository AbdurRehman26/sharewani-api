<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FabricAgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = Carbon::now()->toDateTimeString();


        $data = [
            [
                'name' => 'New',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ],
            [
                'name' => 'Less than 6 months',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ],
            [
                'name' => 'Between 6 and 12 months',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ],
            [
                'name' => 'Between 12 and 18 months',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ],
            [
                'name' => 'Between 18 and 24 months',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ],
            [
                'name' => 'Between 24 and 30 months',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ],
            [
                'name' => 'Between 30 and 36 months',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ],
            [
                'name' => 'Older than 36 months',
                'created_at' => $date,
                'updated_at' => $date,
                'deleted_at' => NULL
            ],
        ];


        \App\Data\Models\FabricAge::insertOnDuplicateKey($data, ['name']);


    }
}
