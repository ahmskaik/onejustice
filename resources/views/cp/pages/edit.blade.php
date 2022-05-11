@extends('cp.layout.layout')

@section('css')
    <style>
        /* .pages-tabs-nav {
             min-height: 45px !important;
             background-color: #32c5d2;
         }

         .pages-tabs-nav * {
             color: #fff !important;
         }*/

        .nav-tabs.nav-tabs-line.nav.nav-tabs .nav-link:hover, .nav-tabs.nav-tabs-line.nav.nav-tabs .nav-link.active, .nav-tabs.nav-tabs-line a.nav-link:hover, .nav-tabs.nav-tabs-line a.nav-link.active {
            border-bottom: 3px solid #fff;
        }

    </style>
@endsection

@section('js')
    <script src="cp/plugins/t-editor/t-editor.min.js" type="text/javascript"></script>
    <script src="cp/js/pages/t-editor.js" type="text/javascript"></script>


    @include('cp.parts.toastr-alert')

@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <form action="{{route('update_pages')}}" class="horizontal-form form user-form sticky-inputs" method="POST">
            @csrf
            <div class="kt-portlet kt-portlet--tabs">
                <div class="kt-portlet__head pages-tabs-nav">
                    <div class="kt-portlet__head-label">
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <input type="hidden" class="hdn-staticpages" name="tabIndex" value="{{ $tabIndex }}"/>
                        <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-right" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#about_us"
                                   role="tab" aria-selected="false">
                                    <i class="flaticon-medal"></i> About Us
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#terms"
                                   role="tab" aria-selected="false">
                                    <i class="flaticon-cogwheel-2"></i> Terms and Conditions
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab"
                                   href="#safety" role="tab" aria-selected="true">
                                    <i class="flaticon-info"></i> Safety
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab"
                                   href="#accessibility" role="tab" aria-selected="true">
                                    <i class="flaticon-info"></i> Accessibility
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab"
                                   href="#contact_us" role="tab" aria-selected="true">
                                    <i class="flaticon-information"></i> Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="tab-content">
                        @include("cp.pages.part",
                       [
                           "post_id"=>$about_us->id,
                           "id"=>"about_us",
                           "titleValue"=>'About Us',
                           "detailsName"=>"about_us",
                           "details"=>$about_us->body,
                           "active"=>true
                       ])
                        @include("cp.pages.part",
                       [
                           "post_id"=>$terms->id,
                           "id"=>"terms",
                           "titleValue"=>'Terms and Conditions',
                           "detailsName"=>"terms",
                           "details"=>$terms->body,
                       ])
                        @include("cp.pages.part",
                     [
                         "post_id"=>$safety->id,
                         "id"=>"safety",
                         "titleValue"=>'Safety',
                         "detailsName"=>"safety",
                         "details"=>$safety->body,
                     ])
                        @include("cp.pages.part",
                     [
                         "post_id"=>$accessibility->id,
                         "id"=>"accessibility",
                         "titleValue"=>'Accessibility',
                         "detailsName"=>"accessibility",
                         "details"=>$accessibility->body,
                     ])
                        @include("cp.pages.part",
                 [
                     "post_id"=>$contact_us->id,
                     "id"=>"contact_us",
                     "titleValue"=>'Contact Us',
                     "detailsName"=>"contact_us",
                     "details"=>$contact_us->body,
                 ])
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">Save &amp; continue</button>
                        <a href="{{$cp_route_name."/".$route }}"
                           class="btn btn-secondary">{{trans('admin/dashboard.back')}}</a>
                    </div>
                </div>

            </div>
        </form>

    </div>
@endsection
