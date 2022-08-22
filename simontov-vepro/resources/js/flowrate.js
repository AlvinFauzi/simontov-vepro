const moment = require("moment");

if (location.pathname === `${appUrl}/flowrate`) {
    var startDate,
        endDate;
    $(function () {
        let endPoint = `${appUrl}/flowrate`

        var applyLabel,
            cancelLabel;

        startDate = moment()
            .subtract(1, 'days')
            .set('hour', 24)
            .set('minute', -1);
        endDate = moment();

        let daysOfWeek = [];
        let monthNames = [];

        cb(startDate, endDate);

        $.ajax({
            type: 'get',
            url: `${appUrl}/datepicker-lang`,
            dataType: "json",
            success: function (res) {
                daysOfWeek = res.data.day
                monthNames = res.data.month
                applyLabel = res.data.button.apply
                cancelLabel = res.data.button.cancel
                loadDatepicker()
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.warn(thrownError);
                if (xhr.status == 403) {
                    unauthAlert(xhr.responseJSON.message)
                }
            }
        });

        function loadDatepicker() {
            $('#dateRange').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 5,
                maxDate: moment(),
                startDate: moment()
                    .subtract(1, 'days')
                    .set('hour', 24)
                    .set('minute', 0),
                endDate: moment(),
                opens: 'left',
                drops: 'auto',
                "locale": {
                    "format": "DD/MM/YYYY H:mm",
                    "separator": " - ",
                    "applyLabel": applyLabel,
                    "cancelLabel": cancelLabel,
                    "fromLabel": "From",
                    "toLabel": "To",
                    "customRangeLabel": "Custom",
                    "weekLabel": "W",
                    "daysOfWeek": daysOfWeek,
                    "monthNames": monthNames,
                    "firstDay": 1
                }
            }, cb);
        }

        function cb(start, end) {
            let html = '';
            startDate = start.format('YYYY-MM-DD HH:mm:ss');
            endDate = end.format('YYYY-MM-DD HH:mm:ss');
            html = start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')
            $('#dateRange span').html(html);

            // reload data
            $('#data-table')
                .DataTable()
                .destroy();

            loadData(startDate, endDate)
        }

        function loadData(from = '', to = '') {
            $('#data-table')
                .DataTable({
                    dom: 'Blfrtip',
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        className: 'mb-3',
                        title: 'Flowrate Data'
                    }, {
                        extend: 'colvis',
                        className: 'mb-3'
                    }],
                    lengthMenu: [
                        [
                            10,
                            25,
                            50,
                            100,
                            500,
                            1000
                        ],
                        [
                            10,
                            25,
                            50,
                            100,
                            500,
                            1000
                        ]
                    ],

                    language: {
                        url: ($('#activeLanguage').data('lang') != 'en') ?
                            `${appUrl}/lang_id.json` : null
                    },
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: `${endPoint}`,
                        data: {
                            from_date: from,
                            to_date: to
                        }
                    },
                    columns: [{
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, {
                        data: 'mag_date',
                        name: 'mag_date'
                    }, {
                        data: 'flowrate',
                        name: 'flowrate'
                    }, {
                        data: 'totalizer_1',
                        name: 'totalizer_1'
                    }, {
                        data: 'totalizer_2',
                        name: 'totalizer_2'
                    }, {
                        data: 'totalizer_3',
                        name: 'totalizer_3'
                    }, {
                        data: 'analog_1',
                        name: 'analog_1'
                    }, {
                        data: 'status_battery',
                        name: 'status_battery'
                    }, {
                        data: 'alarm',
                        name: 'alarm'
                    }, {
                        data: 'bin_alarm',
                        name: 'bin_alarm'
                    }, {
                        data: 'file_name',
                        name: 'file_name'
                    }]
                })
                .buttons()
                .container()
                .appendTo('#data-table_wrapper .col-md-4');
        }

    });

}
