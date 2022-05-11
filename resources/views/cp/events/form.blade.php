@extends('cp.layout.layout')

@section('css')
@endsection

@section('js')
    <script src="cp/plugins/t-editor/t-editor.min.js" type="text/javascript"></script>
    <script src="cp/js/pages/t-editor.js" type="text/javascript"></script>
    <script src="cp/js/formsValidation.js" type="text/javascript"></script>
    <script src="cp/js/pages/events/eventForm.js" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            formWorker.init();
        });
    </script>
    @include('cp.parts.toastr-alert')
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        {!! Form::open(['id'=>'event-form','class'=>'horizontal-form form-nosubmit form','files'=>true]) !!}
        <input id="event-id" type="hidden" name="id" value="{{ $event->id }}">
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
                                            @foreach($languages as $language)
                                                <div data-lang="{{$language->iso_code}}"
                                                     class="input-wlbl forminput-required switchable {{$language->iso_code==$locale ?"":"hidden"}}">
                                                    <input data-name="title[{{$language->iso_code}}]"
                                                           name="title[{{strtolower($language->iso_code)}}]"
                                                           value="{{ $event->title->{strtolower($language->iso_code)}
                                                            ?? old("title[$language->iso_code]") }}"
                                                           type="text"
                                                           placeholder="Title"
                                                           class="form-control input-lang"/>
                                                    @if ($errors->has('title.'.$language->iso_code))
                                                        <div
                                                            class="invalid-feedback">{{$errors->first('title'.$language->iso_code) }}</div>
                                                    @endif
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fa fa-calendar-check"></i></span></div>

                                                <input type="text"
                                                       class="form-control datepicker-input @if ($errors->has('date')) is-invalid @endif"
                                                       placeholder="" readonly
                                                       name="date"
                                                       value="{{ $event->date ? date('Y-m-d',strtotime($event->date)): old('date') }}"/>
                                                @if ($errors->has('date'))
                                                    <div class="invalid-feedback">{{$errors->first('date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Link</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fa fa-link"></i></span></div>
                                                <input type="text"
                                                       class="form-control @if ($errors->has('link')) is-invalid @endif"
                                                       placeholder=""
                                                       name="link"
                                                       value="{{ $event->link ?? old('link') }}"/>
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
                                            @foreach($languages as $language)
                                                <div data-lang="{{$language->iso_code}}"
                                                     class="input-wlbl forminput-required switchable {{$language->iso_code==$locale ?"":"hidden"}}">
                                                    <textarea type="text"
                                                              data-name="body[{{$language->iso_code}}]"
                                                              class="input-lang tinymce{{$locale==='ar'?'-rtl':''}} form-control @if ($errors->has('body')) is-invalid @endif"
                                                              name="body[{{strtolower($language->iso_code)}}]"
                                                              rows="10"
                                                              style="height: 550px;"
                                                              placeholder="Details">{!! $event->body->{strtolower($language->iso_code)}
                                                            ?? old("body[$language->iso_code]")!!}</textarea>


                                                    @if ($errors->has('body.'.$language->iso_code))
                                                        <div
                                                            class="invalid-feedback">{{$errors->first('body'.$language->iso_code) }}</div>
                                                    @endif
                                                </div>
                                            @endforeach


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
                                                     style="background-image: url({{$event->getCoverImage()}})"></div>
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
                                            <label class="">Type: <span
                                                    class="required"> * </span></label>
                                            <select name="type_id"
                                                    class="form-control select-required @if ($errors->has('type_id')) is-invalid @endif">
                                                @foreach($types as $type)
                                                    <option
                                                        @if($event->type_id==$type->id
                                                            || (old("type_id")
                                                            &&old("type_id")==$event->type_id)) selected="selected"
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
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <label class="col-8 col-form-label">Is Active?</label>
                                                <div class="col-4">
                                                <span class="kt-switch kt-switch--icon">
                                                    <label>
                                                        <input type="checkbox" name="is_active" value="1"
                                                               @if($event && $event->is_active) checked="checked"  @endif>
                                                        <span></span>
                                                    </label>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <label class="col-8 col-form-label">Is featured?</label>
                                                <div class="col-4">
                                                        <span class="kt-switch kt-switch--icon">
                                                            <label>
                                                                <input type="checkbox" name="is_featured" value="1"
                                                                       @if($event && $event->is_featured) checked="checked"  @endif>
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

            {!! Form::close() !!}
        </div>
@endsection
