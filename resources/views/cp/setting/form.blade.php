@extends('cp.layout.layout')

@section('css')
    <link href="cp/css/flag-inputs.css" rel="stylesheet" type="text/css"/>

    <style type="text/css">
        .settings-content .input-group-prepend .input-group-text:nth-child(2) {
            width: 220px;
            text-align: initial;
            border-right: none;
        }

        .permissions-checks ul {
            padding-left: 0 !important;
        }
    </style>
@stop

@section('js')
    <script src="cp/js/checkbox_log.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('[data-switch=true]').bootstrapSwitch();
            $('.kt-selectpicker').selectpicker();
        });
    </script>
@stop

@section('content')

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet settings-content">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        System Settings
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-right" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tabs_1_1" role="tab">General
                                Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_2" role="tab">Content Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tabs_1_3" role="tab">Social Media
                                Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-portlet__body">
                {!!Form::open(['action'=>'Admin\SettingController@update','class'=>'form-validation']) !!}
                <div class="tab-content">
                    <div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-wcheckbox-rg">
                                    <div class="form-group row kt-margin-t-20">
                                        <label class="col-form-label col-lg-2 col-sm-12">Website Status</label>
                                        <div class="col-lg-10 col-md-10 col-sm-12">
                                            <input name="is_open"
                                                   value="1"
                                                   data-switch="true"
                                                   type="checkbox"
                                                   class="make-switch systemclose-checkbox"
                                                {{$siteSetting['is_open'][0] == 1?"checked":"" }}
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Active Theme</label>
                                    <select class="form-control" name="active_theme">
                                        <option value="1"
                                                @if($siteSetting["active_theme"][0]==1) selected @endif> One Main Slider</option>
                                        <option value="2"
                                                @if($siteSetting["active_theme"][0]==2) selected @endif>Three Main Slider</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Website Brand - en</label>
                                    <input type="text" name="app_brand[en]"
                                           value="{{$siteSetting["app_brand"]->en }}"
                                           class="form-control" placeholder="Application Brand"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Website Brand - ar</label>
                                    <input type="text" name="app_brand[ar]"
                                           value="{{$siteSetting["app_brand"]->ar }}"
                                           class="form-control" placeholder="Application Brand"/>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Contact Phone</label>
                                    <input type="text" name="contact_phone"
                                           value="{{$siteSetting["contact_phone"][0] }}"
                                           class="form-control" placeholder="Contact Phone"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Contact Email</label>
                                    <input type="text" name="contact_email"
                                           value="{{$siteSetting["contact_email"][0] }}"
                                           class="form-control" placeholder="Contact Email"/>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2 col-sm-12">Languages</label>
                                    <div class="col-lg-10 col-md-9 col-sm-12">
                                        <select class="form-control kt-selectpicker" id="languages_list"
                                                name="languages[]" data-live-search="true"
                                                multiple="multiple">
                                            @foreach($languages as $language)
                                                <option
                                                    @if($language->is_active) selected @endif
                                                data-icon="ini__flag ini__{{strtolower($language->flag)}}"
                                                    value="{{$language->id}}">{{$language->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="kt_tabs_1_2" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group input-wlbl">
                                    <span class="lblinput">Meta Description - English</span>
                                    <textarea name="meta_description[en]"
                                              class="form-control">{{$siteSetting["meta_description"]->en }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-wlbl">
                                    <span class="lblinput">Meta Description - Arabic</span>
                                    <textarea name="meta_description[ar]"
                                              class="form-control">{{ $siteSetting["meta_description"]->ar }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group input-wlbl">
                                    <span class="lblinput">Welcome Message - English</span>
                                    <textarea name="welcome_message[en]" rows="5"
                                              class="form-control">{{$siteSetting["welcome_message"]->en }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group input-wlbl">
                                    <span class="lblinput">Welcome Message - Arabic</span>
                                    <textarea name="welcome_message[ar]" rows="5"
                                              class="form-control">{{ $siteSetting["welcome_message"]->ar }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="kt_tabs_1_3" role="tabpanel">
                        @foreach($siteSetting["social_accounts"] as $key=>$account)
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-{{$key}}"></i></span>
                                        <span class="input-group-text">https://{{$key}}.com/</span>
                                    </div>
                                    <input name="social_accounts[{{$key}}]" value="{{$account}}" type="text"
                                           class="form-control"
                                           placeholder=""/>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary"> Save Changes</button>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@stop
