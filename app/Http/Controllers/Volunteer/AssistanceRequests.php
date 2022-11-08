<?php

namespace App\Http\Controllers\Volunteer;

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
      $list_requests = mRequest::where('req_status', 'new')->get(['id_request','id_school','req_description','created_at']);
      $data = [
        'list_requests' => $list_requests,
      ];
      return view('volunteer/assistanceRequests/list', $data);
    }

    public function create_offer($id_request) {
      $data = ['id_request' => $id_request];
      return view('volunteer/assistanceRequests/submitOffer', $data);
    }

    public function store_offer(Request $request, $id_request) {
      $data_validation = Validator::make($request->all(), [
        'remarks' => ['required', 'string'],
      ]);

      // validate the input and return errors using
      // json response with status 200
      if ($data_validation->fails()) {
        return response()->json($data_validation->errors());
      } else {
        $data_new_offer = [
          'id_request' => Crypt::decrypt($id_request),
          'id_user' => Auth::user()->id_user,
          'ofr_remarks' => $request['remarks'],
        ];
        Offer::create($data_new_offer);
      }
    }
}
