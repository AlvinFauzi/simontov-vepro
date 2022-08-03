@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="flowrate" class="form-label">{{ trans('lang.flowrate') }}</label>
                                <select name="flowrate" id="flowrate" class="form-select select2"
                                    data-placeholder="{{ trans('lang.flowrate') }}" style="width: 100%;">
                                    <option value=""></option>
                                    @foreach ($flowrates as $row)
                                        <option value="{{ $row->file_name }}"
                                            @if ($setFileName == $row->file_name) selected @endif>
                                            {{ $row->file_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" id="error-flowrate"></div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="fromDate" class="form-label">{{ trans('lang.fromDate') }}</label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                    </div><input class="form-control fc-datepicker"
                                        placeholder="{{ trans('lang.fromDate') }}" type="text" name="fromDate"
                                        value="{{ now()->addDays(-1)->format('d F Y') }}">
                                </div>
                                <div class="invalid-feedback" id="error-fromDate"></div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label for="toDate" class="form-label">{{ trans('lang.toDate') }}</label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar tx-16 lh-0 op-6"></i>
                                    </div><input class="form-control fc-datepicker"
                                        placeholder="{{ trans('lang.toDate') }}" type="text" name="toDate"
                                        value="{{ now()->format('d F Y') }}">
                                </div>
                                <div class="invalid-feedback" id="error-toDate"></div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card-footer float-left">
                    <button type="button" class="btn btn-success btn-filter">
                        <i class="fe fe-search"></i>
                        {{ __('messages.button.filter') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="dashboard-chart">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title">Flowrate Chart</h3>
                        <div class="card-options">
                            <a href="javascript:void(0);" class="btn-filter" data-bs-placement="top"
                                data-bs-toggle="tooltip" title="Refresh Chart">
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a href="javascript:void(0);" data-bs-toggle="card-fullscreen" title="Full Screen Chart"
                                class="card-options-fullscreen">
                                <i class="fe fe-maximize"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="container-flowrate-chart">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="card-title">Pressure Chart</h3>
                        <div class="card-options">
                            <a href="javascript:void(0);" class="btn-filter" data-bs-placement="top"
                                data-bs-toggle="tooltip" title="Refresh Chart">
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a href="javascript:void(0);" data-bs-toggle="card-fullscreen" title="Full Screen Chart"
                                class="card-options-fullscreen">
                                <i class="fe fe-maximize"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body pb-0">
                        <div id="container-pressure-chart">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-xl-8 col-lg-9 col-sm-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h3 class="text-dark counter mt-0 mb-3 number-font">
                                            Totalizer 1, 2, 3
                                        </h3>
                                        <div class="progress h-1 mt-0 mb-2">
                                            <div class="progress-bar progress-bar-striped bg-primary w-100"
                                                role="progressbar">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col text-center"> <span class="text-muted">Tot.Lizer 1</span>
                                                <h4 class="fw-normal mt-2 mb-0 number-font1" id="totalizer-1">-</h4>
                                            </div>
                                            <div class="col text-center"> <span class="text-muted">Tot.Lizer 2</span>
                                                <h4 class="fw-normal mt-2 mb-0 number-font2" id="totalizer-2">-</h4>
                                            </div>
                                            <div class="col text-center"> <span class="text-muted">Tot.Lizer 3</span>
                                                <h4 class="fw-normal mt-2 mb-0 number-font3" id="totalizer-3">-</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h3 class="text-dark counter mt-0 mb-3 number-font">
                                            Flowrate Max & Min
                                        </h3>
                                        <div class="progress h-1 mt-0 mb-2">
                                            <div class="progress-bar progress-bar-striped bg-primary w-100"
                                                role="progressbar">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col text-center"> <span class="text-muted">Max</span>
                                                <h4 class="fw-normal mt-2 mb-0 number-font1" id="flowrate-max">-</h4>
                                            </div>

                                            <div class="col text-center"> <span class="text-muted">Min</span>
                                                <h4 class="fw-normal mt-2 mb-0 number-font3" id="flowrate-min">-</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h3 class="text-dark counter mt-0 mb-3 number-font">
                                            Pressure Max & Min
                                        </h3>
                                        <div class="progress h-1 mt-0 mb-2">
                                            <div class="progress-bar progress-bar-striped bg-primary w-100"
                                                role="progressbar">
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col text-center"> <span class="text-muted">Max</span>
                                                <h4 class="fw-normal mt-2 mb-0 number-font1" id="analog-max">-</h4>
                                            </div>

                                            <div class="col text-center"> <span class="text-muted">Min</span>
                                                <h4 class="fw-normal mt-2 mb-0 number-font3" id="analog-min">-</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-3 col-sm-12">
                        <div class="card mt-2 custom-card ">
                            <div class="card-header">
                                <h3 class="card-title">Status Battery</h3>
                            </div>
                            <div class="card-body pt-0">
                                <div id="statusBattery" class="apex-charts ht-150"></div>
                                <div class="row sales-product-infomation pb-0 mb-0 mx-auto wd-100p mt-6">
                                    <div class="col-md-12 col justify-content-center text-center">
                                        <p class="mb-0 d-flex justify-content-center">
                                            <span class="legend bg-primary"></span>
                                            Alarm
                                        </p>
                                    </div>
                                </div>
                                <div id="bin-alarm"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('styles')
    <link href="{{ asset('assets') }}/plugins/select2/select2.min.css" rel="stylesheet" />
    <!-- INTERNAL Bootstrap DatePicker css-->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/bootstrap-datepicker/bootstrap-datepicker.css">
@endsection

@section('scripts')
    <!-- INTERNAL SELECT2 JS -->
    <script src="{{ asset('assets') }}/plugins/select2/select2.full.min.js"></script>
    <!-- DATEPICKER JS -->
    <script src="{{ asset('assets') }}/plugins/date-picker/date-picker.js"></script>
    <script src="{{ asset('assets') }}/plugins/date-picker/jquery-ui.js"></script>

    <script>
        $('.fc-datepicker').datepicker({
            dateFormat: 'dd MM yy',
            showOtherMonths: true,
            selectOtherMonths: true,
        });
    </script>
    <script src="{{ asset('assets/plugins/chart/Chart.bundle.js') }}"></script>
    <!-- APEXCHART JS -->
    <script src="{{ asset('assets//js/apexcharts.js') }}"></script>
@endsection
