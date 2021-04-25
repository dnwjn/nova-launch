<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Nova Launch Web Routes
|--------------------------------------------------------------------------
|
| The routes for Nova Launch's front.
|
*/

Route::get('/{secret}', 'BypassController@index')->name('bypass.index');

Route::get('/', 'VisitorController@index')->name('visitors.index');
Route::post('/', 'VisitorController@store')->name('visitors.store');
