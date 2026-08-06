<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AmenitiesController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\Weather;
use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\Admin;

Route::get('/', [HotelController::class, 'index']);

Route::get('/hotels', [HotelController::class, 'index'])->name('hotels');
Route::get('/hotel_show/{id}', [HotelController::class, 'show'])->name('hotel');
Route::get('/hotel/{id}', [HotelController::class, 'show_update'])->name('show_update');
Route::post('/hotel_store', [HotelController::class, 'store'])->middleware('admin')->name('hotel_store');
Route::post('/hotel_update/{id}', [HotelController::class, 'update'])->middleware('admin')->name('hotel_update');
Route::delete('/hotel/{id}', [HotelController::class, 'destroy'])->middleware('admin')->name('hotel_delete');

Route::get('/bookings', [BookingsController::class, 'index'])->name('bookings');
Route::get('/booking', [BookingsController::class, 'show']);
Route::get('/booking_create/{hotel_id}', [BookingsController::class, 'create'])->name('booking_create');
Route::post('/booking_store', [BookingsController::class, 'store'])->middleware('custom.auth')->name('booking_store');
Route::delete('/booking/{id}', [BookingsController::class, 'destroy'])->middleware('custom.auth')->name('booking_delete');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::get('/review_create/{hotel_id}', [ReviewController::class, 'create'])->middleware('custom.auth')->name('review_create');
Route::post('/review_store/{hotel_id}', [ReviewController::class, 'store'])->name('review_store');
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review_delete');

Route::get('/registration', [UserController::class, 'show_register'])->name('show_registration');;
Route::get('/login', [UserController::class, 'show_login'])->name('show_login');
Route::get('/admin_login', [UserController::class, 'show_admin_login'])->name('show_admin_login');
Route::post('/registration', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/login_admin', [UserController::class, 'admin'])->name('admin');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/booking/plus', [BookingsController::class, 'plus'])->name('plus');
Route::post('/booking/minus', [BookingsController::class, 'min'])->name('min');

Route::post('/amenity_store', [AmenitiesController::class, 'store'])->middleware('admin')->name('amenity_store');
Route::delete('/amenity/{id}', [AmenitiesController::class, 'destroy'])->middleware('admin')->name('amenity_delete');

Route::post('/meal_store', [MealController::class, 'store'])->middleware('admin')->name('meal_store');
Route::delete('/meal/{id}', [MealController::class, 'destroy'])->middleware('admin')->name('meal_delete');

Route::post('/rule_store', [RulesController::class, 'store'])->middleware('admin')->name('rule_store');
Route::delete('/rule/{id}', [RulesController::class, 'destroy'])->middleware('admin')->name('rule_delete');