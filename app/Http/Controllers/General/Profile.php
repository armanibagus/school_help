<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class Profile extends Controller
{
  public function edit($id_user) {
    $id_user = Crypt::decrypt($id_user);
    $data = ['user' => User::find($id_user)];
    return view('general/profile', $data);
  }

  public function update(Request $request, $id_user) {
    $rules = [
      'full_name' => 'bail|required|string|max:255',
      'email' => 'bail|required|string|email|max:255',
      'phone_number' => 'required|string|max:255',
    ];

    $id_user = Crypt::decrypt($id_user);
    $user = User::find($id_user);

    if (!empty($request['password'])) {
      $rules['password'] = 'bail|required|string|min:8|confirmed';
    } else if($request['email'] != $user->email) {
      $rules['email'] = 'bail|required|string|email|max:255|unique:users';
    }

    if ($user->role_user == "admin") {
      $rules['staff_id'] = 'bail|required|string|max:255';
      $rules['position'] = 'bail|required|string|max:255';
    } else if ($user->role_user == "volunteer") {
      $rules['date_of_birth'] = 'bail|required|date|date_format:Y-m-d';
      $rules['occupation'] = 'bail|required|string|max:255';
    }
    $request->validate($rules);

    return redirect()->back();
  }
}