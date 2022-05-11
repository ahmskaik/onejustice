var reportFactory = function () {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var base = jQuery('base').attr('href');

    var getDaysInMonth = function (year, month) {
        return new Date(year, month, 0).getDate();
    }

    function input_wlbl() {
        jQuery('.input-wlbl').each(function () {
            if (jQuery(this).find('.form-control').val()) {
                jQuery(this).find('.lblinput').addClass('lblinputtop');
            } else {
                jQuery(this).find('.lblinput').removeClass('lblinputtop');
            }
        });
    }

    window.input_wlbl = input_wlbl;
    input_wlbl();

    var handleAjaxReport = function () {
        var maxNo = jQuery('.txt-maxno').val();
        if (maxNo == "" || maxNo == null) {
            maxNo = 15;
        }
        input_wlbl();
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
                //console.log(result);
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
                input_wlbl();
                if (result.length) {
                    jQuery('.chart-showing').removeClass('display-none');
                    jQuery('.chartmsg-showing').addClass('display-none');
                    handleChart_one(xaxies, yaxies);
                } else {
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
                    "order": [[0, 'asc']],
                    "aaData": result,
                    "aoColumns": [
                        {"mDataProp": "country"},
                        {"mDataProp": "count"},
                    ],
                    "autoWidth": false,
                    "scrollX": true,
                });
                oTable.draw();
            }
        });
    };

    var handleBtnClear = function () {
        jQuery(document).on('click', '.cleardate', function () {
            jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val('');
            jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
            input_wlbl();
            jQuery('.txt-inputfrom,.txt-inputto').change();
            handleAjaxReport();
            return false;
        });
    };

    var handleInputDate = function () {
        jQuery(document).on('change', '.inputdateclear', function () {
            if (jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val()) {
                jQuery(this).parents('.inputdate-wicon').find('.cleardate').removeClass('display-none');
            } else {
                jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
            }
        });
    };

    var flag_reset = false;
    var handleChangeElements = function () {
        jQuery(document).on('click', '.btn-report-search', function () {
            return false;
        });

        jQuery(document).on('click', '.btn-report-reset', function () {
            flag_reset = true;
            jQuery('.form-control').val('');
            jQuery('.lblinput').removeClass('lblinputtop');
            jQuery('.txt-maxno').val('5');
            select_wlbl();
            jQuery('.cleardate').addClass('display-none');
            if (flag_reset == true) {
                handleAjaxReport();
            }
        });

        jQuery('.groupby-select').change(function () {
            var thisclick = jQuery(this);
            if (flag_reset == false) {
                handleAjaxReport();
            }
        });

        jQuery('.txt-maxno').on('change keyup', function () {
            var thisclick = jQuery(this);
            if (flag_reset == false) {
                handleAjaxReport();
            }
        });

        $('.txt-inputfrom').datepicker({
            minViewMode: 1,
            autoclose: true,
            format: 'yyyy-mm'
        }).on('changeDate', function (ev) {
            var thisclick = jQuery(this);
            var val = thisclick.val();
            var valto = jQuery('.txt-inputto').val();
            jQuery('.tdtxt-period').text(val);
            if (valto) {
                jQuery('.tdtxt-period').text(val + ' , ' + valto);
            }
            if (flag_reset == false) {
                handleAjaxReport();
            }
        });

        $('.txt-inputto').datepicker({
            minViewMode: 1,
            autoclose: true,
            format: 'yyyy-mm'
        }).on('changeDate', function (ev) {
            var thisclick = jQuery(this);
            var val = thisclick.val();
            var valfrom = jQuery('.txt-inputfrom').val();
            jQuery('.tdtxt-period').text(val);
            if (valfrom) {
                jQuery('.tdtxt-period').text(valfrom + ' , ' + val);
            }
            if (flag_reset == false) {
                handleAjaxReport();
            }
        });
    };

    var handleChart_one = function (xaxies, yaxies) {
        /*var categories_data = ['Package One', 'Package Two', 'Package Three', 'Package Four', 'Package Five', 'Package Sex'];
        var yaxies_data = [7, 71.5, 106.4, 129.2, 144.0, 176.0];*/
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

    var handleExportPDF = function () {
        jQuery(document).on('click', '.btn-exportpdf', function () {
            var img = save_chart($('#report_chart_country').highcharts());
            var thisclick = jQuery(this);
            var base = jQuery('base').attr('href');
            var type_export = 'all';
            var form_data = jQuery('.form-report').serialize();
            var date_from = jQuery('.txt-inputfrom').val();
            var date_to = jQuery('.txt-inputto').val();
            var process_type = thisclick.attr('data-processtype');
            if ((thisclick.attr('data-export') == 'chart')) {
                type_export = 'chart';
            }
            if ((thisclick.attr('data-export') == 'table')) {
                type_export = 'table';
            }

            function load_pdf(imgname) {
                var img_link = '';
                if ((thisclick.attr('data-export') == 'all') || (thisclick.attr('data-export') == 'chart')) {
                    img_link = '&img=' + imgname;
                }
                //window.open(cp_route_name+'/country?'+form_data+'&from='+date_from+'&to='+date_to+img_link+'&exportType='+type_export+'&export='+process_type, '_blank');
                window.location.href = cp_route_name + '/countryVisit?' + form_data + '&from=' + date_from + '&to=' + date_to + img_link + '&exportType=' + type_export + '&export=' + process_type;
            }

            var imgname = '';
            if ((thisclick.attr('data-export') == 'all') || (thisclick.attr('data-export') == 'chart')) {
                jQuery.ajax({
                    type: 'POST',
                    url: cp_route_name + '/saveChartImage',
                    data: {
                        img: img
                    },
                    dataType: 'json',
                    success: function (data) {
                        imgname = data.name;
                        console.log(imgname);
                        if (data.status) {
                            load_pdf(imgname);
                        }
                    },
                    error: function (data) {
                        Command: toastr["error"](data.message, "Message");
                    },
                });
            } else {
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

jQuery(document).ready(function () {
    reportFactory.init();
});
