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
        Route::get('/users/{username}/', 'username')->name('users.username');
    });
    Route::controller(\App\Http\Controllers\BookingController::class)->group(function() {
        Route::get('/bookings/', 'all')->name('booking.all');
        Route::delete('/booking/{booking}/delete', 'destroy')->name('booking.delete');
        Route::get('/booking/{company}/{service}/{month?}/{year?}/', 'index')->name('booking.default');
        Route::get('/booking/times/allday/{company}/{service}/{date}/{month}/{year}/{duration?}', 'allDayTimeSlots')->name('booking.times');
        Route::get('/booking/times/hasduration/{company}/{service}/{date}/{month}/{year}/{duration?}', 'hasDurationTimeSlots')->name('booking.times');
        Route::get('/booking/times/requiresduration/{company}/{service}/{date}/{month}/{year}/{duration?}', 'requiresDurationTimeSlots')->name('booking.times');
        Route::post('/booking/store/{company}/{service}/{duration?}', 'store')->name('booking.store');
    });

    Route::controller(\App\Http\Controllers\CompanyController::class)->group(function() {
        Route::get('/company', 'index')->name('companies.index');
        Route::get('/company/search', 'search')->name('companies.search');
        Route::get('/company/create', 'create')->name('companies.create');
        Route::post('/company', 'store')->name('companies.store');
        Route::get('/company/{company}/edit', 'edit')->name('companies.edit');
        Route::get('/company/{company}/show', 'show')->name('companies.show');
        Route::post('/company/{company}/user/{user}/assign', 'assignUser')->name('companies.assign');
    });
    Route::controller(\App\Http\Controllers\ServiceController::class)->group(function() {
        Route::get('/company/{company}/service/create', 'create')->name('services.create');
        Route::post('/company/{company}/service/store', 'store')->name('services.store');
        Route::get('/company/{company}/service', 'index')->name('companies.services');
    });


});


