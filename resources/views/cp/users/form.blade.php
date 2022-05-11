@extends('cp.layout.layout')

@section('css')
    <link href="cp/css/permissions.css" rel="stylesheet" type="text/css"/>
@endsection

@section('js')
    <script src="cp/js/checkbox.js" type="text/javascript"></script>
    <script src="cp/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>
    <script src="cp/js/formsValidation.js" type="text/javascript"></script>
    <script src="cp/js/pages/user/userForm.js?v=1.0" type="text/javascript"></script>

    @include('cp.parts.toastr-alert')
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        {!! Form::model($result,['id'=>'user-form','class'=>'horizontal-form form user-form sticky-inputs','files'=>true]) !!}
        <input id="user-id" type="hidden" name="id" value="{{ $result->id }}">

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
                                <div class="upload-avatar-img" style="background-image: url({{$src }});">
                                    <i class="fa fa-cloud-upload-alt"></i>
                                    <input type="file" id="uploadfile-user" name="avatar"
                                           class="avatar-file"
                                           accept="image/*"/>
                                </div>
                                <div class="row">
                                    <div
                                        class="{{$result->id?" col-md-4":"col-md-6" }} forminput-single-required input-wlbl">
                                        <div class="form-group">
                                            <label class="lblinput">{{trans('admin/user.full_name')}} <span
                                                    class="required"> * </span></label>
                                            {!!Form::text('full_name',null,['class'=>'form-control txtnotnumber txtinput-required']) !!}
                                        </div>
                                        @if ($errors->has('full_name'))
                                            <span
                                                class="help-block error">{{$errors->first('full_name') }}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="{{$result->id?" col-md-4":"col-md-6" }} forminput-single-required input-wlbl">
                                        <div class="form-group">
                                            <label class="lblinput">{{trans('admin/user.user_name')}} <span
                                                    class="required"> * </span></label>
                                            <div class="">
                                                {!!Form::text('user_name',null,['class'=>'form-control txtinput-required','autocomplete'=>'off','data-validation'=>$cp_route_name.($result->id ?('/user/validateInput/'.$result->id): '/user/validateInput')]) !!}
                                            </div>
                                        </div>
                                        @if ($errors->has('user_name'))
                                            <span
                                                class="help-block error">{{$errors->first('user_name') }}</span>
                                        @endif
                                    </div>
                                    @if($result->id)
                                        <div class="col-md-4 input-wlbl">
                                            <div class="txt-wlbl">
                                                <span>{{trans('admin/user.password')}}</span>
                                                <a href="javascript:;" class="umodal2 mypopover"
                                                   data-modal="modal-changepassword">{{trans('admin/user.change_password')}}</a>
                                            </div>
                                            <input name="password" type="hidden" class="new-password"/>
                                            <input name="password_confirmation" type="hidden"
                                                   class="new-confirmpassword"/>
                                        </div>
                                    @endif
                                </div>
                                @if(!$result->id)
                                    <div class="row">
                                        <div
                                            class="col-md-6 password-strength input-wlbl strength-pass @if ($errors->has('password')) has-error @endif">
                                            <div class="form-group">
                                                <label class="lblinput">{{trans('admin/user.password')}} <span
                                                        class="required"> * </span></label>
                                                {!!Form::password('password',
                                                    [
                                                        'id'=>'password_strength',
                                                        'placeholder'=>trans('admin/user.password'),
                                                        'class'=>'form-control myinput-password txtinput-required txtinput-minlength',
                                                        'data-minlength'=>'6'
                                                    ])
                                                !!}
                                            </div>
                                            @if ($errors->has('password'))
                                                <span
                                                    class="help-block error">{{$errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div
                                            class="col-md-6 input-wlbl @if ($errors->has('password_confirmation')) has-error @endif">
                                            <label class="lblinput">{{trans('admin/user.confirm_password')}} <span
                                                    class="required"> * </span></label>
                                            {!!Form::password('password_confirmation',
                                                [
                                                    'placeholder'=>trans('admin/user.confirm_password'),
                                                    'class'=>'form-control txtinput-related',
                                                    'data-related'=>'password'
                                                ])
                                            !!}
                                            @if ($errors->has('password_confirmation'))
                                                <span
                                                    class="help-block error">{{$errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div
                                        class="col-md-4 forminput-single-required input-wlbl @if ($errors->has('email')) has-error @endif">
                                        <div class="form-group">
                                            <label class="lblinput">{{trans('admin/user.email')}} </label>
                                            {!!Form::text('email',null,['class'=>'form-control txtinput-required txtinput-email','data-validation'=>$cp_route_name.($result->id ?('/user/validateInput/'.$result->id): '/user/validateInput')]) !!}
                                        </div>
                                        @if ($errors->has('email'))
                                            <span
                                                class="help-block error">{{$errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="col-md-4 input-wlbl  @if ($errors->has('dob')) has-error @endif">
                                        <div class="form-group">
                                            <label class="lblinput">{{trans('admin/user.dob')}} </label>
                                            <div class="input-group">
                                                {!!Form::text('dob',null,['class'=>'form-control  datepicker-maxtoday','readonly'=>'','data-date-format'=>'yyyy-mm-dd']) !!}
                                                <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-calendar-check"></i>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->has('dob'))
                                            <span
                                                class="help-block error">{{$errors->first('dob') }}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="col-md-4 input-wlbl formvalid-mobile  @if ($errors->has('mobile')) has-error @endif">
                                        <div class="form-group">
                                            <label class="lblinput">{{trans('admin/user.mobile')}} </label>
                                            {!!Form::text('mobile',null,['class'=>'form-control txtinput-filter-number txtinput-minlength','data-minlength'=>'6','maxlength'=>'15']) !!}
                                        </div>
                                        @if ($errors->has('mobile'))
                                            <span
                                                class="help-block error">{{$errors->first('mobile') }}</span>
                                        @endif
                                    </div>
                                </div>

                                @if(!$isProfile)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group select2-wlbl selectrole-rg">
                                                <label class="lblselect">{{trans('admin/user.user_role')}}</label>
                                                {!!Form::select('roleid', $roles, NULL,["class"=>"form-control role-dropdown myselect2 select2-required","data-placeholder"=>"Role"]) !!}
                                                <span
                                                    class="form-text text-muted">{{trans('admin/user.can_add_new_role')}}</span>
                                                @if ($errors->has('roleid'))
                                                    <span
                                                        class="help-block error">{{$errors->first('roleid') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group input-wlbl">
                                                <label
                                                    class="lblinput">{{trans('admin/user.custom_role')}}</label>
                                                {!!Form::text('is_customized',(isset($result))?NULL:"No",['class'=>'form-control input-customrole txtinput-filter-number','readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <label></label>

                                            <div class="row">
                                                <label class="col-form-label col-lg-3 col-sm-12">
                                                    {{trans('admin/dashboard.status')}}</label>
                                                <div class="col-lg-9 col-md-9 col-sm-12">
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
                                @endif
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group input-wlbl">
                                                        <span
                                                            class="lblinput lblinputtop">{{trans('admin/dashboard.created_by')}}</span>
                                            {!!Form::text('',$creator,['class'=>'form-control',"readonly"]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group input-wlbl">
                                                        <span
                                                            class="lblinput lblinputtop">{{trans('admin/user.last_login')}}</span>
                                            {!!Form::text('',$lastLogin,['class'=>'form-control',"readonly"]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group input-wlbl">
                                                        <span
                                                            class="lblinput lblinputtop">{{trans('admin/user.last_ip')}}</span>
                                            {!!Form::text('',$lastIP,['class'=>'form-control',"readonly"]) !!}
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
            <span class="help-block error">{{$errors->first('action') }}</span>
        @endif
        @if(!$isProfile)
            @include("cp.parts.roles.permission")
        @endif
        {!! Form::close() !!}
    </div>

@endsection
