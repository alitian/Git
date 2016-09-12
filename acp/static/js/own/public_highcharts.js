function get_highcharts() {
    options = {
        chart: {
            renderTo: 'container',
            type: ''
        },
        title: {
            text: ' '
        },
        subtitle: {
            text: ''
        },
        xAxis: {
//            labels: {rotation: 300, y: 40, x: 0}
        },
        yAxis: {
            min: 0,     //最小值为0 
            title: {
                text: ''
            },
            labels: {
                formatter: function() {
                    return Highcharts.numberFormat(this.value, 0);
                }
            },
            min: 0
        },
        credits: {
            enabled: false
        },
        exporting :{ 
            enabled:true,
            filename:"productinfo",
            type:"image/png",
            url:"http://export.highcharts.com",
            width:800
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
//            series: {
//                stacking: 'normal'
//            },
            bar: {
                dataLabels: {enabled: true},
                enableMouseTracking: true
            },
            spline: {
                marker: {
                    radius: 1,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
                marker: {
                    symbol: 'circle'
                }
            }]
    };
    return options;


}



