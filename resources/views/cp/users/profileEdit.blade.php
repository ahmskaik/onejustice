@extends('cp.layout.layout')

@section('css')
@stop
@section('js')
    <script src="cp/js/formsValidation.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var flag = true;

            jQuery(document).on('change', '.upload-profile-img', function () {
                if (flag == true) {
                    flag = false;
                    var my_file = this.files[0];
                    var my_button = jQuery(this);
                    var size = parseInt(this.files[0].size);
                    size = size / 1024;
                    var file = jQuery(this).val();
                    var extension = file.substr((file.lastIndexOf('.') + 1)).toLowerCase();
                    var type = false;
                    if (extension == 'jpg' || extension == 'jpeg')
                        type = true;

                    if (size <= 4096 && type == true) {
                        var fd = new FormData();
                        fd.append("choose-file", my_file);
                        jQuery.ajax({
                            url: cp_route_name + '/uploadProfile',
                            type: 'POST',
                            data: fd,
                            cache: false,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            beforeSend: function () {
                                //    my_button.parent().append('<div class="loading-submit"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
                            },
                            success: function (data) {
                                flag = true;
                                //    my_button.parent().find('.loading-submit').remove();
                                if (data.status == true) {
                                    var src = "uploads/users/" + data.file_name;
                                    my_button.parents('.upload-avatar-img').css('background-image', 'url(' + src + ')');
                                } else {
                                    flag = true;
                                    var message = data.message;
                                    toasterMessage("error", message, "Upload Error");
                                }
                            }
                        });

                    } else {
                        flag = true;
                        my_button.parent().find('.loading-submit').remove();
                        jQuery(this).val("");
                        var message = '';
                        if (size > 4096)
                            message = 'size is too big';
                        if (type == false)
                            message = 'format not accepted';
                        toasterMessage("error", message, "Upload Error");
                    }
                }
            });

            jQuery(document).on('blur', '.form-control[data-validation]', function () {
                var this_input = jQuery(this);
                var input_url = this_input.attr('data-validation');
                var input_name = this_input.attr('name');
                var input_val = this_input.val();
                if ((flag == true) && (this_input.val())) {
                    flag = false;
                    jQuery.ajax({
                        type: 'POST',
                        data: {[input_name]: input_val},
                        url: input_url,
                        dataType: "json",
                        success: function (data) {
                            this_input.parent().find('.invalid-feedback').remove();
                            myflag = true;
                            if (data.status == true) {
                                this_input.removeClass('myerror');
                                this_input.parent().removeClass('has-error is-invalid');
                            } else {
                                this_input.addClass('myerror');
                                this_input.parent().addClass('has-error is-invalid');
                                this_input.parent().append('<span class="invalid-feedback">' + data[input_name][0] + '</span>');

                            }
                        }
                    });
                }
            });
        });
    </script>
    @if(isset($error))
        <script>
            jQuery(document).ready(function () {
                toastr.error('{{ $error }}');
                jQuery('#tabs-profile a').eq(1).click();
            });

        </script>
    @endif
    @include('cp.parts.toastr-alert',['position'=>'toast-bottom-right'])
@stop

@section('content')
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">
            @include("cp.users.profilePart")
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="kt-portlet kt-portlet--tabs">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">Profile Account</h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-right tabs-profile" id="tabs-profile"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab_1_1"
                                       role="tab" aria-selected="false">
                                        <i class="flaticon-user"></i> Personal Info
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                       href="#tab_1_2" role="tab" aria-selected="true">
                                        <i class="flaticon-cogwheel-2"></i> Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1_1" role="tabpanel">
                                {!! Form::model($result,['action'=>["Admin\UserController@updateProfile",$result->id],'class'=>'sticky-inputs kt-form form-validation form-datavalidation user-form', 'files' => true]) !!}
                                <div
                                    class="form-group input-wlbl @if ($errors->has('full_name')) has-error is-invalid @endif">
                                    <label class="lblinput">Ful Name</label>
                                    {!! Form::text('full_name',null,['class'=>'form-control txtinput-required']) !!}
                                    @if ($errors->has('full_name'))
                                        <span class="invalid-feedback">{{ $errors->first('full_name') }}</span>
                                    @endif
                                </div>
                                <div
                                    class="form-group input-wlbl @if ($errors->has('user_name')) has-error is-invalid @endif">
                                    <span class="lblinput">Username</span>
                                    {!! Form::text('user_name',null,['class'=>'form-control txtinput-required','data-validation'=>$cp_route_name.'/user/validateInput/'.$result->id]) !!}
                                    @if ($errors->has('user_name'))
                                        <span class="invalid-feedback">{{ $errors->first('user_name') }}</span>
                                    @endif
                                </div>
                                <div
                                    class="form-group input-wlbl @if ($errors->has('dob')) has-error is-invalid @endif">
                                    <span class="lblinput">Date of Birth</span>
                                    <div class="input-group">
                                        {!! Form::text('dob',null,['class'=>'form-control  datepicker-maxtoday','readonly'=>'','data-date-format'=>'yyyy-mm-dd']) !!}
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar-check"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('dob'))
                                        <span class="invalid-feedback">{{ $errors->first('dob') }}</span>
                                    @endif
                                </div>
                                <div
                                    class="form-group input-wlbl @if ($errors->has('email')) has-error is-invalid @endif">
                                    <span class="lblinput">Email</span>
                                    {!! Form::text('email',null,['class'=>'form-control txtinput-required txtinput-email','data-validation'=>$cp_route_name.'/user/validateInput/'.$result->id]) !!}
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div
                                    class="form-group input-wlbl @if ($errors->has('mobile')) has-error is-invalid @endif">
                                    <span class="lblinput">Mobile</span>
                                    {!! Form::text('mobile',null,['class'=>'form-control txtinput-required txtinput-filter-number txtinput-minlength','data-minlength'=>'6','maxlength'=>'15']) !!}
                                    @if ($errors->has('mobile'))
                                        <span class="invalid-feedback">{{ $errors->first('mobile') }}</span>
                                    @endif
                                </div>
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" class="btn btn-success btn-bold">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}

                            </div>
                            <div class="tab-pane" id="tab_1_2" role="tabpanel">
                                {!! Form::model($result,['action'=>["Admin\UserController@updatePasswordProfile",$result->id],'class'=>'sticky-inputs kt-form form-validation']) !!}
                                <div class="form-group input-wlbl">
                                    <span class="lblinput">Current Password</span>
                                    <input name="oldPassword" type="password" class="form-control txtinput-required"
                                           placeholder=""/>
                                </div>
                                <div class="form-group input-wlbl">
                                    <span class="lblinput">New Password</span>
                                    <input type="password" id="password_strength" name="password"
                                           class="form-control txtinput-required txtinput-minlength password-status myinput-password"
                                           data-minlength="6" placeholder="Password"/>
                                </div>
                                <div class="form-group input-wlbl">
                                                <span class="lblinput">
                                                Re-type New Password</span>
                                    <input name="confirm_password" type="password" class="form-control txtinput-related"
                                           data-related="password" placeholder="Confirm Password"/>
                                </div>
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" class="btn btn-success btn-bold">Change Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
