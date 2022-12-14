if (location.pathname == `${appUrl}/home`) {
    var startDate,
        endDate;
    $(function () {
        startDate = moment()
            .subtract(1, 'days')
            .set('hour', 0)
            .set('minute', 0)
            .set('second', 0)
        endDate = moment()
            .subtract(1, 'days')
            .set('hour', 24)
            .set('minute', 0)
            .set('second', 0)

        var applyLabel,
            cancelLabel;

        let daysOfWeek = [];
        let monthNames = [];
        let chartData = [];
        let categories = []
        let flowrates = []
        let analogs = []
        let timestampFlowrate = []
        let timestampPressure = []

        cb(startDate, endDate);
        loadLanguage()

        $('#dashboard-chart').addClass('d-none')

        $('#flowrate,#interval').on('change', async function () {
            var start = moment(startDate);
            var end = moment(endDate);
            var days = end.diff(start, 'days')
            await filterFLowrate(
                {flowrate: $('[name="flowrate"]').val(), fromDate: startDate, toDate: endDate, interval: $('[name="interval"]').val()}
            )

        });

        function loadLanguage() {
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
        }

        function notFoundAlert(message) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: modalAlert.failed,
                text: `${message}`,
                showConfirmButton: false,
                timer: 1500
            });
        }

        function setDashboardData(data) {

            const totalizeResult = parseFloat(data.totalizer_last) - parseFloat(
                data.totalizer_first
            );
            $('#chart-date-range').text(`${data.dateRange}`)

            $('#totalizer-first').html(`${data.totalizer_first}`)
            $('#totalizer-last').html(`${data.totalizer_last}`)
            $('#totalizer-result').html(
                `${parseFloat(totalizeResult).toFixed(2)} ${data.unitTotalizer}`
            )

            $('#totalizer-1').html(`${data.totalizer_1}`)
            $('#totalizer-2').html(`${data.totalizer_2}`)
            $('#totalizer-3').html(`${data.totalizer_3}`)

            $('#flowrate-min').html(data.min_flowrate)
            $('#flowrate-max').html(data.max_flowrate)

            $('#analog-min').html(`${data.min_analog} Bar`)
            $('#analog-max').html(`${data.max_analog} Bar`)

            $('#alarm').text(data.alarm)
        }

        function setBinData(data) {
            if (data.length > 0) {
                let html = '';
                data.forEach((el, id) => {
                    html += `<span class="badge bg-danger me-1 mb-1 mt-1 fs-15">${el.name}</span>`
                });
                $('#bin-alarm').html(html)
            }
        }

        function setBatteryStatus(data) {
            var options = {
                chart: {
                    height: 305,
                    type: 'radialBar',
                    offsetX: 0,
                    offsetY: 10
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        size: 120,
                        imageWidth: 50,
                        imageHeight: 50,
                        track: {
                            strokeWidth: data + "%"
                        },
                        dropShadow: {
                            enabled: false,
                            top: 0,
                            left: 0,
                            bottom: 0,
                            blur: 3,
                            opacity: 1
                        },
                        dataLabels: {
                            name: {
                                fontSize: '16px',
                                color: undefined,
                                offsetY: 30
                            },
                            hollow: {
                                size: "60%"
                            },
                            value: {
                                offsetY: -10,
                                fontSize: '22px',
                                color: undefined,
                                formatter: function (val) {
                                    return val + "%";
                                }
                            }
                        }
                    }
                },
                colors: ['#ff5d9e'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "gradient",
                        type: "horizontal",
                        shadeIntensity: .5,
                        gradientToColors: ['#6259ca'],
                        inverseColors: !0,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                },
                stroke: {
                    dashArray: 4
                },
                series: [data],
                labels: [""]
            };

            var chart = new ApexCharts(document.querySelector("#statusBattery"), options);
            chart.render();
        }

        function flowratePressureChart(dataFlowrate, dataPressure) {
            var options = {
                chart: {
                    height: 450,
                    type: "line",
                    stacked: false
                },
                dataLabels: {
                    enabled: false
                },
                colors: [
                    "#6259ca", "#eb6f33"
                ],
                series: [
                    {
                        name: "Flowrate",
                        data: dataFlowrate
                    }, {
                        name: "Pressure",
                        data: dataPressure
                    }
                ],
                stroke: {
                    width: [
                        2, 2
                    ],
                    curve: "straight"
                },

                xaxis: {
                    type: "datetime",
                    labels: {
                        datetimeUTC: false
                    }
                },
                yaxis: [
                    {
                        axisTicks: {
                            show: true
                        },
                        axisBorder: {
                            show: true,
                            color: "#6259ca",
                            borderType: 'solid',
                            width: 3
                        },
                        labels: {
                            style: {
                                colors: "#6259ca"
                            }
                        },
                        title: {
                            text: "l/s",
                            style: {
                                color: "#6259ca"
                            }
                        }
                    }, {
                        opposite: true,
                        axisTicks: {
                            show: true
                        },
                        axisBorder: {
                            show: true,
                            color: "#eb6f33",
                            borderType: 'solid',
                            width: 3
                        },
                        labels: {
                            style: {
                                colors: "#eb6f33"
                            }
                        },
                        title: {
                            text: "Bar",
                            style: {
                                color: "#eb6f33"
                            }
                        }
                    }
                ],
                tooltip: {
                    shared: !1,
                    y: {
                        formatter: function (e) {
                            return e
                        }
                    },
                    x: {
                        formatter: function (e) {
                            return moment(e).format('LLLL');
                        }
                    }
                },
                legend: {
                    horizontalAlign: "left",
                    offsetX: 9999
                }
            };
            var chart = new ApexCharts(
                document.querySelector("#container-flowrate-pressure-chart"),
                options
            );
            chart.render();
            chart.updateOptions(options)
        }

        function loadDatepicker() {
            $('#date_range').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                maxDate: moment(),
                startDate: moment()
                    .subtract(1, 'days')
                    .set('hour', 0)
                    .set('minute', 0),
                endDate: moment()
                    .subtract(1, 'days')
                    .set('hour', 24)
                    .set('minute', 0),
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
            var days = end.diff(start, 'days')
            if(days >= 90){
                confirmAlert(start, end)
            } else {
                setDateRangeData(start, end)
            }
        }

        function setDateRangeData(start, end) {
            let html = '';
            startDate = start.format('YYYY-MM-DD HH:mm:ss');
            endDate = end.format('YYYY-MM-DD HH:mm:ss');
            html = start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY')
            $('#date_range span').html(html);

            filterFLowrate(
                {flowrate: $('[name="flowrate"]').val(), fromDate: startDate, toDate: endDate, interval: $('[name="interval"]').val()}
            )
        }

        function filterFLowrate(params) {
            $('#loading-chart').removeClass('d-none')
            $('#loading-text').removeClass('d-none')
            $('#container-flowrate-pressure-chart').addClass('d-none')
            $('#other-chart').addClass('d-none')
            $('#chart-date-range').addClass('d-none')
            $.ajax({
                type: 'get',
                url: appUrl + '/filter-flowrate',
                data: params,
                dataType: "json",
                success: function (res) {
                    if (res.data.data.length > 0) {
                        categories = []
                        flowrates = []
                        analogs = []
                        timestampFlowrate = []
                        timestampPressure = []
                        chartData = []
                        setDashboardData(res.data)
                        setBinData(res.data.binItem)
                        setBatteryStatus(res.data.status_battery)
                        chartFilterData(res.data)
                        flowratePressureChart(timestampFlowrate, timestampPressure)
                        $('#loading-chart').addClass('d-none')
                        $('#loading-text').addClass('d-none')
                        $('#dashboard-chart').removeClass('d-none')
                        $('#container-flowrate-pressure-chart').removeClass('d-none')
                        $('#other-chart').removeClass('d-none')
                        $('#chart-date-range').removeClass('d-none')
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 404) {
                        notFoundAlert(xhr.responseJSON.message)
                    }
                    if (xhr.status == 403) {
                        unauthAlert(xhr.responseJSON.message)
                    }
                }
            });
        }

        function chartFilterData(data) {
            var list = data.data
            var count = 0;
            var interval = $('[name="interval"]').val()
            var start = moment(startDate);
            var end = moment(endDate);
            var minute = end.diff(start, 'minutes')
            chartData.push(data.first)
            for (let i = 0; i < minute; i++) {
                count += parseInt(interval)
                check(count, data, list)
            }
        }

        function check(count, data, list) {
            var date = moment(data.first.mag_date_chart).add(count, 'minutes')
            var getDate = date.format('YYYY-MM-DD HH:mm:ss')
            for (let i = 0; i < list.length; i++) {
                const val = list[i];
                if (val.mag_date_chart === getDate) {
                    chartData.push(val)
                    categories.push(val.mag_date)
                    flowrates.push(val.flowrate)
                    analogs.push(val.analog_2)
                    timestampFlowrate.push([
                        (val.timestamp * 1000),
                        parseFloat(val.flowrate)
                    ])
                    timestampPressure.push([
                        (val.timestamp * 1000),
                        parseFloat(val.analog_2)
                    ])
                }
            }
        }

        function confirmAlert(start, end) {
            Swal
                .fire({
                    title: 'Peringatan',
                    text: `Rentang tanggal data yang ditampilkan lebih dari 3 Bulan, akan melakukan proses loading chart lebih lama dari biasanya.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $('[name="interval"]').val(60).trigger('change')
                        setDateRangeData(start, end)
                    }
                });
        }

    });
}
