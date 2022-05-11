var reportFactory = function () {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
            url: cp_route_name + '/referrers',
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
                jQuery('.total-pageviews').text(totalpageviews);
                jQuery('.total-url').text(totalurl);
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
                        {"mDataProp": "url"},
                        {"mDataProp": "pageViews"},
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
            jQuery('select.bs-select').val(0);
            jQuery('.bs-select').selectpicker('refresh');
            if (jQuery('select.select2').length) {
                jQuery('select.select2').select2("val", "");
                jQuery('select.select2').select2('data', null);
            }
            jQuery('.select-wlbl,.selectbs-wlbl,.select2-wlbl').find('.lblselect').removeClass('lblselecttop');
            jQuery('select.noarticles-select').val(5);
            jQuery('.bs-select').selectpicker('refresh');
            select_wlbl();
            jQuery('.cleardate').addClass('display-none');
            if (flag_reset == true) {
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
        var categories_data = xaxies;
        var yaxies_data = yaxies;
        var options = {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Referrers',
                y: 10
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
            }],
            credits: {
                enabled: false
            },
        };

        $('#report_chart_column_1').highcharts(options);
    };

    var handlePrintChart = function () {
        jQuery(document).on('click', '.print-chart', function () {
            $(".chartprint").print({
                noPrintSelector: ".avoid-this",
                stylesheet: "assets/css/customprint.css",
            });
        });
    };

    var handlePrintTable = function () {
        jQuery(document).on('click', '.print-table', function () {
            $(".tableprint-area").print({
                noPrintSelector: ".avoid-this,.charthide-region",
                stylesheet: "assets/css/customprint.css",
            });
        });
    };

    var handlePrintChartTable = function () {
        jQuery(document).on('click', '.print-charttable', function () {
            $(".charttableprint-area").print({
                noPrintSelector: ".avoid-this",
                stylesheet: "assets/css/customprint.css",
            });
        });
    };

    var handleExportPDF = function () {
        jQuery(document).on('click', '.btn-exportpdf', function () {
            var img = save_chart($('#report_chart_column_1').highcharts());
            var date_from = jQuery('.txt-inputfrom').val();
            var date_to = jQuery('.txt-inputto').val();
            var thisclick = jQuery(this);
            var form_data = jQuery('.form-report').serialize();
            if (date_from) {
                date_from = date_from + '-01';
            }
            if (date_to) {
                var str = date_to;
                var year = str.substring(0, str.indexOf("-"));
                var month = str.substring(str.indexOf("-") + 1, str.length);
                date_to = date_to + '-' + getDaysInMonth(year, month);
            }
            var base = jQuery('base').attr('href');
            var type_export = 'all';
            if ((thisclick.attr('data-export') == 'chart')) {
                type_export = 'chart';
            }
            if ((thisclick.attr('data-export') == 'table')) {
                type_export = 'table';
            }
            var process_type = thisclick.attr('data-processtype');

            function load_pdf(imgname) {
                var img_link = '';
                if ((thisclick.attr('data-export') == 'all') || (thisclick.attr('data-export') == 'chart')) {
                    img_link = '&img=' + imgname;
                }
                window.location.href = cp_route_name + '/referrers?' + form_data + '&from=' + date_from + '&to=' + date_to + img_link + '&exportType=' + type_export + '&export=' + process_type;
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
