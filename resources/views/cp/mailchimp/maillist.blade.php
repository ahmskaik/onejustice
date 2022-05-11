@extends('cp.layout.layout')

@section('css')
    <link href="cp/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .js-modal-wrapper {
            min-height: 50px;
        }
    </style>
@endsection

@section('js')
    <script src="cp/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="cp/js/pages/newsletter/lists.js?v=1.0.6" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            lists.init({!! json_encode($groups)  !!});
        });
    </script>
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
                            <label class="lblinput">Group</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select data-column="3" class="bs-select form-control searchable-list"
                                        id="interest_ids">
                                    <option value="">All</option>
                                    @foreach($groups as $key=>$group)
                                        <option value="{{$key}}">{{$group}}</option>
                                    @endforeach
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                            <label class="lblinput">Status</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select data-column="4" class="bs-select form-control searchable-list" id="status">
                                    <option value="">All</option>
                                    <option value="subscribed">Subscribed</option>
                                    <option value="unsubscribed">Unsubscribed</option>
                                    <option value="cleaned">Cleaned</option>
                                    <option value="pending">Pending</option>
                                    <option value="transactional">Transactional</option>
                                    <option value="archived">Archived</option>
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
                        {{$page_title}}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ $cp_route_name }}/{{$route}}/{{ $routeAlt }}/subscribe"
                               data-target="#modal-updatemember" data-toggle="modal"
                               class="btn btn-brand btn-elevate btn-icon-sm btn-addmemeber">
                                <i class="fa fa-user-plus"></i>
                                Add Member
                            </a>
                            <a href="javascript:;"
                               data-target="#modal-import" data-toggle="modal"
                               class="btn btn-success btn-elevate btn-icon-sm btn-modalimport">
                                <i class="la la-file-excel-o"></i>
                                Import contacts from excel file
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body" id="data-list">
                <table class="table table-bordered table-hover table-checkable order-column"
                       id="mydatatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="kt-align-center">Groups</th>
                        <th class="kt-align-center">Status</th>
                        <th class="kt-align-center">Subscription date</th>
                        <th class="kt-align-center">Subscription IP</th>
                        <th class="kt-align-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-updatemember" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="js-modal-wrapper">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Contacts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form action="{{$cp_route_name}}/newsletter/maillist/importList"
                      class="form-validation kt-form js-import-contacts-form" id=js-import-contacts-form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>File Browser</label>
                                    <div class="custom-file btn-fileimport">
                                        <input type="file" name="contactsFile"
                                               class="custom-file-input file-import upload-list"
                                               id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose .csv file</label>
                                    </div>
                                    <span class="form-text text-muted">CSV file should contain column with 'email_address' name contains emails. <a
                                            target="_blank" href="{{url('uploads/exports/file.csv')}}">Download from here</a></span>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <div class="form-group">
                                    <label>Groups</label>
                                    <div class="kt-checkbox-inline">
                                        @foreach($groups as $key=>$group)
                                            <label
                                                class="kt-checkbox kt-checkbox--bold kt-checkbox--success parent-check">
                                                <input type="checkbox"
                                                       class="mycheckbox ccheckbox"
                                                       data-parent="parent2"
                                                       name="groups[]"
                                                       value="{{ $key }}"> {{ $group }}
                                                <span></span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="progress progress-striped" style="display:none">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
