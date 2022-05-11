function initChartSummary(EmailsNo,Unsubscribed,Complained,Opens,Unique_Opens,Clicks,Unique_Clics) {
    var chart = AmCharts.makeChart("chart_summary", {
        "theme": "light",
        "type": "serial",
        "startDuration": 2,

        "fontFamily": 'Open Sans',
        
        "color":    '#888',

        "dataProvider": [{
            "country": "Error EmailsNo",
            "visits": EmailsNo,
            "color": "#FF0F00"
        }, {
            "country": "Unsubscribed",
            "visits": Unsubscribed,
            "color": "#FF6600"
        }, {
            "country": "Complained",
            "visits": Complained,
            "color": "#FF9E01"
        }, {
            "country": "Opens",
            "visits": Opens,
            "color": "#B0DE09"
        }, {
            "country": "Unique Opens",
            "visits": Unique_Opens,
            "color": "#04D215"
        }, {
            "country": "Clicks",
            "visits": Clicks,
            "color": "#0D8ECF"
        }, {
            "country": "Unique Clicks",
            "visits": Unique_Clics,
            "color": "#0D52D1"
        }],
        "valueAxes": [{
            "position": "left",
            "axisAlpha": 0,
            "gridAlpha": 0
        }],
        "graphs": [{
            "balloonText": "[[category]]: <b>[[value]]</b>",
            "colorField": "color",
            "fillAlphas": 0.85,
            "lineAlpha": 0.1,
            "type": "column",
            //"topRadius": 1,
            "valueField": "visits"
        }],
        "depth3D": 20,
        "angle": 20,
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "country",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "gridAlpha": 0

        },
        "exportConfig": {
            "menuTop": "20px",
            "menuRight": "20px",
            "menuItems": [{
                "icon": '/lib/3/images/export.png',
                "format": 'png'
            }]
        }
    }, 0);

    /*$('#chart_summary').closest('.portlet').find('.fullscreen').click(function() {
        chart.invalidateSize();
    });*/
};
