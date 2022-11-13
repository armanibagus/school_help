<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Data extends Controller
{
  public function data($breadcrumb, $request = '') {
    $data['breadcrumb'] = Data::breadcrumb($breadcrumb);
    $data['sidenav'] = Data::sidenav($request);
    return $data;
  }

  public function breadcrumb($breadcrumb) {
    $data = [
      'breadcrumb' => $breadcrumb
    ];
    return view('layouts/breadcrumb', $data);
  }

  public function sidenav($request) {
    $role_user = Auth::user()->role_user;
    $sidenav = [];
    if ($role_user == 'super_admin') {
      $sidenav = [
        [
          'name' => 'Dashboard',
          'icon' => 'ni ni-tv-2',
          'route' => route('dashboard_super_admin'),
          'active' => Route::is('dashboard_super_admin') ? 'active' : '',
        ],
        [
          'name' => 'School and Admin',
          'icon' => 'fa fa-school',
          'route' => route('register_school_admin'),
          'active' => Route::is('register_school_admin') ||
                      Route::is('register_administrator') ? 'active' : '',
        ],
      ];
    }

    $data = [
      'sidenav' => $sidenav
    ];
    return view('layouts/sidenav', $data);
  }
}
