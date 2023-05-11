@extends('cp.layout.layout')

@section('css')
    <link href="cp/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <style> .select2-selection--single {
            padding-left: 25px;
        }</style>
@endsection

@section('js')
    <script src="cp/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="cp/js/pages/posts/list.js?v=1.0.1" type="text/javascript"></script>
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile search-form-rg">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-search"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{trans('admin/dashboard.search_form')}}
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <form class="horizontal-form search-form kt-form kt-form--fit">
                    <div class="row">
                        <div class="col-lg-3 ">
                            <label class="lblinput">{{trans('admin/post.search_keywords')}}</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <input type="text" class="form-control kt-input searchable"
                                       placeholder="{{trans('admin/post.search_keywords')}}"
                                       data-col-index="1" data-column="1">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-2 ">
                            <label class="lblinput">{{trans('admin/post.language')}}</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select class="form-control kt-input searchable-list" id="language_id"
                                        name="language_id">
                                    <option value="">{{trans('admin/dashboard.all')}}</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->id }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-2 ">
                            <label class="lblinput">{{trans('admin/post.category')}}</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select class="form-control kt-input searchable"
                                        data-col-index="2" data-column="2" name="category_id">
                                    <option value="">{{trans('admin/dashboard.all')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <div class="btn-search-reset">
                                <button type="button" class="btn btn-primary btn-brand--icon btn-submit-search"
                                        id="kt_search">
                                    <span>
                                        <i class="la la-search"></i>
                                        <span>{{trans('admin/dashboard.search')}}</span>
                                    </span>
                                </button>
                                <button type="reset" class="btn btn-secondary btn-secondary--icon btn-reset"
                                        id="kt_reset">
                                    <span>
                                        <i class="la la-close"></i>
                                        <span>{{trans('admin/dashboard.reset')}}</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                            <label class="btn d-block"></label>
                            <button type="button"
                                    class="btn btn-secondary btn-outline-success pull-right js-show-advance-filter">
                                    <span>
                                        <i class="flaticon2-dashboard"></i>
                                      <span>{{trans('admin/dashboard.advanced_filter')}}</span>
                                    </span>
                            </button>
                        </div>
                    </div>
                    <div class="row js-advance-filter-row mt-4 kt-hidden">
                        <div class="col-lg-3 ">
                            <label class="lblinput">{{trans('admin/post.type')}}</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select class="form-control kt-input searchable"
                                        id="type_id"
                                        data-col-index="11" data-column="11" name="type_id">
                                    <option value="">{{trans('admin/dashboard.all')}}</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->text }}</option>
                                    @endforeach
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                       <span><i class="la la-search"></i></span>
                                   </span>
                            </div>
                        </div>

                        <div class="col-lg-3 ">
                            <label class="lblinput">{{trans('admin/post.relevant_countries')}}</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select class="form-control kt-input searchable-list myselect2" id="country_id"
                                        name="country_id">
                                    <option value="">{{trans('admin/dashboard.all')}}</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-2 ">
                            <label class="lblinput">{{trans('admin/post.in_slider')}}?</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select id="is_featured" class="form-control kt-input searchable"
                                        data-col-index="9" data-column="9"
                                        name="is_featured">
                                    <option value="">{{trans('admin/dashboard.all')}}</option>
                                    <option value="1">{{trans('admin/dashboard.yes')}}</option>
                                    <option value="0">{{trans('admin/dashboard.no')}}</option>
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-2 ">
                            <label class="lblinput">{{trans('admin/post.status')}}</label>
                            <div class="kt-input-icon kt-input-icon--left">
                                <select class="form-control kt-input searchable"
                                        data-col-index="3" data-column="3" name="status_id">
                                    <option value="">{{trans('admin/dashboard.all')}}</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->text }}</option>
                                    @endforeach
                                </select>
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                     <span><i class="la la-search"></i></span>
                                 </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-list"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        {{trans('admin/post.posts')}}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <div class="dropdown dropdown-inline">
                                <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> {{trans('admin/dashboard.export')}}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__section kt-nav__section--first">
                                            <span class="kt-nav__section-text">Choose an option</span>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a
                                                data-href="{{$cp_route_name}}/{{$route}}/list?export=xlsx&amp;"
                                                href="{{$cp_route_name}}/{{$route}}/list?export=xlsx&amp;"
                                                class="kt-nav__link exportData">
                                                <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                                <span class="kt-nav__link-text">Export to Excel</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a data-href="{{$cp_route_name}}/{{$route}}/list?export=csv&amp;"
                                               href="{{$cp_route_name}}/{{$route}}/list?export=csv&amp;"
                                               class="kt-nav__link exportData">
                                                <i class="kt-nav__link-icon la la-file-text-o"></i>
                                                <span class="kt-nav__link-text">Export to CSV</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a target="_blank"
                                               data-href="{{$cp_route_name}}/{{$route}}/list?export=pdf&amp;"
                                               href="{{$cp_route_name}}/{{$route}}/list?export=pdf&amp;"
                                               class="kt-nav__link exportData">
                                                <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                                <span class="kt-nav__link-text">Export to PDF</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <a href="{{ $cp_route_name  }}/{{ $route }}/create"
                               class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{trans('admin/dashboard.add_new')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body" id="data-list">
                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                       id="mydatatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{trans('admin/post.title')}}</th>
                        <th class="kt-align-center">{{trans('admin/post.category')}}</th>
                        <th class="kt-align-center">{{trans('admin/post.status')}}</th>
                        <th class="kt-align-center">{{trans('admin/post.views')}}</th>
                        {{-- <th class="kt-align-center">{{trans('admin/dashboard.created_by')}}</th>--}}
                        <th class="kt-align-center">{{trans('admin/dashboard.date')}}</th>
                        <th class="tblaction-rg kt-align-center">{{trans('admin/dashboard.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
