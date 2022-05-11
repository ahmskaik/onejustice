@extends('cp.layout.layout')

@section('css')
@endsection

@section('js')
    <script src="cp/js/formsValidation.js" type="text/javascript"></script>
    <script src="cp/js/pages/newsletter/create-campaign.js" type="text/javascript"></script>
    <script src="cp/plugins/t-editor/t-editor.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            var _base = $("base").attr("href");

            $('[data-switch=true]').bootstrapSwitch();
            tinymce.init({
                selector: ".tinymce",
                menubar: false,
                theme: "modern",
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak code  ",
                    "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons paste textcolor responsivefilemanager youtube facebookembed instagram twitter"
                ],
                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                filemanager_title: "Filemanager",
                filemanager_crossdomain: false,
                external_filemanager_path: _base + "cp/plugins/t-editor/plugins/responsivefilemanager/filemanager/",
                external_plugins: {"filemanager": "plugins/responsivefilemanager/plugin.min.js"},
                toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect| fontsizeselect | code | print preview   ",
                toolbar2: "| responsivefilemanager | image | media | link unlink anchor | youtube | facebookembed | instagram | twitter",
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
                setup: function (editor) {
                    editor.on('change', function () {
                        tinymce.triggerSave();
                    });
                }
            });
        });
    </script>
    @include('cp.parts.toastr-alert')
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        {!! Form::open(['class'=>'form-validation horizontal-form form','files'=>true]) !!}
        <div class="kt-portlet kt-portlet--last kt-portlet--head-sm kt-portlet--responsive-mobile"
             id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--sm" style="">
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
                            <i class="la la-send"></i>
                            <span class="kt-hidden-mobile">{{trans('admin/dashboard.save')}}</span>
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
                                    <div class="col-md-6  @if ($errors->has('title')) has-error @endif">
                                        <div class="form-group">
                                            <label class="lblinput">Title <span
                                                    class="required"> * </span></label>
                                            <input name="title" value="{{ $campaignTitle ?? old("title") }}"
                                                   type="text" class="form-control txtinput-required"/>
                                            @if ($errors->has('title'))
                                                <span class="help-block error">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6  @if ($errors->has('subject')) has-error @endif">
                                        <div class="form-group">
                                            <label class="lblinput">Subject <span
                                                    class="required"> * </span></label>
                                            <input name="subject" value="{{ $campaignSubject ?? old("subject") }}"
                                                   type="text" class="form-control txtinput-required"/>
                                            @if ($errors->has('subject'))
                                                <span class="help-block error">{{ $errors->first('subject') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <label class="col-form-label col-lg-3 col-sm-12">Message Type</label>
                                            <div class="col-lg-4 col-md-9 col-sm-12">
                                                <input data-switch="true" type="checkbox"
                                                       @if((isset($type) && $type==1 )
                                                        || old("type")==1  || $errors->has('url')) checked @endif
                                                       name="type" value="1"
                                                       class="make-switch change-switchtype"
                                                       data-on-text="&nbsp;URL&nbsp;&nbsp;"
                                                       data-off-text="&nbsp;HTML&nbsp;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 @if ($errors->has('groups')) has-error @endif">
                                        <div class="form-group">
                                            <label>Groups</label>
                                            <div class="kt-checkbox-inline">
                                                @foreach($groups['interests'] as $group)
                                                    <label
                                                        class="kt-checkbox kt-checkbox--bold kt-checkbox--success parent-check">
                                                        <input type="checkbox"
                                                               class="mycheckbox ccheckbox"
                                                               data-parent="parent2"
                                                               name="groups[]"
                                                               value="{{ $group['id'] }}"
                                                            {{ (in_array($group['id'],$validGroups) ||
                                                                (is_array(old('groups'))&& in_array($group['id'],old('groups')))) ?"checked":"" }}>
                                                        {{ $group['name'].' ('.$group['subscriber_count'].' subscribers)' }}
                                                        <span></span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @if ($errors->has('groups'))
                                                <span class="help-block error">{{ $errors->first('groups') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="compaign-message-rg @if ($errors->first()==='html' || $errors->has('message') || $errors->has('url') ) has-error @endif">
                                    <label class="control-label">Message</label>
                                    <div class="row urlmessage-region kt-hidden">
                                        <div class="col-md-12">
                                            <div class="form-group input-wlbl">
                                                <input name="url" type="text" placeholder="URL"
                                                       class="form-control {{ isset($isUpdate)?"":"txtinput-required" }} txtinput-url inputmessage-url"
                                                       value="{{ $url ?? old("url") }}"/>
                                                @if ($errors->has('url'))
                                                    <span class="help-block error">{{ $errors->first('url') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group editorarea htmlmessage-region">
                                        <textarea name="message"
                                                  rows="20"
                                                  class="tinymce {{ isset($isUpdate)?"":"tinymce-required" }}">{!! $message ?? old("message") !!}</textarea>
                                        @if ($errors->first()==='html' || $errors->has('message'))
                                            <span
                                                class="help-block error">Schema describes string, NULL found instead</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
