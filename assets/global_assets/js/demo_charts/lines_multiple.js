/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Multiple lines example
 *
 *  Demo JS code for multiple line chart [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsLinesMultipleLight = function() {


    //
    // Setup module components
    //

    // Line multiples
    var _linesMultipleLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var line_multiple_element = document.getElementById('line_multiple');


        //
        // Charts configuration
        //

        if (line_multiple_element) {

            // Initialize chart
            var line_multiple = echarts.init(line_multiple_element);


            //
            // Chart config
            //

            // Options
            line_multiple.setOption({

                // Define colors
                color: ['#f17a52', '#03A9F4'],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: [
                    {
                        left: 0,
                        right: 20,
                        top: 40,
                        height: 160,
                        containLabel: true
                    },
                    {
                        left: 0,
                        right: 20,
                        top: 280,
                        height: 160,
                        containLabel: true
                    }
                ],

                // Title
                title: [
                    {
                        left: 'center',
                        text: 'Trendyol Satışları',
                        top: 0,
                        textStyle: {
                            fontSize: 15,
                            fontWeight: 500
                        }
                    },
                    {
                        left: 'center',
                        text: 'Bayi Satışları',
                        top: 240,
                        textStyle: {
                            fontSize: 15,
                            fontWeight: 500
                        }
                    }
                ],

                // Tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    formatter: function (a) {
                        return (
                            a[0]['axisValueLabel'] + "<br>" +
                            '<span class="badge badge-mark mr-2" style="border-color: ' + a[0]['color'] + '"></span>' +
                            a[0]['seriesName'] + ': ' + a[0]['value'] + ' Satış' + "<br>" +
                            '<span class="badge badge-mark mr-2" style="border-color: ' + a[1]['color'] + '"></span>' +
                            a[1]['seriesName'] + ': ' + a[1]['value'] + ' Satış'
                        );
                    }
                },

                // Connect axis pointers
                axisPointer: {
                    link: {
                        xAxisIndex: 'all'
                    }
                },

                // Horizontal axis
                xAxis: [
                    {
                        type: 'category',
                        boundaryGap: false,
                        axisLine: {
                            onZero: true,
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: '#333'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: '#eee',
                                width: 1,
                                type: 'dashed'
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                            }
                        },
                        data: ['Ock','Şub','Mar','Nis','May','Haz','Tem','Aug','Eyl','Ekm','Kas','Arl'],
                    },
                    {
                        gridIndex: 1,
                        type: 'category',
                        boundaryGap: false,
                        axisLine: {
                            onZero: true,
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: '#333'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: '#eee',
                                width: 1,
                                type: 'dashed'
                            }
                        },
                        splitArea: {
                            show: true,
                            areaStyle: {
                                color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                            }
                        },
                        data: ['Ock','Şub','Mar','Nis','May','Haz','Tem','Aug','Eyl','Ekm','Kas','Arl'],
                    }
                ],

                // Vertical axis
                yAxis: [
                    {
                        type: 'value',
                        axisLine: {
                            onZero: true,
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: '#333'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: '#eee',
                                width: 1,
                                type: 'dashed'
                            }
                        }
                    },
                    {
                        gridIndex: 1,
                        type: 'value',
                        axisLine: {
                            onZero: true,
                            lineStyle: {
                                color: '#999'
                            }
                        },
                        axisLabel: {
                            textStyle: {
                                color: '#333'
                            }
                        },
                        splitLine: {
                            show: true,
                            lineStyle: {
                                color: '#eee',
                                width: 1,
                                type: 'dashed'
                            }
                        }
                    }
                ],

                // Add series
                series: [
                    {
                        name: 'Trendyol',
                        type: 'line',
                        smooth: true,
                        symbolSize: 7,
                        itemStyle: {
                            normal: {
                                borderWidth: 2
                            }
                        },
                        data: [63,88,25,65,30,85,57,90,76,19,74,39],
                    },
                    {
                        name: 'Bayi',
                        type: 'line',
                        xAxisIndex: 1,
                        yAxisIndex: 1,
                        smooth: true,
                        symbolSize: 7,
                        itemStyle: {
                            normal: {
                                borderWidth: 2
                            }
                        },
                        data: [60,30,49,72,49,82,90,29,48,20,49,39],
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            line_multiple_element && line_multiple.resize();
        };

        // On sidebar width change
        var sidebarToggle = document.querySelectorAll('.sidebar-control');
        if (sidebarToggle) {
            sidebarToggle.forEach(function(togglers) {
                togglers.addEventListener('click', triggerChartResize);
            });
        }

        // On window resize
        var resizeCharts;
        window.addEventListener('resize', function() {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _linesMultipleLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsLinesMultipleLight.init();
});
