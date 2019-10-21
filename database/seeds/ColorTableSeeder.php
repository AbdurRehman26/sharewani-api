<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ColorTableSeeder extends Seeder
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

            'name' => 'Red',
            'created_at' => $date,
            'updated_at' => $date,
            'deleted_at' => NULL

        ];

        \App\Data\Models\Color::insertOnDuplicateKey($data, ['name']);

    }
}
