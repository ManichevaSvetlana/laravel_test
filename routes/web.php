<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    dd(\App\Http\Controllers\Utility\CsvController::importToArray('data/property-data.csv'));


    /*$collection = [];
    $file = Storage::get('data/property-data.csv');
    $data = explode ( "\r\n" , $file);
    $rows = explode ( "," , array_shift ($data));
    dd($rows);
    foreach ($data as $row)
    {
        $cells = explode ( "," , $row);
        $fillableRow = [];
        foreach ($cells as $k => $cell)
        {
            $fillableRow[$rows[$k]] = $cell;
        }
        array_push($collection, $fillableRow);
    }
    dd(collect($collection));*/
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
