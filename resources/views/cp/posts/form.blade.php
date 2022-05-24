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
    <script src="cp/plugins/t-editor/t-editor.min.js?v=2.0.1" type="text/javascript"></script>
    <script src="cp/js/pages/t-editor.js?v=2.0.1" type="text/javascript"></script>
    <script src="cp/js/formsValidation.js" type="text/javascript"></script>
    <script src="cp/js/pages/posts/postForm.js" type="text/javascript"></script>
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

        {!! Form::open(['id'=>'post-form','class'=>'horizontal-form form-nosubmit form','files'=>true]) !!}
        <input id="post-id" type="hidden" name="id" value="{{ $post->id }}">
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
                                                   value="{{ $post->title  ?? old("title") }}">
                                            @if ($errors->has('title'))
                                                <div class="invalid-feedback">{{$errors->first('title') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <label>Summary: <span
                                                    class="required"> * </span></label>
                                            <textarea type="text"
                                                      class="form-control @if ($errors->has('summary')) is-invalid @endif"
                                                      name="summary"
                                                      rows="5"
                                                      placeholder="Summary">{{ $post->summary  ?? old("summary") }}</textarea>
                                            @if ($errors->has('summary'))
                                                <div class="invalid-feedback">{{$errors->first('summary') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Keywords</label>
                                            <div>
                                                <input class="tags-input tagify"
                                                       type="text"
                                                       name="tags"
                                                       placeholder="Tags"
                                                       value="{{ $post->tags ?? old('tags')}}">
                                                <span class="form-text text-muted">Use related keywords</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fa fa-calendar-check"></i></span></div>
                                                <input type="text"
                                                       class="form-control datepicker-input @if ($errors->has('date')) is-invalid @endif"
                                                       placeholder="" readonly
                                                       name="date"
                                                       value="{{ $post->date ? date('Y-m-d',strtotime($post->date)): old('date') }}"/>
                                                @if ($errors->has('date'))
                                                    <div class="invalid-feedback">{{$errors->first('date') }}</div>
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
                                                      rows="10"
                                                      style="height: 550px;"
                                                      placeholder="Details">{!! $post->body  ?? old("body")  !!}</textarea>
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
                                                     style="background-image: url({{$post->getCoverImage()}})"></div>
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
                                                        @if($post->language_id==$language->id
                                                            || (old("language_id")
                                                            &&old("language_id")==$post->language_id)) selected="selected"
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
                                        <div class="col-lg-12 forminput-single-required">
                                            <label class="">Category: <span
                                                    class="required"> * </span></label>
                                            <select name="category_id"
                                                    class="form-control select-required @if ($errors->has('category_id')) is-invalid @endif">
                                                @foreach($categories as $category)
                                                    <option
                                                        @if($post->category_id==$category->id
                                                            || (old("category_id")
                                                            &&old("category_id")==$post->category_id)) selected="selected"
                                                        @endif
                                                        value="{{ $category->id }}">{{ $category->category_name}}</option>
                                                @endforeach
                                                @if ($errors->has('category_id'))
                                                    <div
                                                        class="invalid-feedback">{{$errors->first('category_id') }}</div>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 forminput-single-required">
                                            <label class="">Type: <span
                                                    class="required"> * </span></label>
                                            <select name="type_id"
                                                    class="form-control select-required @if ($errors->has('type_id')) is-invalid @endif">
                                                @foreach($types as $type)
                                                    <option
                                                        @if($post->type_id==$type->id
                                                            || (old("type_id")
                                                            &&old("type_id")==$post->type_id)) selected="selected"
                                                        @endif
                                                        value="{{ $type->id }}">{{ $type->text}}</option>
                                                @endforeach
                                                @if ($errors->has('type_id'))
                                                    <div
                                                        class="invalid-feedback">{{$errors->first('type_id') }}</div>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-12 forminput-single-required">
                                            <label class="">Status: <span
                                                    class="required"> * </span></label>
                                            <select name="status_id"
                                                    class="form-control select-required @if ($errors->has('status_id')) is-invalid @endif">
                                                @foreach($statuses as $status)
                                                    <option
                                                        @if($post->status_id==$status->id
                                                            || (old("status_id")
                                                            &&old("status_id")==$post->status_id)) selected="selected"
                                                        @endif
                                                        value="{{ $status->id }}">{{ $status->text}}</option>
                                                @endforeach
                                                @if ($errors->has('status_id'))
                                                    <div
                                                        class="invalid-feedback">{{$errors->first('status_id') }}</div>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <label
                                                    class="col-6 col-form-label">Show in slider?</label>
                                                <div class="col-6">
                                                <span class="kt-switch kt-switch--icon">
                                                    <label>
                                                        <input type="checkbox" name="is_featured"
                                                               value="1"
                                                               @if($post && $post->is_featured) checked="checked"  @endif>
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
