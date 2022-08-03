@extends('layouts.app')

@section('button-add')
    <div class="ms-auto pageheader-btn">
        <a href="javascript:void(0);" id="addButton" class="btn btn-primary btn-icon text-white me-2">
            <span>
                <i class="fe fe-plus"></i>
            </span> {{ __('messages.button.add') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <table id="data-table" class="table table-bordered text-nowrap border-bottom text-center"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div id="modalAction" class="modal fade" role="dialog" aria-hidden="true" aria-labelledby="modalAction">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ trans('lang.name') }}</label>
                        <input id="name" type="text" class="form-control" name="name" required
                            placeholder="{{ trans('lang.name') }}">
                        <div class="invalid-feedback" id="error-name"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning"
                        data-bs-dismiss="modal">{{ __('messages.button.close') }}</button>
                    <button type="button" class="btn btn-success btn-action">{{ __('messages.button.submit') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalDetail" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="mb-0">{{ trans('lang.name') }}</span>
                            <strong class="text-muted" id="detail-name">-</strong>
                        </li>
                    </ul>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">
                            {{ __('messages.button.close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- SELECT2 CSS -->
    <link href="{{ asset('assets') }}/plugins/select2/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/plugins/datatable/css/dataTables.bootstrap5.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/plugins/datatable/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />
@endsection

@section('scripts')
    <!-- INTERNAL SELECT2 JS -->
    <script src="{{ asset('assets') }}/plugins/select2/select2.full.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/js/dataTables.bootstrap5.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/js/buttons.bootstrap5.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/js/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatable/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('assets') }}/js/table-data.js"></script>
@endsection
