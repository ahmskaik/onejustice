@extends('cp.layout.layout')

@section('css')
    <link href="cp/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="cp/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="cp/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css"/>
    <link href="cp/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="cp/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="cp/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="cp/css/customprint.css" rel="stylesheet" type="text/css" media="print"/>
@stop

@section('js')
    <script src="cp/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="cp/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <script src="cp/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="cp/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="cp/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="cp/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
    <script src="cp/global/plugins/highcharts/js/highcharts.js" type="text/javascript"></script>
    <script src="cp/global/plugins/highcharts/js/highcharts-3d.js" type="text/javascript"></script>
    <script src="cp/global/plugins/highcharts/js/highcharts-more.js" type="text/javascript"></script>
    <script src="cp/global/plugins/highcharts/js/modules/exporting.js"></script>
    <script src="cp/pages/scripts/components-select2.min.js" type="text/javascript"></script>
    <script src="cp/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
    <script src="cp/js/plugins/jQuery.print.js" type="text/javascript"></script>
    <script src="cp/js/datetime-custom.js" type="text/javascript"></script>
    <script src="cp/js/reports/save_chart.js" type="text/javascript"></script>
    <script src="cp/js/reports/report-1.js" type="text/javascript"></script>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered pfullscreen reports-portlet reportsgoogle-portlet">
                <div class="portlet-title">
                    <div class="caption font-green">
                        <span class="caption-subject bold uppercase">Users Report </span>
                        <!-- <span class="caption-helper">per month</span> -->
                    </div>

                    <div class="actions actions-chart dont-print avoid-this clearfix">
                        <a href="javascript:;"
                           class="btn btn-circle btn-icon-only btn-default fullscreen fmax tooltip-one-info"
                           title="Fullscreen"></a>
                        <div class="btn-group pull-right">
                            <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Tools
                                <i class="fa fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a target="_blank" href="javascript:;" class="btn-exportpdf" data-export="all"
                                       data-processtype="pdf">
                                        <i class="fa fa-file-pdf-o"></i> Export All as PDF
                                    </a>
                                    <ul class="mydropdown-submenu">
                                        <li>
                                            <a target="_blank" href="javascript:;" class="btn-exportpdf"
                                               data-export="chart" data-processtype="pdf">
                                                <i class="fa fa-file-pdf-o"></i> Export Chart Only
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="javascript:;" class="btn-exportpdf"
                                               data-export="table" data-processtype="pdf">
                                                <i class="fa fa-file-pdf-o"></i> Export Table Only
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="javascript:;" class="btn-exportpdf" data-export=""
                                       data-processtype="excel">
                                        <i class="fa fa-file-excel-o"></i> Export to Excel
                                    </a>
                                </li>
                            </ul>
                        </div><!-- btn group -->
                    </div><!-- actions -->
                </div><!-- portlet title -->

                <div class="portlet-body">
                    <div class="portlet box blue package-form-rg">
                        <div class="portlet-title myptitle">
                            <div class="caption">
                                <i class="fa fa-search"></i>Search Form
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse mycollapse"></a>
                                <!-- <a href="javascript:;" class="remove"> </a> -->
                            </div>
                        </div>
                        <div class="portlet-body collapse-body form">
                            <!-- BEGIN FORM-->
                            <form action="#" class="horizontal-form search-submit stakeholder-searchform form-report">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group selectbs-wlbl">
                                                <span class="lblselect">Group By</span>
                                                <select name="groupBy" class="bs-select form-control groupby-select">
                                                    <option value="month" selected="">Months</option>
                                                    <option value="quarter">Quarter</option>
                                                    <option value="year">Years</option>
                                                </select>
                                            </div>
                                        </div><!--span-->
                                        <div class="col-md-6">
                                            <div class="input-wlbldate">
                                                <span class="lbldate">Search Date</span>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group input-wlbl">
                                                            <span class="lblinput">From</span>
                                                            <div class="input-group inputdate-wicon">
                                                                <input type="text"
                                                                       class="form-control inputdateclear txt-inputfrom"
                                                                       placeholder="" readonly="" value=""/>
                                                                <i class="fa fa-close cleardate display-none"></i>
                                                                <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div><!-- col md 6 -->
                                                    <div class="col-md-6">
                                                        <div class="form-group input-wlbl">
                                                            <span class="lblinput">To</span>
                                                            <div class="input-group inputdate-wicon">
                                                                <input type="text"
                                                                       class="form-control inputdateclear txt-inputto"
                                                                       placeholder="" readonly="" value=""/>
                                                                <i class="fa fa-close cleardate display-none"></i>
                                                                <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div><!-- col md 6 -->
                                                </div><!-- row -->
                                            </div><!-- input wlbldate -->
                                        </div><!-- col md 6 -->
                                    </div><!--/row-->

                                    <div class="btnsearchreset-rg clearfix">
                                        <div class="btn-search-reset clearfix">
                                            <button type="submit" class="btn green btn-report-search">Search</button>
                                            <button type="button" class="btn default btn-report-reset">Reset</button>
                                        </div>
                                    </div>
                                </div><!-- form body -->
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div><!-- portlet -->

                    <div class="totalshow-area">
                        <h2 class="titletop">General Information</h2>
                        <div class="total-show-region clearfix">
                            <div class="totalshow">
                                <span>Total Active Users:</span>
                                <p class="total-activeusers"></p>
                            </div><!-- totalshow -->
                            <div class="totalshow">
                                <span>Total InActive Users:</span>
                                <p class="total-inactiveusers"></p>
                            </div><!-- totalshow -->
                        </div>
                    </div><!-- totalshow area -->

                    <div id="report_chart_column_1" class="CSSAnimationChart chart-showing"></div>
                    <div class="chartmsg-showing display-none">No data to display chart</div>

                    <div class="table-information-region">
                        <h3>Tabular Information</h3>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="mysample_1">
                            <thead>
                            <tr>
                                <th>Period Name</th>
                                <th>Total Users</th>
                                <th>Active Users</th>
                                <th>InActive Users</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div><!-- table information region -->
                </div><!-- portlet body -->
            </div><!-- portlet -->
        </div>
    </div>
@stop