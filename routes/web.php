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

  /**
   * Register school and administrator
   */
  // list school
  Route::get('/super-admin/school', 'RegisterSchoolAdmin@index_school')->name('register_school_admin');
  // store school
  Route::post('/super-admin/school/store', 'RegisterSchoolAdmin@store_school')->name('register_school_admin_store');
  // list administrator
  Route::get('/super-admin/school/administrator/{id_school}', 'RegisterSchoolAdmin@index_administrator')->name('register_administrator');
  // store administrator
  Route::post('/super-admin/school/administrator/store/{id_school}', 'RegisterSchoolAdmin@store_administrator')->name('register_administrator_store');
});

/**
 * Admin Route
 */
Route::group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'auth'], function() {
  /**
   * Dashboard
   */
  Route::get('/admin/dashboard', 'Dashboard@index')->name('dashboard_admin');

  /**
   * Request for assistance
   */
  // list
  Route::get('/admin/assistance', 'Assistance@index')->name('assistance');
  Route::post('/admin/assistance/store', 'Assistance@store')->name('assistance_store');
});

/**
 * Volunteer Route
 */
Route::group(['namespace' => 'App\Http\Controllers\Volunteer', 'middleware' => 'guest'], function() {
  /**
   * Register
   */
  Route::get('/register', 'Register@create')->name('register_volunteer');
  Route::post('/register/store', 'Register@store')->name('store_volunteer');
});

Route::group(['namespace' => 'App\Http\Controllers\Volunteer', 'middleware' => 'auth'], function() {
  /**
   * Dashboard
   */
  Route::get('/volunteer/dashboard', 'Dashboard@index')->name('dashboard_volunteer');
});
