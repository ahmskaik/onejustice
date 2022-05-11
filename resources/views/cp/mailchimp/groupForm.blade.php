@extends('cp.layout.layout')

@section('css')
@endsection

@section('js')
    <script src="cp/js/formsValidation.js" type="text/javascript"></script>
    <script src="cp/js/pages/newsletter/create-group.js" type="text/javascript"></script>

    @include('cp.parts.toastr-alert')
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        {!! Form::open(['class'=>'form-validation horizontal-form form']) !!}
        <div class="kt-portlet kt-portlet--last kt-portlet--head-sm kt-portlet--responsive-mobile"
             id="kt_page_portlet">
            <div class="kt-portlet__head kt-portlet__head--sm" style="">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">{{$page_title}}</h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <a href="{{$cp_route_name."/".$route }}//groups" class="btn btn-clean kt-margin-r-10">
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
                                    <div class="col-md-12     @if ($errors->has('name')) has-error @endif">
                                        <div class="form-group">
                                            <label class="lblinput">Name <span
                                                    class="required"> * </span></label>
                                            @foreach($languages as $language)
                                                <div data-lang="{{$language->iso_code}}"
                                                     class="forminput-required switchable {{$language->iso_code==$locale ?"":"hidden"}}">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{$language->name}}</span>
                                                        </div>
                                                        <input data-name="name[{{$language->iso_code}}]"
                                                               name="name[{{strtolower($language->iso_code)}}]"
                                                               value="{{ $group->name->{strtolower($language->iso_code)}   ?? old("name[$language->iso_code]") }}"
                                                               type="text"
                                                               placeholder="Group Name"
                                                               class="form-control input-lang @if ($errors->has('name.'.strtolower($language->iso_code))) is-invalid @endif"/>
                                                        @if ($errors->has('name.'.strtolower($language->iso_code)))
                                                            <div
                                                                class="invalid-feedback">{{$errors->first('title.'.strtolower($language->iso_code)) }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
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
