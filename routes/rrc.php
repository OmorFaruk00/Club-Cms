<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RRC\EventController;
use App\Http\Controllers\RRC\SliderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['logged_in']], function () {  

    Route::prefix('rrc')->as('rrc.')->group(function () {
        Route::view('/dashboard','rrc.dashboard')->name('dashboard');
        Route::get('/event', [EventController::class, 'index'])->name('event');
        Route::get('/event_crate', [EventController::class, 'create'])->name('event.create'); 
        Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');

        Route::get('/slider', [SliderController::class, 'index'])->name('slider');
        Route::get('/slider_crate', [SliderController::class, 'create'])->name('slider.create'); 
        Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
    });

    

});

