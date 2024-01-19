<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CDC\EventController;
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
        Route::get('/event_list', [EventController::class, 'list'])->name('event.list');
        Route::post('/event_store', [EventController::class, 'store'])->name('event.store');
        Route::get('/event_delete/{id}', [EventController::class, 'delete'])->name('event.delete');
    });

});




include __DIR__.'/cdc.php';
include __DIR__.'/rrc.php';
include __DIR__.'/yec.php';
