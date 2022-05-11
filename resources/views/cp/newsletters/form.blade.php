@extends('cp.layout.layout')

@section('css')
    <style>
        .kt-avatar .kt-avatar__holder {
            width: 180px !important;
            height: 140px !important;
        }</style>
    <link href="cp/css/flag-inputs.css" rel="stylesheet" type="text/css"/>

@endsection

@section('js')
    <script src="cp/plugins/t-editor/t-editor.min.js" type="text/javascript"></script>
    <script src="cp/js/pages/t-editor.js" type="text/javascript"></script>
    <script src="cp/js/formsValidation.js" type="text/javascript"></script>
    <script src="cp/js/pages/newsletters/newsletterForm.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            formWorker.init();
            $('.kt-selectpicker').selectpicker();
        });
    </script>
    @include('cp.parts.toastr-alert')
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        {!! Form::open(['id'=>'newsletter-form','class'=>'horizontal-form form-nosubmit form','files'=>true]) !!}
        <input id="newsletter-id" type="hidden" name="id" value="{{ $newsletter->id }}">
        <input type="hidden" value="{{ print_r($errors) }}">
        <div class="kt-portlet kt-portlet--last kt-portlet--head-sm kt-portlet--responsive-mobile"
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
            <div class="col-9">
                <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile mt-2">
                    <div class="kt-portlet__body">
                        <div class="kt-form__body">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>Title: <span
                                                    class="required"> * </span></label>
                                            <input type="text"
                                                   class="form-control @if ($errors->has('title')) is-invalid @endif"
                                                   name="title"
                                                   placeholder="Title"
                                                   value="{{ $newsletter->title  ?? old("title") }}">
                                            @if ($errors->has('title'))
                                                <div class="invalid-feedback">{{$errors->first('title') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                            <label>Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fa fa-calendar-check"></i></span></div>

                                                <input type="text"
                                                       class="form-control datepicker-input @if ($errors->has('date')) is-invalid @endif"
                                                       placeholder="" readonly
                                                       name="date"
                                                       value="{{ $newsletter->date ? date('Y-m-d',strtotime($newsletter->date)): old('date') }}"/>
                                                @if ($errors->has('date'))
                                                    <div class="invalid-feedback">{{$errors->first('date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <label>Link</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fa fa-link"></i></span></div>
                                                <input type="text"
                                                       class="form-control @if ($errors->has('link')) is-invalid @endif"
                                                       placeholder=""
                                                       name="link"
                                                       value="{{ $newsletter->link ?? old('link') }}"/>
                                                @if ($errors->has('link'))
                                                    <div class="invalid-feedback">{{$errors->first('link') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>Details: <span
                                                    class="required"> * </span></label>
                                            <textarea type="text"
                                                      class="tinymce{{$locale==='ar'?'-rtl':''}} form-control @if ($errors->has('body')) is-invalid @endif"
                                                      name="body"
                                                      rows="7"
                                                      style="height: 200px;"
                                                      placeholder="Details">{!! $newsletter->body  ?? old("body")  !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="form-group input-wlbl">
                                                <label
                                                    class="lblinput lblinputtop">{{trans('admin/dashboard.created_by')}}</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="fa fa-user"></i></span></div>
                                                    <input type="text" class="form-control" readonly placeholder=""
                                                           disabled="disabled"
                                                           value="{{ $creator }}"/>
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
            <div class="col-3">
                <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile mt-2">
                    <div class="kt-portlet__body">
                        <div class="kt-form__body">
                            <div class="kt-section kt-section--first">
                                <div class="kt-section__body">
                                    <div class="form-group row">
                                        <label class="col-xl-12 col-lg-12 col-form-label text-center">
                                            Cover Image</label>
                                        <div
                                            class="col-lg-12 col-xl-12 text-center @if ($errors->has('cover_image')) is-invalid @endif">
                                            <div class="kt-avatar kt-avatar--outline" id="kt_add_avatar">
                                                <div class="kt-avatar__holder"
                                                     style="background-image: url({{$newsletter->getCoverImage()}})"></div>
                                                <label class="kt-avatar__upload" data-toggle="kt-tooltip" title=""
                                                       data-original-title="Change Cover Image">
                                                    <i class="fa fa-pen"></i>
                                                    <input type="file" name="cover_image">
                                                </label>
                                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title=""
                                                      data-original-title="Cancel avatar">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @if ($errors->has('cover_image'))
                                            <div class="invalid-feedback">{{$errors->first('cover_image') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 forminput-single-required">
                                            <label class="">Language: <span
                                                    class="required"> * </span></label>
                                            <select name="language_id"
                                                    data-live-search="true"
                                                    class="form-control kt-selectpicker select-required @if ($errors->has('language_id')) is-invalid @endif">
                                                @foreach($languages as $language)
                                                    <option
                                                        data-icon="ini__flag ini__{{strtolower($language->flag)}}"
                                                        @if($newsletter->language_id==$language->id
                                                            || (old("language_id")
                                                            &&old("language_id")==$newsletter->language_id)) selected="selected"
                                                        @endif
                                                        value="{{ $language->id }}">{{ $language->name}}</option>
                                                @endforeach
                                                @if ($errors->has('language_id'))
                                                    <div
                                                        class="invalid-feedback">{{$errors->first('language_id') }}</div>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <label class="col-8 col-form-label">Is Active?</label>
                                                <div class="col-4">
                                                <span class="kt-switch kt-switch--icon">
                                                    <label>
                                                        <input type="checkbox" name="is_active" value="1"
                                                               @if($newsletter && $newsletter->is_active) checked="checked"  @endif>
                                                        <span></span>
                                                    </label>
                                                </span>
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
        </div>

        {!! Form::close() !!}
    </div>
@endsection
