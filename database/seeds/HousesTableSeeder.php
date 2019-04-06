<?php

use Illuminate\Database\Seeder;

class HousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = \App\Http\Controllers\Utility\CsvController::importToArray('data/property-data.csv'); // data array from csv file
        \App\House::insert($data);
    }
}
