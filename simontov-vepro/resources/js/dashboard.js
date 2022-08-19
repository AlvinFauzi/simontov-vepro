if (location.pathname == `${appUrl}/home`) {
    var startDate,
        endDate;
    $(function () {
        startDate = moment().subtract(1, 'days').set('hour',24).set('minute',-1);
        endDate = moment();

        var applyLabel,
            cancelLabel;

        let daysOfWeek = [];
        let monthNames = [];

        cb(startDate, endDate);
        loadLanguage()

        $('#dashboard-chart').addClass('d-none')

        $('.btn-filter').on('click', async function () {
            await filterFLowrate(
                {flowrate: $('[name="flowrate"]').val(), fromDate: startDate, toDate: endDate, interval: $('[name="interval"]').val()}
            )
        });

        $('#flowrate,#interval').on('change', async function () {
            await filterFLowrate(
                {flowrate: $('[name="flowrate"]').val(), fromDate: startDate, toDate: endDate, interval: $('[name="interval"]').val()}
            )
        });

        function loadLanguage() {
            $.ajax({
                type: 'get',
                url: `/datepicker-lang`,
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

        function filterFLowrate(params) {
            $.ajax({
                type: 'get',
                url: appUrl + '/filter-flowrate',
                data: params,
                dataType: "json",
                success: function (res) {
                    if (res.data.data.length > 0) {
                        let categories = []
                        let flowrates = []
                        let analogs = []
                        let timestampFlowrate = []
                        let timestampPressure = []
                        setDashboardData(res.data)
                        setBinData(res.data.binItem)
                        setBatteryStatus(res.data.status_battery)
                        res
                            .data
                            .data
                            .map(val => {
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
                            });
                        flowratePressureChart(timestampFlowrate, timestampPressure)
                        $('#dashboard-chart').removeClass('d-none')
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
            $('#chart-date-range').text(`${data.dateRange}`)
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
                            width: 3,
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
                            width: 3,
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
                timePickerIncrement: 5,
                maxDate: moment(),
                startDate: moment().subtract(1, 'days').set('hour',24).set('minute',0),
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
            $('#date_range span').html(html);

            filterFLowrate(
                {flowrate: $('[name="flowrate"]').val(), fromDate: startDate, toDate: endDate, interval: $('[name="interval"]').val()}
            )

        }

    });
}
