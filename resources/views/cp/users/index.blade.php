@extends('cp.layout.layout')

@section('css')
    <link href="cp/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
@endsection

@section('js')
    <script src="cp/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="cp/js/pages/user/list.js?v=1.0" type="text/javascript"></script>
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile search-form-rg">
            <div class="kt-portlet__head kt-portlet__head--lg">
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
                <form class="horizontal-form search-form kt-form kt-form--fit">
                    <div class="row">
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                            <label class="lblinput">{{trans('admin/user.name')}}</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <input type="text" class="form-control kt-input searchable"
                                       placeholder="{{trans('admin/user.name')}}"
                                       data-col-index="1" data-column="1">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                            <label class="lblinput">{{trans('admin/user.user_role')}}</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select class="form-control kt-input searchable"
                                        data-col-index="2" data-column="2" name="role_id">
                                    <option value="">All</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{    $role->name }}</option>
                                    @endforeach
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
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
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-list"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{trans('admin/user.users')}}
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
                            &nbsp;
                            <a href="{{ $cp_route_name  }}/{{ $route }}/create"
                               class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{trans('admin/dashboard.add_new')}}
                            </a>
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
                        <th>{{trans('admin/user.full_name')}}</th>
                        <th>{{trans('admin/user.role')}}</th>
                        <th>{{trans('admin/user.user_name')}}</th>
                        <th class="kt-align-center">{{trans('admin/dashboard.status')}}</th>
                        <th>{{trans('admin/user.email')}}</th>
                        <th class="kt-align-center">{{trans('admin/dashboard.created_by')}}</th>
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
