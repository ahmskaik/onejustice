<!DOCTYPE html>
<html lang="{{$locale??'en'}}" dir="{{$locale==='ar'?'rtl':'ltr'}}">
<head>
    <base href="{{ URL::asset('/') }}"></base>
    <meta charset="utf-8"/>
    <title>{{ $title &&!empty($title) ? $title: trans('admin/dashboard.brand')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @if($locale==='ar')
        <link href="cp/plugins/global/plugins.bundle.rtl.css?v=2.5.3" rel="stylesheet" type="text/css"/>
        <link href="cp/css/style.bundle.rtl.css?v=2.5.3" rel="stylesheet" type="text/css"/>
    @else
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500">
        <link href="cp/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
        <link href="cp/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    @endif

    @yield('css')
    <link href="cp/css/custom.css?v=1.3.2" rel="stylesheet" type="text/css"/>

    <link rel="shortcut icon" href="cp/media/logos/favicon.ico"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body
    class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{url($cp_route_name)}}">
            <img alt="Logo" src="cp/media/logos/logo-light.png" width="80"/>
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left"
                id="kt_aside_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                class="flaticon-more-1"></i></button>
    </div>
</div>

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            @include('cp.layout.header')
            <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
                <div class="kt-container  kt-container--fluid  kt-grid kt-grid--ver">

                    @include('cp.layout.menu')
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                            <div class="kt-container  kt-container--fluid ">
                                <div class="kt-subheader__main">
                                    @isset($breadcrumbs)
                                        <div class="kt-subheader__breadcrumbs">
                                            {!! generateBreadcrumbs($breadcrumbs) !!}
                                        </div>
                                    @endisset
                                </div>

                                @if(isset($show_language_bar) && $show_language_bar)
                                    <div id="languages-navbar" class="languages-navbar kt-header-menu">
                                        @include('cp.parts.language_nav')
                                    </div>
                                @endif
                                <div class="kt-subheader__toolbar">
                                    @yield('nav-actions')

                                    @if(isset($show_current_date) && $show_current_date)
                                        <div class="kt-subheader__wrapper">
                                            <a href="javascript:;" class="btn kt-subheader__btn-daterange">
                                            <span class="kt-subheader__btn-daterange-title"
                                                  id="kt_dashboard_daterangepicker_title">Today</span>&nbsp;
                                                <span class="kt-subheader__btn-daterange-date"
                                                      id="kt_dashboard_daterangepicker_date">{{date('F d, Y')}}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                                     viewBox="0 0 24 24" version="1.1"
                                                     class="kt-svg-icon kt-svg-icon--sm">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path
                                                            d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        <path
                                                            d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                            fill="#000000"/>
                                                    </g>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('cp.layout.footer')
        </div>
    </div>
</div>
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>
<script>
    const cp_route_name = '{{$cp_route_name}}';
    var globals = @json($globals);
</script>
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<script src="cp/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="cp/js/scripts.bundle.js" type="text/javascript"></script>

@yield('js')
<script src="cp/js/main.js?v=1.0.2" type="text/javascript"></script>

</body>
</html>
