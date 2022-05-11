@extends('cp.layout.layout')

@section('css')
@endsection

@section('js')
    <script src="cp/js/formsValidation.js" type="text/javascript"></script>
    <script src="cp/js/pages/category/categoryForm.js" type="text/javascript"></script>
    <style>
        .kt-portlet.kt-portlet--head-lg .kt-portlet__head {
            min-height: 60px;
        }

        .upload-avatar-img {
            width: 80px !important;
            height: 80px !important;
            border-radius: 7px !important;
            margin: 0 !important;
        }

        .upload-avatar-img:before {
            border-radius: 7px !important;
        }
    </style>
    <script>
        jQuery(document).ready(function () {
            formWorker.init("{{ $route }}");
        });
    </script>
    @include('cp.parts.toastr-alert')

@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        {!! Form::open(['id'=>'category-form','class'=>'horizontal-form form','files'=>true]) !!}
        <input id="category-id" type="hidden" name="id" value="{{ $category->id }}">
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
            <div class="kt-portlet__body">
                <div class="kt-form__body">
                    <div class="kt-section__body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row mb-0">
                                    <div class="col-lg-8 forminput-required">
                                        <label>{{trans('admin/category.category_name')}} <span
                                                class="required"> * </span></label>
                                        @foreach($languages as $language)
                                            <div data-lang="{{$language->iso_code}}"
                                                 class="input-wlbl forminput-required switchable {{$language->iso_code==$locale ?"":"hidden"}}">
                                                <input data-name="title[{{$language->iso_code}}]"
                                                       name="category[title][{{strtolower($language->iso_code)}}]"
                                                       value="{{ $category->name->{strtolower($language->iso_code)}
                                                            ?? old("title[$language->iso_code]") }}"
                                                       type="text"
                                                       placeholder="{{trans('admin/category.category_name')}}"
                                                       class="form-control input-lang"/>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-lg-4 forminput-required">
                                        <label>{{trans('admin/category.slug')}} <span
                                                class="required"> * </span></label>
                                        <input
                                            name="category[slug]"
                                            value="{{ $category->slug ?? old("slug") }}"
                                            type="text"
                                            placeholder="{{trans('admin/category.slug')}}"
                                            class="form-control"/>
                                    </div>
                                </div>
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <label
                                                class="col-6 col-form-label">{{trans('admin/dashboard.status')}} </label>
                                            <div class="col-6">
                                            <span class="kt-switch kt-switch--icon">
                                                <label>
                                                    <input type="checkbox" name="category[is_active]"
                                                           value="1"
                                                           @if($category && $category->is_active) checked="checked"  @endif>
                                                    <span></span>
                                                </label>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <label
                                                class="col-6 col-form-label">{{trans('admin/category.show_on_top')}}</label>
                                            <div class="col-6">
                                    <span class="kt-switch kt-switch--icon">
                                        <label>
                                            <input type="checkbox" name="category[is_featured]"
                                                   value="1"
                                                   @if($category && $category->is_featured ) checked="checked"   @endif>
                                            <span></span>
                                        </label>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-sm"></div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-6 control-label"
                                                   style="top: 21px;">{{trans('admin/category.icon')}}
                                                :
                                            </label>
                                            <div class="col-md-6">
                                                <div class="upload-avatar-img"
                                                     style="background-image: url({{$icon }});">
                                                    <i class="flaticon-upload"></i>
                                                    <input type="file"
                                                           name="icon"
                                                           class="avatar-file uploadfile-thumb"
                                                           accept="image/*"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-6 control-label"
                                                   style="top: 21px;"> {{trans('admin/category.main_image')}}
                                            </label>
                                            <div class="col-md-6">
                                                <div class="upload-avatar-img"
                                                     style="background-image: url({{$main_image}});">
                                                    <i class="flaticon-upload"></i>
                                                    <input type="file"
                                                           name="main_image"
                                                           class="avatar-file uploadfile-thumb"
                                                           accept="image/*"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-separator kt-separator--border-dashed kt-separator--space-lg"></div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-group input-wlbl">
                                            <label
                                                class="lblinput lblinputtop">{{trans('admin/dashboard.created_by')}}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                            class="fa fa-user"></i></span></div>
                                                <input type="text" class="form-control" readonly placeholder=""
                                                       disabled="disabled"
                                                       value="{{$creator}}"/>
                                            </div>
                                        </div>
                                    </div>
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
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{trans('admin/category.parent_category')}}
                                        <span class="required">*</span> </label>
                                    <div class="border border-success p-3">
                                        <div class="kt-scroll" data-scroll="true" data-height="340"
                                             data-mobile-height="200" data-always-visible="1">
                                            <ul class="kt-checkbox-list list-unstyled">
                                                <li>
                                                    <label class="kt-radio kt-radio--success kt-font-boldest">
                                                        <input type="radio"
                                                               @if($category && is_null( $category->parent_id )) checked
                                                               @endif
                                                               name="product[categories][]"
                                                               value="">{{trans('admin/dashboard.root')}}
                                                        <span></span>
                                                    </label>
                                                </li>
                                                @foreach($categories as $_category)
                                                    <li>
                                                        @if(isset($category->id) && $category->id==$_category->id)
                                                            <label class="kt-radio kt-radio--success">
                                                                <i class="fa fa-stop"></i> {{ '#'.$_category->id.' '. $_category->title}}
                                                            </label>
                                                            {{--@if(sizeof($_category->subCategories))
                                                                @include('cp.categories.parts.subCategoriesList',['type'=>'radio','subCategories' => $_category->subCategories])
                                                            @endif--}}
                                                        @else
                                                            <label class="kt-radio kt-radio--success">
                                                                <input type="radio"
                                                                       @if($category && $category->parent_id ==$_category->id) checked
                                                                       @endif
                                                                       name="product[categories][]"
                                                                       value="{{$_category->id}}">{{ $_category->title}}
                                                                <span></span>
                                                            </label>
                                                            @if(sizeof($_category->subCategories))
                                                                @include('cp.categories.parts.subCategoriesList',['type'=>'radio','subCategories' => $_category->subCategories])
                                                            @endif
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
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
