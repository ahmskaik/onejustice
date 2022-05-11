@extends('cp.layout.layout')

@section('css')
    <style>
        .kt-portlet.kt-portlet--head-lg .kt-portlet__head {
            min-height: 60px;
        }

        .form-group-xs {
            border-bottom: dashed 1px #dbdbdb;
        }
    </style>
@endsection

@section('js')
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
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
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-8">
                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <div class="kt-infobox">
                            <div class="kt-infobox__header">
                                <h2 class="kt-infobox__title">{{$inquiry->title}}</h2>
                            </div>
                            <div class="kt-infobox__body">
                                <div class="kt-infobox__section">
                                    <div class="kt-infobox__content">
                                        {{$inquiry->message}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">Name:</label>
                            <div class="col-8">
                                <span class="form-control-plaintext kt-font-bolder">{{$inquiry->name}}</span>
                            </div>
                        </div>
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">Email:</label>
                            <div class="col-8">
                                <span class="form-control-plaintext kt-font-bolder">{{$inquiry->email}}</span>
                            </div>
                        </div>
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">Mobile:</label>
                            <div class="col-8">
                                <span class="form-control-plaintext kt-font-bolder">{{$inquiry->mobile}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">IP:</label>
                            <div class="col-8">
                                <span class="form-control-plaintext kt-font-bolder">{{$inquiry->ip?? '--'}}</span>
                            </div>
                        </div>
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">Device Name:</label>
                            <div class="col-8">
                                <span
                                    class="form-control-plaintext kt-font-bolder">{{$inquiry->device_name?? '--'}}</span>
                            </div>
                        </div>
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">System Name:</label>
                            <div class="col-8">
                                <span
                                    class="form-control-plaintext kt-font-bolder">{{$inquiry->device_systemName?? '--'}}</span>
                            </div>
                        </div>
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">System Version:</label>
                            <div class="col-8">
                                <span
                                    class="form-control-plaintext kt-font-bolder">{{$inquiry->device_systemVersion ?? '--'}}</span>
                            </div>
                        </div>
                        <div class="form-group form-group-xs row">
                            <label class="col-4 col-form-label">Date:</label>
                            <div class="col-8">
                                <span
                                    class="form-control-plaintext kt-font-bolder">{{date('Y-m-d',strtotime($inquiry->created_at))}}</span>
                            </div>
                        </div>
                        @if($inquiry->seen_at)
                            <div class="form-group form-group-xs row">
                                <label class="col-4 col-form-label">Seen on:</label>
                                <div class="col-8">
                                    <span class="form-control-plaintext">
                                        <span
                                            class="kt-badge kt-badge--inline kt-badge--success kt-badge--bold">{{date('Y-m-d',strtotime($inquiry->seen_at))}}</span>
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
