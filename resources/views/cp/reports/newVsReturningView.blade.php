@extends('cp.layout.layout')

@section('css')
    <link href="cp/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="cp/css/reports.css" rel="stylesheet" type="text/css"/>
@stop

@section('js')
    <script src="cp/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="cp/plugins/global/highcharts/js/highcharts.js" type="text/javascript"></script>
    <script src="cp/plugins/global/highcharts/js/highcharts-3d.js" type="text/javascript"></script>
    <script src="cp/plugins/global/highcharts/js/highcharts-more.js" type="text/javascript"></script>
    <script src="cp/plugins/global/highcharts/js/modules/exporting.js"></script>

    <script src="cp/js/reports/save_chart.js" type="text/javascript"></script>
    <script src="cp/js/reports/report-google-newVsReturning.js" type="text/javascript"></script>
@stop

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile kt-portlet--head-sm search-form-rg green">
            <div class="kt-portlet__head kt-portlet__head--sm">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-search"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{trans('admin/dashboard.search_form')}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form class="horizontal-form search-form kt-form kt-form--fit stiscky-inputs">
                    <div class="row">
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                            <label class="lblinput">Group By</label>
                            <select name="groupBy" class="bs-select form-control groupby-select">
                                <option value="year">Years</option>
                                <option value="month" selected="">Months</option>
                            </select>
                        </div>
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile input-wlbl">
                            <div class="form-group input-wlbl mb-0">
                                <label class="lblinput lblinputtop">From</label>
                                <div class="input-group">
                                    <input type="text" class="form-control inputdateclear txt-inputfrom" placeholder=""
                                           readonly="" value="">
                                    <i class="fa fa-close cleardate display-none"></i>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile input-wlbl">
                            <div class="form-group input-wlbl mb-0">
                                <label class="lblinput lblinputtop">To</label>
                                <div class="input-group">
                                    <input type="text" class="form-control inputdateclear txt-inputto" placeholder=""
                                           readonly="" value="">
                                    <i class="fa fa-close cleardate display-none"></i>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-calendar-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                            <div class="btn-search-reset">
                                <button type="button" class="btn btn-primary btn-brand--icon btn-submit-search"
                                        id="kt_search">
                                    <span>
                                        <i class="la la-search"></i>
                                        <span>{{trans('admin/dashboard.search')}}</span>
                                    </span>
                                </button>
                                <button type="reset" class="btn btn-secondary btn-secondary--icon btn-reset"
                                        id="kt_reset">
                                    <span>
                                        <i class="la la-close"></i>
                                        <span>{{trans('admin/dashboard.reset')}}</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <div class="totalshow-area">
                    <h2 class="titletop">General Information</h2>
                    <div class="total-show-region clearfix">
                        <div class="totalshow">
                            <span>Total New Visitors:</span>
                            <p class="total-newvisitors"></p>
                        </div><!-- totalshow -->
                        <div class="totalshow">
                            <span>Total Returning Visitors:</span>
                            <p class="total-returningvisitors"></p>
                        </div><!-- totalshow -->
                    </div>
                </div><!-- totalshow area -->
            </div>
        </div>

        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <div id="report_chart_column_1" class="CSSAnimationChart chart-showing"></div>
                <div class="chartmsg-showing display-none">No data to display chart</div>
            </div>
        </div>

        <div class="kt-portlet">
            <div class="kt-portlet__body">
                <div class="table-information-region">
                    <h3>Tabular Information</h3>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="mysample_1">
                        <thead>
                        <tr>
                            <th>Period Name</th>
                            <th>New Visitor</th>
                            <th>Returning Visitor</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('nav-actions')
    <div class="dropdown dropdown-inline">
        <button type="button" class="btn btn-success btn-icon-sm dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="la la-download"></i> Export
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <ul class="kt-nav">
                <li class="kt-nav__section kt-nav__section--first">
                    <span class="kt-nav__section-text">Choose an option</span>
                </li>
                <li class="kt-nav__item">
                    <a target="_blank" href="javascript:;"
                       class="kt-nav__link btn-exportpdf"
                       data-export="all" data-processtype="pdf">
                        <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                        <span class="kt-nav__link-text">Export All as PDF</span>
                    </a>
                </li>
                <li class="kt-nav__item">
                    <a href="javascript:;" class="kt-nav__link btn-exportpdf"
                       data-export=""
                       data-processtype="excel">
                        <i class="kt-nav__link-icon la la-file-excel-o"></i>
                        <span class="kt-nav__link-text">Export to Excel</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
@stop
