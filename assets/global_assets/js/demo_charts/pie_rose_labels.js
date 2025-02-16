/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Rose pie with labels example
 *
 *  Demo JS code for rose pie chart with labels [light theme]
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsPieRoseLabelsLight = function() {


    //
    // Setup module components
    //

    // Rose pie chart with labels
    var _pieRoseLabelsLightExample = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define element
        var pie_rose_labels_element = document.getElementById('pie_rose_labels');


        //
        // Charts configuration
        //

        if (pie_rose_labels_element) {

            // Initialize chart
            var pie_rose_labels = echarts.init(pie_rose_labels_element);


            //
            // Chart config
            //

            // Options
            pie_rose_labels.setOption({

                // Colors
                color: [
                    '#2ec7c9','#b6a2de','#5ab1ef','#ffb980','#d87a80',
                    '#8d98b3','#e5cf0d','#97b552','#95706d','#dc69aa',
                    '#07a2a4','#9a7fd1','#588dd5','#f5994e','#c05050',
                    '#59678c','#c9ab00','#7eb00a','#6f5553','#c14089'
                ],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Add title
                title: {
                    text: 'Personel Maaş Dağılımı',
                    subtext: 'Aylık Maaş Giderleri',
                    left: 'center',
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'item',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    formatter: '{a} <br/>{b}: +{c} TRY ({d}%)'
                },

                // Add legend
                legend: {
                    orient: 'vertical',
                    top: 'center',
                    left: 0,
                    data: ['Ock','Şub','Mar','Nis','May','Haz','Tem','Aug','Eyl','Ekm','Kas','Arl'],
                    itemHeight: 8,
                    itemWidth: 8
                },

                // Add series
                series: [
                    {
                        name: 'Toplam (Net)',
                        type: 'pie',
                        radius: ['15%', '80%'],
                        center: ['50%', '57.5%'],
                        roseType: 'radius',
                        itemStyle: {
                            normal: {
                                borderWidth: 1,
                                borderColor: '#fff'
                            }
                        },
                        data: [
                            {value: 440, name: 'Ock'},
                            {value: 260, name: 'Şub'},
                            {value: 350, name: 'Mar'},
                            {value: 250, name: 'Nis'},
                            {value: 210, name: 'May'},
                            {value: 350, name: 'Haz'},
                            {value: 300, name: 'Tem'},
                            {value: 430, name: 'Aug'},
                            {value: 400, name: 'Eyl'},
                            {value: 450, name: 'Ekm'},
                            {value: 330, name: 'Kas'},
                            {value: 200, name: 'Arl'}
                        ]
                    }
                ]
            });
        }


        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            pie_rose_labels_element && pie_rose_labels.resize();
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
            _pieRoseLabelsLightExample();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsPieRoseLabelsLight.init();
});
