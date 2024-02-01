<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CacheClearController;
use App\Http\Controllers\CDC\AboutController;
use App\Http\Controllers\CDC\EventController;
use App\Http\Controllers\CDC\NewsActivitiesController;
use App\Http\Controllers\CDC\SliderController;
use App\Http\Controllers\CDC\TeamController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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
Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    return response()->json(['message' => 'Cache Clear Successfully'], 200);
});
Route::group(['middleware' => ['redirect_to_apps']], function () {
    Route::view('/', 'login')->name('home');
    Route::post('auth/login', [AuthController::class, 'authenticate']);
});

Route::group(['middleware' => ['logged_in']], function () {
    Route::view('/app', 'app')->name('app');
    Route::view('setting/dashboard', 'setting.dashboard')->name('setting.dashboard');
    Route::get('/setting/role_permission', [RolePermissionController::class, 'rolePermission'])->name('setting.role_permission');
    Route::get('/setting/special_permission', [RolePermissionController::class, 'specialPermission'])->name('setting.special_permission');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/setting/cache_clear', [CacheClearController::class, 'cacheClear'])->name('setting.cache_clear');
    Route::get('/setting/role_create', [RoleController::class, 'createRole'])->name('setting.role_create');

    Route::get('setting/user', [UserController::class, 'user'])->name('setting.user_index');
    Route::get('setting/user_create', [UserController::class, 'create'])->name('setting.user_create');
    Route::get('setting/user/edit/{id}', [UserController::class, 'userEdit'])->name('setting.user_edit');
});

Route::middleware('token.auth')->group(function () {
    Route::middleware('CommonAccessMiddleware')->group(function () {

        Route::get('/slider_list/{type}', [SliderController::class, 'list'])->name('slider.list');
        Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/slider/{id}', [SliderController::class, 'findItem'])->name('slider.show');
        Route::post('/slider/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/slider/{id}', [SliderController::class, 'delete'])->name('slider.delete');

        Route::get('/about_list/{type}', [AboutController::class, 'list'])->name('about.list');
        Route::post('/about', [AboutController::class, 'store'])->name('about.store');
        Route::get('/about/{id}', [AboutController::class, 'show'])->name('about.show');
        Route::post('/about/{id}', [AboutController::class, 'update'])->name('about.update');
        Route::delete('/about/{id}', [AboutController::class, 'delete'])->name('about.delete');

        Route::get('/event_list/{type}', [EventController::class, 'list'])->name('event.list');
        Route::post('/event', [EventController::class, 'store'])->name('event.store');
        Route::get('/event/{id}', [EventController::class, 'findItem'])->name('event.show');
        Route::post('/event/{id}', [EventController::class, 'update'])->name('event.update');
        Route::delete('/event/{id}', [EventController::class, 'delete'])->name('event.delete');

        Route::get('/team_list/{type}', [TeamController::class, 'list'])->name('team.list');
        Route::post('/team', [TeamController::class, 'store'])->name('team.store');
        Route::get('/team/{id}', [TeamController::class, 'findItem'])->name('team.show');
        Route::post('/team/{id}', [TeamController::class, 'update'])->name('team.update');
        Route::delete('/team/{id}', [TeamController::class, 'delete'])->name('team.delete');

        Route::get('/news_activities_list/{type}', [NewsActivitiesController::class, 'list'])->name('news_activities.list');
        Route::post('/news_activities', [NewsActivitiesController::class, 'store'])->name('news_activities.store');
        Route::get('/news_activities/{id}', [NewsActivitiesController::class, 'findItem'])->name('news_activities.find');
        Route::post('/news_activities/{id}', [NewsActivitiesController::class, 'update'])->name('news_activities.update');
        Route::delete('/news_activities/{id}', [NewsActivitiesController::class, 'delete'])->name('news_activities.delete');

        Route::resource('setting/role', RoleController::class);

        Route::post('assign_role_module', [RolePermissionController::class, 'assign_role_module_store'])->name('setting.assign_role_module');
        Route::post('assign_module_permission', [RolePermissionController::class, 'assign_special_permission_store'])->name('setting.assign_module_permission');
        Route::get('permission/role/{id}', [RolePermissionController::class, 'role'])->name('setting.role');
        Route::get('permission/user/{id}', [RolePermissionController::class, 'user'])->name('setting.user');

        Route::resource('user', UserController::class)->names([
            'index' => 'user.index',
            'store' => 'user.store',
            'show' => 'user.show',
            'update' => 'user.update',
            'destroy' => 'user.destroy']);

        // Route::get('/user', [UserController::class,'userList'])->name('user.list');
        // Route::get('/user/{id}', [UserController::class,'show'])->name('user.show');
        // Route::post('user/store', [UserController::class,'store'])->name('user.store');
        // Route::put('/user/update/{id}', [UserController::class,'update'])->name('user.update');
        // Route::delete('user/{id}', [UserController::class,'destroy'])->name('user.delete');

    });
});

include __DIR__ . '/cdc.php';
include __DIR__ . '/rrc.php';
include __DIR__ . '/yec.php';
