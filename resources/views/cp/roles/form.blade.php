@extends('cp.layout.layout')

@section('css')
    <link href="cp/css/permissions.css" rel="stylesheet" type="text/css"/>
@endsection

@section('js')
    <script src="cp/js/checkbox.js" type="text/javascript"></script>
    <script src="cp/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            $('[data-switch=true]').bootstrapSwitch();
        });
    </script>
    @include('cp.parts.toastr-alert')
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        {!! Form::model($result,['id'=>'role-form','class'=>'horizontal-form form role-form sticky-inputs','files'=>true]) !!}

        <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile"
             id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--lg" style="">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{$page_title}}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{$cp_route_name."/".$route }}" class="btn btn-clean kt-margin-r-10">
                        <i class="la la-arrow-left"></i>
                        <span class="kt-hidden-mobile">{{trans('admin/dashboard.back')}}</span>
                    </a>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success" name="save-close-btn" id="save-close-btn">
                            <i class="la la-check"></i>
                            <span class="kt-hidden-mobile">{{trans('admin/dashboard.save_exit')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile">
                    <div class="kt-portlet__body">
                        <div class="horizontal-form">
                            <div class="form-body">
                                <div class="row">
                                    <div
                                        class="col-md-6 forminput-single-required input-wlbl @if ($errors->has('name')) has-error @endif">
                                        <div class="form-group">
                                            <label class="lblinput">Role Name <span
                                                    class="required"> * </span></label>
                                            {!! Form::text('name',null,['class'=>'form-control txtnotnumber txtinput-required']) !!}
                                            @if ($errors->has('name'))
                                                <span class="help-block error">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <label> </label>
                                        <div class="row">
                                            <label class="col-form-label col-lg-2 col-sm-12 col-md-2">
                                                {{trans('admin/dashboard.status')}}</label>
                                            <div class="col-lg-10 col-md-10 col-sm-12">
                                                {!!Form::checkbox('status',1,$status,
                                                    ['class'=>'make-switch',
                                                     "data-on-text"=>trans('admin/dashboard.active'),
                                                       "data-off-text"=>trans('admin/dashboard.inActive'),
                                                    'data-switch'=>"true"
                                                    ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="form-group input-wlbl">
                                            <label
                                                class="lblinput lblinputtop">{{trans('admin/dashboard.creation_date')}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fa fa-calendar-check"></i></span></div>
                                                <input type="text" class="form-control" readonly placeholder=""
                                                       disabled="disabled"
                                                       value="{{ $created_at }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->has('action'))
            <span class="help-block error">{{ $errors->first('action') }}</span>
        @endif
        @include("cp.parts.roles.permission")

        {!! Form::close() !!}
    </div>

@endsection
