
var reportFactory = function () {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var base = jQuery('base').attr('href');

    var getDaysInMonth = function(year,month) {
        return new Date(year, month, 0).getDate();
    }

    function input_wlbl() {
        jQuery('.input-wlbl').each(function(){
        if(jQuery(this).find('.form-control').val())
            {
                jQuery(this).find('.lblinput').addClass('lblinputtop');
            }
            else
            {
                jQuery(this).find('.lblinput').removeClass('lblinputtop');
            }
        });
    }
    window.input_wlbl = input_wlbl;
    input_wlbl();

    var handleAjaxReport = function() {
        var group_by = jQuery('.groupby-select').val();
        var date_from = jQuery('.txt-inputfrom').val();
        var date_to = jQuery('.txt-inputto').val();

        if(date_from)
        {
            date_from = date_from+'-01';
        }
        if(date_to)
        {
            var str = date_to;
            var year = str.substring( 0, str.indexOf("-"));
            var month = str.substring(str.indexOf("-")+1, str.length);
            date_to = date_to+'-'+getDaysInMonth(year,month);
        }

        jQuery.ajax({
            type: 'GET',
            url: cp_route_name+'/newVsReturning',
            data: {
                groupBy: group_by,
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
                var data_one = [];
                var data_two = [];
                var totalnewvisitors = 0;
                var totalreturningvisitors = 0;
                //console.log(result);
                for (var i = 0; i < result.length; i++) {
                    xaxies.push(result[i].periodName);
                    //yaxies.push(parseFloat(result[i].ReturningVisitor));
                    //serial.push(parseFloat(result[i].NewVisitor));
                    data_one.push(parseFloat(result[i].ReturningVisitor));
                    data_two.push(parseFloat(result[i].NewVisitor));
                    totalnewvisitors+=parseFloat(result[i].NewVisitor);
                    totalreturningvisitors+=parseFloat(result[i].ReturningVisitor);
                }
                //console.log(result);
                jQuery('.total-newvisitors').text(totalnewvisitors);
                jQuery('.total-returningvisitors').text(totalreturningvisitors);
                jQuery('.txt-inputfrom').val(data.from);
                jQuery('.txt-inputto').val(data.to);
                input_wlbl();
                if(result.length)
                {
                    jQuery('.chart-showing').removeClass('display-none');
                    jQuery('.chartmsg-showing').addClass('display-none');
                    //handleChart_one(xaxies, yaxies, serial);
                    handleChart_one(xaxies, data_one, data_two);
                }
                else
                {
                    jQuery('.chart-showing').addClass('display-none');
                    jQuery('.chartmsg-showing').removeClass('display-none');
                }

                jQuery('#mysample_1,.mysample_1').dataTable().fnDestroy();
                var oTable = $('#mysample_1,.mysample_1').DataTable({
                    "dom": "<'table-scrollable'rt><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>> ",
                    "columnDefs": [{
                        "searchable": false,
                        "orderable": false,
                        //"targets": 0
                    }],
                    "order": [[ 0, 'asc' ]],
                    "aaData": result,
                    "aoColumns": [
                        { "mDataProp": "periodName" },
                        { "mDataProp": "NewVisitor" },
                        { "mDataProp": "ReturningVisitor" },
                    ],
                    "autoWidth": false,
                    "scrollX": true,
                });
                oTable.draw();
            }
        });
    };

    var handleBtnClear = function() {
        jQuery(document).on('click','.cleardate',function() {
            jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val('');
            jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
            input_wlbl();
            jQuery('.txt-inputfrom,.txt-inputto').change();
            handleAjaxReport();
            return false;
        });
    };

    var handleInputDate = function() {
        jQuery(document).on('change','.inputdateclear',function() {
            if(jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val())
            {
                jQuery(this).parents('.inputdate-wicon').find('.cleardate').removeClass('display-none');
            }
            else
            {
                jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
            }
        });
    };

    var flag_reset = false;
    var handleChangeElements = function() {
        jQuery(document).on('click','.btn-report-search',function(){
            return false;
        });

        jQuery(document).on('click','.btn-report-reset',function(){
            flag_reset = true;
            jQuery('.form-control').val('');
            jQuery('.lblinput').removeClass('lblinputtop');
            jQuery('select.bs-select').val(0);
            jQuery('select.groupby-select').val('month');
            jQuery('.bs-select').selectpicker('refresh');
            select_wlbl();
            jQuery('.cleardate').addClass('display-none');
            if(flag_reset==true)
            {
                handleAjaxReport();
            }
        });

        jQuery('.groupby-select').change(function() {
            var thisclick = jQuery(this);
            if(flag_reset==false)
            {
                handleAjaxReport();
            }
        });

        $('.txt-inputfrom').datepicker({
            minViewMode: 1,
            autoclose: true,
            format: 'yyyy-mm'
        }).on('changeDate', function(ev){
            var thisclick = jQuery(this);
            var val = thisclick.val();
            var valto = jQuery('.txt-inputto').val();
            jQuery('.tdtxt-period').text(val);
            if(valto)
            {
                jQuery('.tdtxt-period').text(val+' , '+valto);
            }
            if(flag_reset==false)
            {
                handleAjaxReport();
            }
        });

        $('.txt-inputto').datepicker({
            minViewMode: 1,
            autoclose: true,
            format: 'yyyy-mm'
        }).on('changeDate', function(ev){
            var thisclick = jQuery(this);
            var val = thisclick.val();
            var valfrom = jQuery('.txt-inputfrom').val();
            jQuery('.tdtxt-period').text(val);
            if(valfrom)
            {
                jQuery('.tdtxt-period').text(valfrom+' , '+val);
            }
            if(flag_reset==false)
            {
                handleAjaxReport();
            }
        });
    };

    //var handleChart_one = function(xaxies, yaxies, serial) {
    var handleChart_one = function(xaxies, data_one, data_two) {
        /*var categories_data = ['Package One', 'Package Two', 'Package Three', 'Package Four', 'Package Five', 'Package Sex'];
        var nobooking_data = [7, 71.5, 106.4, 129.2, 144.0, 176.0];
        var rank_data = [7.0, 16.9, 29.5, 0, 121.5];*/
        var categories_data = xaxies;
        //var yaxies_data = yaxies;
        //var serial = serial;
        var data_one = data_one;
        var data_two = data_two;

        /*var options = {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'New Visitors VS Returning Visitors '
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
                    text: 'Returning Visitor',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                allowDecimals: false,
            },{ // Secondary yAxis
                min: 0,
                title: {
                    text: 'New Visitor',
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
                opposite: true
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
                        formatter: function() {
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
                        formatter: function() {
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
                },
            },
            series: [{
                name: 'Returning Visitor',
                type: 'column',
                //yAxis: 1,
                data: yaxies_data,
                tooltip: {
                    //valueSuffix: ' mm'
                }
            }, {
                name: 'New Visitor',
                type: 'spline',
                yAxis: 1,
                data: serial,
                tooltip: {
                    //valueSuffix: '°C'
                }
            }],
            credits: {
                enabled: false
            },
            chart: {
                renderTo: 'report_chart_column_1',
            }
        };*/

        var series_data = [{
            name: 'Returning Visitors',
            data: data_one
        },{
            name: 'New Visitors',
            data: data_two
        }];

        var options = {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Number of Visitors'
            },
            xAxis: {
                categories: categories_data
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'No. of Visitors'
                },
                labels: {
                    format: '{value}',
                },
                stackLabels: {
                    enabled: true,
                    align: 'center',
                    y: -15,
                    formatter: function() {
                        var sum = 0;
                        var series = this.axis.series;

                        for (var i in series) {
                            if (series[i].visible && series[i].options.stacking == 'normal')
                                sum += series[i].yData[this.x];
                        }
                        if(this.total > 0 ) {
                            return Highcharts.numberFormat(sum,0);
                        } else {
                            return '';
                        }
                    }
                },
                allowDecimals: false,
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                //shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
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
            series: series_data,
            credits: {
                enabled: false
            },
        };

        $('#report_chart_column_1').highcharts(options);
    };

    var handleExportPDF = function() {
        jQuery(document).on('click','.btn-exportpdf',function() {
            var img = save_chart($('#report_chart_column_1').highcharts());
            var date_from = jQuery('.txt-inputfrom').val();
            var date_to = jQuery('.txt-inputto').val();
            var thisclick = jQuery(this);
            var form_data = jQuery('.form-report').serialize();
            if(date_from)
            {
                date_from = date_from+'-01';
            }
            if(date_to)
            {
                var str = date_to;
                var year = str.substring( 0, str.indexOf("-"));
                var month = str.substring(str.indexOf("-")+1, str.length);
                date_to = date_to+'-'+getDaysInMonth(year,month);
            }
            var base = jQuery('base').attr('href');
            var type_export = 'all';
            if((thisclick.attr('data-export') == 'chart'))
            {
                type_export = 'chart';
            }
            if((thisclick.attr('data-export') == 'table'))
            {
                type_export = 'table';
            }
            var process_type = thisclick.attr('data-processtype');
            function load_pdf(imgname)
            {
                var img_link = '';
                if((thisclick.attr('data-export') == 'all') || (thisclick.attr('data-export') == 'chart'))
                {
                    img_link = '&img='+imgname;
                }
                window.location.href = cp_route_name+'/newVsReturning?'+form_data+'&from='+date_from+'&to='+date_to+img_link+'&exportType='+type_export+'&export='+process_type;
            }
            var imgname = '';
            if((thisclick.attr('data-export') == 'all') || (thisclick.attr('data-export') == 'chart'))
            {
                jQuery.ajax({
                    type: 'POST',
                    url: cp_route_name+'/saveChartImage',
                    data: {
                        img: img
                    },
                    dataType: 'json',
                    success: function (data) {
                        imgname = data.name;
                        console.log(imgname);
                        if(data.status)
                        {
                            load_pdf(imgname);
                        }
                    },
                    error: function (data) {
                        Command: toastr["error"](data.message, "Message");
                    },
                });
            }
            else
            {
                load_pdf(imgname);
            }
        });
    };

    return {
        init: function () {
            handleBtnClear();
            handleInputDate();
            handleChangeElements();
            handleAjaxReport();
            handleExportPDF();
        }
    };

}();

jQuery(document).ready(function() {
    reportFactory.init();
});
