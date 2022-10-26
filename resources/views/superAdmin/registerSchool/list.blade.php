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
  @include('superAdmin.registerSchool.create')

      <div class="card mb-4">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-6 d-flex align-items-center">
              <h4>
                <i class="fa fa-school me-3"></i>
                <small>School</small>
              </h4>
            </div>
            <div class="col-6 text-end">
              <button type="button" class="btn btn-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#modal-register-school">
                <i class="fas fa-plus"></i>&nbsp;&nbsp; Register School
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
                  <th>School Name</th>
                  <th>City</th>
                  <th>Address</th>
                  <th width="100">Action</th>
                </tr>
              </thead>
              <tbody class="text-sm">
              @for($i=0; $i<count($list_school); $i++)
                @php $no=$i+1; @endphp
                <tr>
                  <td>{{ $no }}</td>
                  <td>{{ $list_school[$i]->sch_name }}</td>
                  <td>{{ $list_school[$i]->sch_city }}</td>
                  <td>{{ $list_school[$i]->sch_address }}</td>
                  <td class="d-flex justify-content-between mx-2">
                    <a class="text-center"
                      href="{{ route('register_administrator', ['id_school' => \Illuminate\Support\Facades\Crypt::encrypt($list_school[$i]->id_school)]) }}"
                       data-bs-toggle="tooltip"
                       data-bs-placement="bottom"
                       title="School Administrator">
                      <i class="fa fa-user text-dark"></i>
                    </a>
                    <a class="text-center"
                       href="javascript:;"
                       data-bs-toggle="tooltip"
                       data-bs-placement="bottom"
                       title="Edit School">
                      <i class="fa fa-edit text-primary"></i>
                    </a>
                    <a class="text-center"
                       href="javascript:;"
                       data-bs-toggle="tooltip"
                       data-bs-placement="bottom"
                       title="Delete School">
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