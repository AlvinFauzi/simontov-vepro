if (location.pathname == `${appUrl}/home`) {
    $(function() {

        $('#dashboard-chart').addClass('d-none')

        $('.btn-filter').on('click', function() {
            filterFLowrate({
                flowrate: $('[name="flowrate"]').val(),
                fromDate: $('[name="fromDate"]').val(),
                toDate: $('[name="toDate"]').val(),
            })
        });

        function filterFLowrate(params) {
            $.ajax({
                type: 'get',
                url: appUrl + '/filter-flowrate',
                data: params,
                dataType: "json",
                success: function(res) {
                    if (res.data.data.length > 0) {
                        let categories = []
                        let flowrates = []
                        let analogs = []
                        let timestampFlowrate = []
                        let timestampAnalog = []
                        setDashboardData(res.data)
                        setBinData(res.data.binItem)
                        setBatteryStatus(res.data.status_battery)
                        res.data.data.map(val => {
                            categories.push(val.mag_date)
                            flowrates.push(val.flowrate)
                            analogs.push(val.analog_2)
                            timestampFlowrate.push([(val.timestamp * 1000), parseFloat(val.flowrate)])
                            timestampAnalog.push([(val.timestamp * 1000), parseFloat(val.analog_2)])
                        });
                        flowrateChart(timestampFlowrate, res.data.dateRange, timestampAnalog, res.data.dateRange, categories)
                        pressureChart(timestampFlowrate, res.data.dateRange, timestampAnalog, res.data.dateRange, categories)
                        $('#dashboard-chart').removeClass('d-none')
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if (xhr.status == 422) {
                        $('.modal-body').find('input,textarea,select').removeClass(
                            'is-invalid')
                        let error = xhr.responseJSON.errors
                        $.each(error, function(index, value) {
                            $('[name="' + index + '"]').addClass('is-invalid')
                            $('#error-' + index).text(value[0]).show();
                        });
                        setTimeout(() => {
                            $.each(error, function(index, value) {
                                $('[name="' + index + '"]').removeClass('is-invalid')
                                $('#error-' + index).text(value[0]).hide();
                            });
                        }, 4000);
                    }
                    if (xhr.status == 403) {
                        unauthAlert(xhr.responseJSON.message)
                    }
                }
            });
        }

        function setDashboardData(data) {
            $('#totalizer-1').text(data.totalizer_1)
            $('#totalizer-2').text(data.totalizer_2)
            $('#totalizer-3').text(data.totalizer_3)

            $('#flowrate-min').text(data.min_flowrate)
            $('#flowrate-max').text(data.max_flowrate)

            $('#analog-min').text(data.min_analog)
            $('#analog-max').text(data.max_analog)

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
                    offsetY: 10,
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        size: 120,
                        imageWidth: 50,
                        imageHeight: 50,
                        track: {
                            strokeWidth: data + "%",
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
                                offsetY: 30,
                            },
                            hollow: {
                                size: "60%"
                            },
                            value: {
                                offsetY: -10,
                                fontSize: '22px',
                                color: undefined,
                                formatter: function(val) {
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

        function flowrateChart(dataFlowrate, subtitleFlowrate, dataAnalog, subtitleAnalog, categories) {
            options = {
                series: [{
                    name: "Flowrate",
                    data: dataFlowrate
                }, ],
                chart: {
                    type: "line",
                    stacked: !1,
                    height: 450,
                    zoom: {
                        type: "x",
                        enabled: !0,
                        autoScaleYaxis: !0
                    },
                    toolbar: {
                        autoSelected: "zoom"
                    }
                },
                colors: ['#6259ca'],
                dataLabels: {
                    enabled: !1
                },

                stroke: {
                    width: [2, 2],
                    curve: "straight"
                },
                title: {
                    text: subtitleFlowrate,
                    align: "left",
                    style: {
                        fontWeight: 700
                    }
                },

                yaxis: {
                    showAlways: !0,
                    labels: {
                        show: !0,
                    },
                    title: {
                        text: 'l/s',
                        style: {
                            fontWeight: 700
                        }
                    }
                },
                xaxis: {
                    type: "datetime",
                    labels: {
                        datetimeUTC: false
                    }
                },
                tooltip: {
                    shared: !1,
                    y: {
                        formatter: function(e) {
                            return e
                        }
                    },
                    x: {
                        formatter: function(e) {
                            return moment(e).format('LLLL');
                        }
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#container-flowrate-chart"), options);
            chart.render();
            chart.updateOptions(options)

        }

        function pressureChart(dataFlowrate, subtitleFlowrate, dataAnalog, subtitleAnalog, categories) {
            options = {
                series: [{
                    name: "Pressure",
                    data: dataAnalog
                }, ],
                chart: {
                    type: "line",
                    stacked: !1,
                    height: 450,
                    zoom: {
                        type: "x",
                        enabled: !0,
                        autoScaleYaxis: !0
                    },
                    toolbar: {
                        autoSelected: "zoom"
                    }
                },
                colors: ['#eb6f33'],
                dataLabels: {
                    enabled: !1
                },

                stroke: {
                    width: [2, 2],
                    curve: "straight"
                },
                title: {
                    text: subtitleFlowrate,
                    align: "left",
                    style: {
                        fontWeight: 700
                    }
                },

                yaxis: {
                    showAlways: !0,
                    labels: {
                        show: !0,
                    },
                    title: {
                        text: 'Bar',
                        style: {
                            fontWeight: 700
                        }
                    }
                },
                xaxis: {
                    type: "datetime",
                    labels: {
                        datetimeUTC: false
                    }
                },
                tooltip: {
                    shared: !1,
                    y: {
                        formatter: function(e) {
                            return e
                        }
                    },
                    x: {
                        formatter: function(e) {
                            return moment(e).format('LLLL');
                        }
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#container-pressure-chart"), options);
            chart.render();
            chart.updateOptions(options)

        }

        setTimeout(function() {
            filterFLowrate({
                flowrate: $('[name="flowrate"]').val(),
                fromDate: $('[name="fromDate"]').val(),
                toDate: $('[name="toDate"]').val(),
            })
        }, 1500);


    });
}