@extends('cp.layout.layout')

@section('css')
    <link href="cp/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <style>
        .reportcampaing-region .dashboard-stat2, .report-chart-region .portlet {
            background-color: #eef1f5;
        }

        .reportcampaing-region .dashboard-stat2, .report-chart-region .portlet {
            background-color: #eef1f5;
        }

        .dashboard-stat2 {
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            -ms-border-radius: 4px;
            -o-border-radius: 4px;
            border-radius: 4px;
            background: #fff;
            padding: 15px 15px 30px;
        }

        .dashboard-stat2, .dashboard-stat2 .display {
            margin-bottom: 20px;
        }

        .dashboard-stat2 .progress-info .status .status-title {
            float: left;
            display: inline-block;
        }

        .dashboard-stat2 .progress-info .status .status-number {
            float: right;
            display: inline-block;
        }

        .dashboard-stat2 .progress-info .progress {
            margin: 0;
            height: 4px;
        }
        .dashboard-stat2 .display .number h3 {
            margin: 0 0 2px;
            padding: 0;
            font-size: 30px;
            font-weight: 400;
        }
        .font-red-haze {
            color: #f36a5a!important;
        }
        .dashboard-stat2 .display .number small {
            font-size: 14px;
            color: #AAB5BC;
            font-weight: 600;
            text-transform: uppercase;
        }
        .reportcampaing-region .dashboard-stat2, .report-chart-region .portlet {
            background-color: #eef1f5;
        }
        .dashboard-stat2 .progress-info .status {
            margin-top: 5px;
            font-size: 11px;
            color: #AAB5BC;
            font-weight: 600;
            text-transform: uppercase;
        }
        .report-chart-region .table-scrollable .table,.report-chart-region .table-scrollable .table th {
            background-color: #fff;
        }
        .amcharts-chart-div > a {
            display: none !important;
        }
        .report-chart-region .table-scrollable .table th{
            color: #34495e!important;
        }
        .font-green-sharp {
            color: #2ab4c0!important;
        }
        .font-blue-sharp {
            color: #5C9BD1!important;
        }
        .font-purple-soft {
            color: #8877a9!important;
        }
    </style>
@endsection

@section('js')
    <script src="cp/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="cp/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
    <script src="cp/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
    <script src="cp/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

    @if($tap=="overview")
        <script src="cp/js/pages/newsletter/report-campaign.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                initChartSummary({{ $summary["bounces"]['syntax_errors'] }},{{ $summary["unsubscribed"] }},{{ $summary["abuse_reports"] }},{{ $summary["opens"]['opens_total'] }},{{ $summary["opens"]['unique_opens'] }},{{ $summary["clicks"]['clicks_total'] }},{{ $summary["clicks"]['unique_clicks'] }});
            });

            @if(sizeof($domainPerformance))
            var chart = AmCharts.makeChart("chart_bar_domainperformance", {
                "type": "serial",
                "theme": "light",
                "pathToImages":  "cp/plugins/amcharts/amcharts/images/",
                "autoMargins": false,
                "marginLeft": 30,
                "marginRight": 8,
                "marginTop": 10,
                "marginBottom": 26,

                "fontFamily": 'Open Sans',
                "color": '#888',

                "dataProvider": [
                        @foreach($domainPerformance['domains'] as $item)
                    {
                        "domain": "{{ $item['domain'] }}",
                        "emails": {{ $item['emails_sent'] }},
                        "opens": {{ $item['opens'] }},
                        "clicks": {{ $item['clicks'] }}
                    },
                    @endforeach
                ],
                "startDuration": 1,
                "graphs": [{
                    "alphaField": "alpha",
                    "balloonText": "<span style='font-size:13px;'>[[title]] No.:<b>[[value]]</b> [[additional]]</span>",
                    "dashLengthField": "dashLengthColumn",
                    "fillAlphas": 1,
                    "title": "Emails",
                    "type": "column",
                    "valueField": "emails"
                }, {
                    "balloonText": "<span style='font-size:13px;'>[[title]] No.:<b>[[value]]</b> [[additional]]</span>",
                    "bullet": "round",
                    "dashLengthField": "dashLengthLine",
                    "lineThickness": 3,
                    "bulletSize": 7,
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "useLineColorForBulletBorder": true,
                    "bulletBorderThickness": 3,
                    "fillAlphas": 0,
                    "lineAlpha": 1,
                    "title": "Opens",
                    "valueField": "opens"
                }, {
                    "id": "g2",
                    "valueField": "clicks",
                    "classNameField": "bulletClass",
                    "title": "Clicks",
                    "type": "line",
                    "valueAxis": "a2",
                    "lineColor": "#786c56",
                    "lineThickness": 1,
                    "bullet": "round",
                    "bulletBorderColor": "#02617a",
                    "bulletBorderAlpha": 1,
                    "bulletBorderThickness": 2,
                    "bulletColor": "#89c4f4",
                    "labelPosition": "right",
                    "balloonText": "Clicks No. [[value]]",
                    "showBalloon": true,
                    "animationPlayed": true,
                }],
                "categoryField": "domain",
                "categoryAxis": {
                    "gridPosition": "start",
                    "axisAlpha": 0,
                    "tickLength": 0
                }
            });
            @endif

            @if(sizeof($geoOpens))
            var chart = AmCharts.makeChart("chart_pie_mostcountries", {
                "type": "pie",
                "theme": "light",
                "fontFamily": 'Open Sans',
                "color": '#888',
                "dataProvider": [
                        @foreach($geoOpens['locations'] as $item)
                    {
                        "country": "{{ $item['region'].' | '.$item['country_code'].' ('.$item['region_name'].')' }}",
                        "value": {{ $item['opens'] }}
                    },
                    @endforeach
                ],
                "valueField": "value",
                "titleField": "country",
                "outlineAlpha": 0.4,
                "depth3D": 10,
                "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
                "angle": 10,
                "exportConfig": {
                    menuItems: [{
                        icon: '/lib/3/images/export.png',
                        format: 'png'
                    }]
                }
            });
            @endif
        </script>
    @else
        <script src="cp/js/pages/newsletter/{{ $tap }}.js" type="text/javascript"></script>
    @endif
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--tabs">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-danger nav-tabs-line-2x nav-tabs-line-right nav-tabs-bold"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $tap=="overview"?"active":"" }}" role="tab"
                               href="{{ $cp_route_name }}/{{ $route }}/reports/{{ $cid }}">
                                <i class="fa fa-eye" aria-hidden="true"></i>Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tap=="complained"?"active":"" }}"  role="tab"
                               href="{{ $cp_route_name }}/{{ $route }}/reports/complained/{{ $cid }}">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>Complained
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tap=="unsubscribe"?"active":"" }}" role="tab"
                               href="{{ $cp_route_name }}/{{ $route }}/reports/unsubscribe/{{ $cid }}">
                                <i class="fa fa-user-alt-slash" aria-hidden="true"></i>Unsubscribed
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $tap=="activity"?"active":"" }}"role="tab"
                               href="{{ $cp_route_name }}/{{ $route }}/reports/activity/{{ $cid }}">
                                <i class="fab fa-gitter" aria-hidden="true"></i>Activity
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="tab-content">
                    <div class="tab-content">
                        @include("cp/mailchimp/reports/".$tap)
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
