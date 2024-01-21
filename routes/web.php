<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CDC\EventController;
use App\Http\Controllers\CDC\SliderController;
use App\Http\Controllers\CDC\NewsActivitiesController;
// use App\Http\Controllers\EventController;
use App\Http\Controllers\CDC\FrontendController;

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
Route::group(['middleware' => ['redirect_to_apps']], function () {
    Route::view('/','login')->name('home'); 
    Route::post('login', [LoginController::class, 'login']);   
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');



Route::group(['middleware' => ['logged_in']], function () {
    Route::get('/test', function () {
        return 'user';
    });
    Route::view('/app','app')->name('app');


    Route::prefix('cdc')->as('cdc.')->group(function () {
        Route::view('/dashboard','cdc.dashboard')->name('dashboard');
        Route::get('/event', [EventController::class, 'index'])->name('event');
        Route::get('/event_crate', [EventController::class, 'create'])->name('event.create'); 
        Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');

        Route::get('/slider', [SliderController::class, 'index'])->name('slider');
        Route::get('/slider_crate', [SliderController::class, 'create'])->name('slider.create'); 
        Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');

        Route::get('/news_activities', [NewsActivitiesController::class, 'index'])->name('news_activities');
        Route::get('/news_activities_crate', [NewsActivitiesController::class, 'create'])->name('news_activities.create'); 
        Route::get('/news_activities/{id}/edit', [NewsActivitiesController::class, 'edit'])->name('news_activities.edit');
    });

    Route::get('/event_list/{type}', [EventController::class, 'list'])->name('event.list');
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{id}', [EventController::class, 'findItem']);
    Route::post('/event/{id}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/event/{id}', [EventController::class, 'delete'])->name('event.delete');


    Route::get('/slider_list/{type}', [SliderController::class, 'list'])->name('slider.list');
    Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
    Route::get('/slider/{id}', [SliderController::class, 'findItem']);
    Route::post('/slider/{id}', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/slider/{id}', [SliderController::class, 'delete'])->name('slider.delete');

    Route::get('/news_activities_list/{type}', [NewsActivitiesController::class, 'list'])->name('news_activities.list');
    Route::post('/news_activities', [NewsActivitiesController::class, 'store'])->name('news_activities.store');
    Route::get('/news_activities/{id}', [NewsActivitiesController::class, 'findItem'])->name('news_activities.find');
    Route::post('/news_activities/{id}', [NewsActivitiesController::class, 'update'])->name('news_activities.update');
    Route::delete('/news_activities/{id}', [NewsActivitiesController::class, 'delete'])->name('news_activities.delete');

});




include __DIR__.'/cdc.php';
include __DIR__.'/rrc.php';
include __DIR__.'/yec.php';
