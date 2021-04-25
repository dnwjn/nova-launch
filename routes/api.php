<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Nova Launch API Routes
|--------------------------------------------------------------------------
|
| The routes for Nova Launch's API.
|
*/

Route::get('/form', 'LaunchController@edit')->name('form.edit');
Route::post('/form', 'LaunchController@update')->name('form.update');

Route::post('/launch', 'LaunchController@launch')->name('launch');
