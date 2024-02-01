<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RRC\TeamController;
use App\Http\Controllers\RRC\AboutController;
use App\Http\Controllers\RRC\EventController;
use App\Http\Controllers\RRC\SliderController;
use App\Http\Controllers\RRC\NewsActivitiesController;

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

        Route::get('/slider', [SliderController::class, 'index'])->name('slider');
        Route::get('/slider_create', [SliderController::class, 'create'])->name('slider.create'); 
        Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');

        Route::get('/about', [AboutController::class, 'index'])->name('about');
        Route::get('/about_create', [AboutController::class, 'create'])->name('about.create'); 
        Route::get('/about/{id}/edit', [AboutController::class, 'edit'])->name('about.edit');

        Route::get('/event', [EventController::class, 'index'])->name('event');
        Route::get('/event_create', [EventController::class, 'create'])->name('event.create'); 
        Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');

        Route::get('/team', [TeamController::class, 'index'])->name('team');
        Route::get('/team_create', [TeamController::class, 'create'])->name('team.create'); 
        Route::get('/team/{id}/edit', [TeamController::class, 'edit'])->name('team.edit');

        Route::get('/news_activities', [NewsActivitiesController::class, 'index'])->name('news_activities');
        Route::get('/news_activities_crate', [NewsActivitiesController::class, 'create'])->name('news_activities.create'); 
        Route::get('/news_activities/{id}/edit', [NewsActivitiesController::class, 'edit'])->name('news_activities.edit');


    });
   




});





