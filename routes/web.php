<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::middleware('guest')->group(function() {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login');
});
Route::middleware('auth')->group(function() {
    Route::get('/', function() {
        return \Inertia\Inertia::render('Home');
    });
    Route::get('/home', function() {
        return Inertia::render('Home');
    })->name('home');

    Route::post('/logout', [LoginController::class, 'logout']);

    Route::controller(\App\Http\Controllers\UserController::class)->group(function() {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::post('/users', 'store')->name('users.store');
    });
    Route::controller(\App\Http\Controllers\BookingController::class)->group(function() {
        Route::get('/bookings/', 'all')->name('booking.all');
        Route::get('/booking/{company}/{service}/{month?}/{year?}', 'index')->name('booking.default');
        Route::get('/booking/times/{company}/{service}/{date}/{month}/{year}', 'timeSlots')->name('booking.times');
        Route::post('/booking/store/{company}/{service}/', 'store')->name('booking.store');
    });

    Route::controller(\App\Http\Controllers\CompanyController::class)->group(function() {
        Route::get('/company', 'index')->name('companies.index');
        Route::get('/company/create', 'create')->name('companies.create');
        Route::post('/company', 'store')->name('companies.store');
        Route::get('/company/{company}/edit', 'edit')->name('companies.edit');
    });
    Route::controller(\App\Http\Controllers\ServiceController::class)->group(function() {
        Route::get('/company/{company}/service/create', 'create')->name('services.create');
        Route::post('/company/{company}/service/store', 'store')->name('services.store');
        Route::get('/company/{company}/service', 'index')->name('companies.services');
    });


});


