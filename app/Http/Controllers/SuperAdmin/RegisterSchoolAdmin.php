<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\mSchool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterSchoolAdmin extends Controller
{
    public function index_school() {
      $list_school = mSchool::all();
      $data = ['list_school' => $list_school,];
      return view('superAdmin/registerSchool/list', $data);
    }

    public function store_school(Request $request) {
      $data_validation = Validator::make($request->all(), [
        'school_name' => 'bail|required|string|max:255',
        'city' => 'bail|required|string|max:255',
        'address' => 'bail|required|string|max:255',
      ]);

      // validate the input and return errors using
      // json response with status 200
      if ($data_validation->fails()) {
        return response()->json($data_validation->errors());
      } else {
        $data_new_school = [
          'sch_name' => $request['school_name'],
          'sch_city' => $request['city'],
          'sch_address' => $request['address'],
        ];
        mSchool::create($data_new_school);
      }
    }

    public function index_administrator($id_school) {
      $list_administrator = User::where([
        'id_school' => Crypt::decrypt($id_school),
        'role_user' => "admin",
      ])->get();
      $data = [
        'id_school' => $id_school,
        'list_administrator' => $list_administrator,
      ];
      return view('superAdmin/registerSchool/administrator/list', $data);
    }

    public function store_administrator(Request $request, $id_school) {
      $data_validation = Validator::make($request->all(), [
        'staff_id' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'min:8', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'full_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone_number' => ['required', 'string', 'max:255'],
        'position' => ['required', 'string', 'max:255'],
      ]);

      // validate the input and return errors using
      // json response with status 200
      if ($data_validation->fails()) {
        return response()->json($data_validation->errors());
      } else {
        $data_new_administrator = [
          'id_school' => Crypt::decrypt($id_school),
          'staff_id' => $request['staff_id'],
          'username' => $request['username'],
          'password' => Hash::make($request['password']),
          'full_name' => $request['full_name'],
          'email' => $request['email'],
          'phone_number' => $request['phone_number'],
          'position' => $request['position'],
          'role_user' => "admin",
        ];
        User::create($data_new_administrator);
      }
    }
}
