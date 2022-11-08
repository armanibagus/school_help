<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\mRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class AssistanceRequests extends Controller
{
    public function index() {
      $list_requests = mRequest::leftJoin('users', 'users.id_user','=','request.id_user')
        ->where([
          'request.id_school' => Auth::user()->id_school,
        ])->get([
          'request.id_request',
          'request.id_user',
          'request.req_description',
          'request.req_type',
          'request.req_status',
        ]);
      $data = ['list_requests' => $list_requests];
      return view('admin/request/list', $data);
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
          $data_new_request = [
            'req_proposed_datetime' => $request['proposed_datetime'],
            'req_student_level' => $request['student_level'],
            'req_no_of_student' => $request['no_of_student'],
            'req_type' => $request['request_type'],
          ];
        } else if ($request['request_type'] == 'resource') {
          $data_new_request = [
            'req_resource_type' => $request['resource_type'],
            'req_no_of_resource' => $request['no_of_resource'],
            'req_type' => $request['request_type'],
          ];
        } else {
          return abort(404);
        }
        $data_new_request['id_school'] = Auth::user()->id_school;
        $data_new_request['id_user'] = Auth::user()->id_user;
        $data_new_request['req_description'] = $request['description'];

        mRequest::create($data_new_request);
      }
    }

    public function close($id_request) {
      $id_request = Crypt::decrypt($id_request);
      mRequest::find($id_request)->update(['req_status' => 'closed']);
      /**
       * Kurang email notification
       */
      return redirect()->back();
    }

    public function detail($id_request) {
      $id_request = Crypt::decrypt($id_request);
      $assistance_request = mRequest::find($id_request);
      $list_offers = Offer::where([
        ['id_request',$id_request],
        ['ofr_status','pending'],
      ])->get([
        'id_offer',
        'id_request',
        'id_user',
        'ofr_remarks',
        'ofr_status',
        'created_at',
      ]);
      $data = [
        'assistance_request' => $assistance_request,
        'list_offers' => $list_offers,
      ];
      return view('admin/request/detail', $data);
    }

    public function accept_offer($id_offer) {
      $id_offer = Crypt::decrypt($id_offer);
      Offer::where('id_offer',$id_offer)->update(['ofr_status' => 'accepted']);
      return redirect()->back();
    }
}
