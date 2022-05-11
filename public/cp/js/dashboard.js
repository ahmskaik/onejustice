var reportFactory = function () {
    var colors = ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE',
        '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92', '#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce',
        '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'];

    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var base = jQuery('base').attr('href');

    var getDaysInMonth = function (year, month) {
        return new Date(year, month, 0).getDate();
    }

    var handleAjaxReport = function () {
        var maxNo = jQuery('.txt-maxno').val();
        if (maxNo == "" || maxNo == null) {
            maxNo = 15;
        }
        var date_from = jQuery('.txt-inputfrom').val();
        var date_to = jQuery('.txt-inputto').val();

        if (date_from) {
            date_from = date_from + '-01';
        }
        if (date_to) {
            var str = date_to;
            var year = str.substring(0, str.indexOf("-"));
            var month = str.substring(str.indexOf("-") + 1, str.length);
            date_to = date_to + '-' + getDaysInMonth(year, month);
        }

        jQuery.ajax({
            type: 'GET',
            url: cp_route_name + '/countryVisit',
            data: {
                maxNo: maxNo,
                from: date_from,
                to: date_to
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                flag_reset = false;
                var result = data.data;
                var xaxies = [];
                var yaxies = [];
                var totalcountries = 0;
                var totalcount = 0;
                for (var i = 0; i < result.length; i++) {
                    xaxies.push(result[i].country);
                    yaxies.push(parseFloat(result[i].count));
                    totalcount += parseFloat(result[i].count);
                }
                //console.log(result);
                totalcountries = result.length;
                jQuery('.total-countries').text(totalcountries);
                jQuery('.total-count').text(totalcount);
                jQuery('.txt-inputfrom').val(data.from);
                jQuery('.txt-inputto').val(data.to);
                if (result.length) {
                    handleCountryChart(xaxies, yaxies);
                }
            }
        });

        jQuery.ajax({
            type: 'GET',
            url: cp_route_name + '/mostVisited',
            data: {
                from: date_from,
                to: date_to
            },
            dataType: 'json',
            success: function (data) {
                flag_reset = false;
                var result = data.data;
                var xaxies = [];
                var yaxies = [];
                var serial = [];
                var totalpageviews = 0;
                var totalurl = 0;
                for (var i = 0; i < result.length; i++) {
                    xaxies.push(result[i].url);
                    yaxies.push(parseFloat(result[i].pageViews));
                    totalpageviews += parseFloat(result[i].pageViews);
                }
                totalurl = result.length;

                input_wlbl();
                if (result.length) {
                    handleMostVisited(xaxies, yaxies);
                }
            }
        });

        jQuery.ajax({
            type: 'GET',
            url: cp_route_name + '/visitors',
            data: {
                from: date_from,
                to: date_to
            },
            dataType: 'json',
            success: function (data) {
                flag_reset = false;
                var result = data.data;
                var xaxies = [];
                var yaxies = [];
                var serial = [];
                var totalvisitors = 0;
                var totalpageviews = 0;
                var totalactiveusers = 0;
                for (var i = 0; i < result.data.length; i++) {
                    xaxies.push(result.data[i].period);
                    yaxies.push(parseFloat(result.data[i].pageViews));
                    serial.push(parseFloat(result.data[i].visitors));
                    totalvisitors += parseFloat(result.data[i].visitors);
                    totalpageviews += parseFloat(result.data[i].pageViews);
                }

                if (result.data.length) {
                    jQuery('.chart-showing').removeClass('display-none');
                    jQuery('.chartmsg-showing').addClass('display-none');
                    handleChartVisitors(xaxies, yaxies, serial);
                }
            }
        });
    };
    var handleCountryChart = function (xaxies, yaxies) {
        var categories_data = xaxies;
        var yaxies_data = yaxies;
        var options = {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Visits By Countries'
            },
            subtitle: {
                //text: 'Source: WorldClimate.com'
            },
            xAxis: [{
                categories: categories_data,
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Count',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                allowDecimals: false,
            }],
            tooltip: {
                //shared: true
            },
            legend: {
                floating: true,
                verticalAlign: 'top',
                align: 'left',
                y: 10,
                x: 50,
                //backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            if (this.y != 0) {
                                return this.y;
                            } else {
                                return null;
                            }
                        }
                    },
                    events: {
                        legendItemClick: function () {
                            return false;
                        }
                    }
                }
            },
            series: [{
                name: 'Count',
                type: 'column',
                //yAxis: 1,
                data: yaxies_data,
                tooltip: {
                    //valueSuffix: ' mm'
                }
            }],
            credits: {
                enabled: false
            },
        };

        $('#report_chart_country').highcharts(options);
    };
    var handleMostVisited = function (xaxies, yaxies) {
        /*var categories_data = ['Package One', 'Package Two', 'Package Three', 'Package Four', 'Package Five', 'Package Sex'];
        var nobooking_data = [7, 71.5, 106.4, 129.2, 144.0, 176.0];
        var rank_data = [7.0, 16.9, 29.5, 0, 121.5];*/
        var categories_data = xaxies;
        var yaxies_data = yaxies;
        var options = {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Most Visited',
                y: 10
            },
            subtitle: {
                //text: 'Source: WorldClimate.com'
            },
            xAxis: [{
                categories: categories_data,
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Page Views',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                allowDecimals: false,
            }],
            tooltip: {
                //shared: true
            },
            legend: {
                floating: true,
                verticalAlign: 'top',
                align: 'left',
                y: 10,
                x: 50,
                //backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            if (this.y != 0) {
                                return this.y;
                            } else {
                                return null;
                            }
                        },
                        //inside: true
                    },
                    events: {
                        legendItemClick: function () {
                            return false;
                        }
                    }
                },
            },
            series: [{
                name: 'Page Views',
                type: 'column',
                //yAxis: 1,
                data: yaxies_data,
                tooltip: {
                    //valueSuffix: ' mm'
                }
            }],
            credits: {
                enabled: false
            },
        };

        $('#report_chart_most_visited').highcharts(options);
    };
    var handleChartVisitors = function (xaxies, yaxies, serial) {
        var categories_data = xaxies;
        var yaxies_data = yaxies;
        var serial_data = serial;
        var options = {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Visitors & Page Views',
                y: 10
            },
            subtitle: {
                //text: 'Source: WorldClimate.com'
            },
            xAxis: [{
                categories: categories_data,
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'Page Views',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                allowDecimals: false,
            }, { // Secondary yAxis
                min: 0,
                title: {
                    text: 'Visitors',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true,
                allowDecimals: false,
            }],
            legend: {
                floating: true,
                verticalAlign: 'top',
                align: 'left',
                y: 10,
                x: 50,
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            if (this.y != 0) {
                                return this.y;
                            } else {
                                return null;
                            }
                        },
                        inside: true
                    },
                    events: {
                        legendItemClick: function () {
                            return false;
                        }
                    }
                },
                series: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            if (this.y != 0) {
                                return this.y;
                            } else {
                                return null;
                            }
                        }
                    },
                    events: {
                        legendItemClick: function () {
                            return false;
                        }
                    }
                }
            },
            series: [{
                name: 'Page Views',
                type: 'column',
                data: yaxies_data,
            }, {
                name: 'Visitors',
                type: 'spline',
                yAxis: 1,
                data: serial_data,
            }],
            credits: {
                enabled: false
            },
        };

        $('#report_chart_visitors').highcharts(options);
    };

    return {
        init: function () {
            handleAjaxReport();
        }
    };

}();

jQuery(document).ready(function () {
    reportFactory.init();
});
