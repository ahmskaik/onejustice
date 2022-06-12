@extends('cp.layout.layout')

@section('css')
    <link href="cp/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@endsection

@section('js')
    <script src="cp/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="cp/js/pages/donations/list.js?v=2.0.7" type="text/javascript"></script>
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-list"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{trans('admin/donation.donations')}}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <div class="dropdown dropdown-inline">
                                <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Export
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__section kt-nav__section--first">
                                            <span class="kt-nav__section-text">Choose an option</span>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a
                                                data-href="{{$cp_route_name}}/{{$route}}/list?export=xlsx&amp;"
                                                href="{{$cp_route_name}}/{{$route}}/list?export=xlsx&amp;"
                                                class="kt-nav__link exportData">
                                                <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                                <span class="kt-nav__link-text">Export to Excel</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a data-href="{{$cp_route_name}}/{{$route}}/list?export=csv&amp;"
                                               href="{{$cp_route_name}}/{{$route}}/list?export=csv&amp;"
                                               class="kt-nav__link exportData">
                                                <i class="kt-nav__link-icon la la-file-text-o"></i>
                                                <span class="kt-nav__link-text">Export to CSV</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a target="_blank"
                                               data-href="{{$cp_route_name}}/{{$route}}/list?export=pdf&amp;"
                                               href="{{$cp_route_name}}/{{$route}}/list?export=pdf&amp;"
                                               class="kt-nav__link exportData">
                                                <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                                <span class="kt-nav__link-text">Export to PDF</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body" id="data-list">
                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                       id="mydatatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Gateway</th>
                        <th>Amount</th>
                        <th>Currency</th>
                        <th>IP</th>
                        <th class="kt-align-center">{{trans('admin/dashboard.creation_date')}}</th>
                        <th class="tblaction-rg kt-align-center">{{trans('admin/dashboard.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
