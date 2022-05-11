@extends('cp.layout.layout')

@section('css')
    <link href="cp/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        #modal-viewdetails .modal-body * {
            max-width: 100% !important;
        }

        .iframe_preview {
            width: 100%;
            height: 500px;
        }
    </style>
@endsection

@section('js')
    <script src="cp/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="cp/js/pages/newsletter/campaign.js?v=2.0.6" type="text/javascript"></script>
    @include('cp.parts.toastr-alert')
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
                            <label class="lblinput">Compain Status</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select data-column="3" class="bs-select form-control searchableList">
                                    <option value="">All</option>
                                    <option value="save">Saved</option>
                                    <option value="sent">Sent</option>
                                    <option value="sending">Sending</option>
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                            <label class="lblinput">Send Time After</label>
                            <div class="input-group">
                                <input id="send_date" data-date-format="yyyy-mm-dd" data-column="5"
                                       type="text" class="form-control inputdateclear" aria-describedby="basic-addon2"
                                       placeholder="" readonly="" value=""/>

                                <div class="input-group-append"><span class="input-group-text" id="basic-addon2"><i
                                            class="la la-calendar"></i></span></div>
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
                        Campaigns List
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <div class="dropdown dropdown-inline">
                                <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> {{trans('admin/dashboard.export')}}
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
                       id="mydatatable"  data-count="{{ $membersCount }}">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th class="kt-align-center">Status</th>
                        <th class="kt-align-center">Opens</th>
                        <th class="kt-align-center">Creation Time</th>
                        <th class="kt-align-center">Send Time</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-sendtest" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(["class"=>"form-sendtest"]) !!}
                    <div class="alert alert-secondary" role="alert">
                        <div class="alert-text">
                            <h4 class="modal-title">Send Test</h4>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="input-wlbl">
                            <label class="control-label">Email</label>
                            <input name="emails" type="text" class="form-control input-sendtest" value=""
                                   data-role="tagsinput" placeholder="Emails"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success sentTestCampain">Send</button>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-viewdetails" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <iframe class="iframe_preview"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary">close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
