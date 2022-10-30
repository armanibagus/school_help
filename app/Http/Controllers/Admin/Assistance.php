<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\mAssistance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Assistance extends Controller
{
    public function index() {
      $list_requests = mAssistance::leftJoin('users', 'users.id_user','=','assistance.id_user')
        ->where([
          'assistance.id_school' => Auth::user()->id_school,
        ])->get([
          'assistance.id_assistance',
          'assistance.id_user',
          'assistance.ast_description',
          'assistance.ast_type',
          'assistance.ast_status',
        ]);
      $data = ['list_requests' => $list_requests];
      return view('admin/assistance/list', $data);
    }

    public function store(Request $request) {
      // data rules
      if ($request['request_type'] == 'tutorial') {
        $rules = [
          'proposed_datetime' => 'bail|required|date|date_format:Y-m-d\TH:i:s',
          'student_level' => 'bail|required|string|max:255',
          'no_of_student' => 'bail|required|integer|min:1',
        ];
      } else if ($request['request_type'] == 'resource') {
        $rules = [
          'resource_type' => 'bail|required|string|max:255',
          'no_of_resource' => 'bail|required|string|max:255',
        ];
      } else {
        return abort(404);
      }
      $rules['description'] = 'bail|required|string';
      $data_validation = Validator::make($request->all(), $rules);

      if ($data_validation->fails()) {
        return response()->json($data_validation->errors());
      } else {
        if ($request['request_type'] == 'tutorial') {
          $data_new_assistance = [
            'ast_proposed_datetime' => $request['proposed_datetime'],
            'ast_student_level' => $request['student_level'],
            'ast_no_of_student' => $request['no_of_student'],
            'ast_type' => $request['request_type'],
          ];
        } else if ($request['request_type'] == 'resource') {
          $data_new_assistance = [
            'ast_resource_type' => $request['resource_type'],
            'ast_no_of_resource' => $request['no_of_resource'],
            'ast_type' => $request['request_type'],
          ];
        } else {
          return abort(404);
        }
        $data_new_assistance['id_school'] = Auth::user()->id_school;
        $data_new_assistance['id_user'] = Auth::user()->id_user;
        $data_new_assistance['ast_description'] = $request['description'];

        mAssistance::create($data_new_assistance);
      }
    }
}
