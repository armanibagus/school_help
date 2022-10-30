@extends('layouts.main')

@section('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  <style>
    .table> :not(:last-child)> :last-child>* {
      border-bottom: 1px solid rgba(0, 0, 0, 0.3);
    }
    .table> :not(caption)>*>* {
      border-bottom-color: #e9ecef;
    }
    .dataTables_info, .dataTables_paginate {
      padding-top: 1rem!important;
      font-size: 0.75rem !important;
    }
    .paginate_button {
      border-radius: 5px !important;
      padding: 0.3em 0.8em !important;
    }
    span > a.paginate_button {
      border-radius: 50% !important;
    }

  </style>
@endsection

@section('js')
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
@endsection

@section('content')
  {{-- modal create school --}}
  @include('admin.assistance.create')

  <div class="card mb-4">
    <div class="card-header pb-0">
      <div class="row">
        <div class="col-6 d-flex align-items-center">
          <h4>
            <i class="fa fa-handshake-o me-3"></i>
            <small>Assistance Requests</small>
          </h4>
        </div>
        <div class="col-6 text-end">
          <button type="button" class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#modal-request-assistance">
            <i class="fas fa-plus"></i>&nbsp;&nbsp; Add
          </button>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table data-table">
          <thead>
          <tr class="text-dark">
            <th width="20">No</th>
            <th>Admin</th>
            <th>Description</th>
            <th width="60">Type</th>
            <th width="60">Status</th>
            <th width="100">Action</th>
          </tr>
          </thead>
          <tbody class="text-sm">
          @for($i=0; $i<count($list_requests); $i++)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $list_requests[$i]->admin->full_name }}</td>
              <td>{{ $list_requests[$i]->ast_description }}</td>
              <td>{{ $list_requests[$i]->ast_type }}</td>
              <td>{{ $list_requests[$i]->ast_status }}</td>
              <td class="d-flex justify-content-between mx-2">
                <a class="text-center"
{{--                   href="{{ route('request_assistance_detail', ['id_assistance' => \Illuminate\Support\Facades\Crypt::encrypt($list_requests[$i]->id_assistance)]) }}"--}}
                   data-bs-toggle="tooltip"
                   data-bs-placement="bottom"
                   title="Request Detail">
                  <i class="fa fa-info text-dark"></i>
                </a>
                <a class="text-center"
                   href="javascript:;"
                   data-bs-toggle="tooltip"
                   data-bs-placement="bottom"
                   title="Edit Request">
                  <i class="fa fa-edit text-primary"></i>
                </a>
                <a class="text-center"
                   href="javascript:;"
                   data-bs-toggle="tooltip"
                   data-bs-placement="bottom"
                   title="Delete Request">
                  <i class="fa fa-trash text-danger"></i>
                </a>
              </td>
            </tr>
          @endfor
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
