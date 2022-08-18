@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">

                <div class="card-body">
                    <div class="row justify-content-end mb-2">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                </div>
                                <input class="form-control" type="text" id="dateRange" width="100%">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive ">
                        <table id="data-table"
                            class="table table-bordered text-nowrap key-buttons border-bottom w-100 text-center table-hover"
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
                                    <th class="border-bottom-0">Pressure</th>
                                    <th class="border-bottom-0">Status Battery</th>
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

@section('styles')
    <link href="{{ asset('assets') }}/plugins/datatable/css/dataTables.bootstrap5.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/plugins/datatable/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@endsection
