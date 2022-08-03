@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive ">
                        <table id="data-table"
                            class="table table-bordered text-nowrap key-buttons border-bottom  w-100 text-center"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">No</th>
                                    <th class="border-bottom-0">Mag. Date</th>
                                    <th class="border-bottom-0">Flowrate</th>
                                    <th class="border-bottom-0">Totalizer 1</th>
                                    <th class="border-bottom-0">Totalizer 2</th>
                                    <th class="border-bottom-0">Totalizer 3</th>
                                    <th class="border-bottom-0">Analog 1</th>
                                    <th class="border-bottom-0">Analog 2</th>
                                    <th class="border-bottom-0">Status Battery</th>
                                    <th class="border-bottom-0">Alarm</th>
                                    <th class="border-bottom-0">Bin Alarm</th>
                                    <th class="border-bottom-0">File Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div id="modalDetail" class="modal fade" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="mb-0">Code</span>
                            <strong class="text-muted" id="detail-code"></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="mb-0">Name</span>
                            <strong class="text-muted" id="detail-name"></strong>
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
    <link href="{{ asset('assets') }}/plugins/datatable/css/dataTables.bootstrap5.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/plugins/datatable/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />
@endsection

@section('scripts')
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
