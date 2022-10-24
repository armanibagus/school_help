<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

/* ================================ APP ROUTE ================================ */

/**
 * Super Admin Route
 */
Route::group(['namespace' => 'App\Http\Controllers\SuperAdmin', 'middleware' => 'auth'], function() {
    /**
     * Dashboard
     */
    Route::get('/super-admin/dashboard', 'Dashboard@index')->name('dashboard_super_admin');
});

/**
 * Admin Route
 */
Route::group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'auth'], function() {
    /**
     * Dashboard
     */
    Route::get('/admin/dashboard', 'Dashboard@index')->name('dashboard_admin');
});

/**
 * Volunteer Route
 */
Route::group(['namespace' => 'App\Http\Controllers\Volunteer', 'middleware' => 'auth'], function() {
    /**
     * Dashboard
     */
    Route::get('/admin/dashboard', 'Dashboard@index')->name('dashboard_volunteer');
});
