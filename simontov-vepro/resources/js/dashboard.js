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
                        let timestampPressure = []
                        setDashboardData(res.data)
                        setBinData(res.data.binItem)
                        setBatteryStatus(res.data.status_battery)
                        res.data.data.map(val => {
                            categories.push(val.mag_date)
                            flowrates.push(val.flowrate)
                            analogs.push(val.analog_2)
                            timestampFlowrate.push([(val.timestamp * 1000), parseFloat(val.flowrate)])
                            timestampPressure.push([(val.timestamp * 1000), parseFloat(val.analog_2)])
                        });
                        flowratePressureChart(timestampFlowrate, timestampPressure, res.data.dateRange)
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

            function flowratePressureChart(dataFlowrate, dataPressure, subtitle) {
                options = {
                    chart: {
                        height: 450,
                        type: "line",
                        stacked: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    title: {
                        text: subtitle,
                        align: "left",
                        style: {
                            fontWeight: 700
                        }
                    },
                    colors: ["#6259ca","#eb6f33"],
                    series: [
                        {
                            name: "Flowrate",
                            data: dataFlowrate
                        },
                        {
                            name: "Pressure",
                            data: dataPressure
                        }
                    ],
                    stroke: {
                        width: [2, 2],
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
                            color: "#6259ca"
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
                        },
                        {
                          opposite: true,
                          axisTicks: {
                            show: true
                          },
                          axisBorder: {
                            show: true,
                            color: "#eb6f33"
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
                            formatter: function(e) {
                                return e
                            }
                        },
                        x: {
                            formatter: function(e) {
                                return moment(e).format('LLLL');
                            }
                        }
                    },
                    legend: {
                        horizontalAlign: "left",
                        offsetX: 9999
                    }
                };
                var chart = new ApexCharts(document.querySelector("#container-flowrate-pressure-chart"), options);
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
