
@extends('cp.layout.layout')

@section('css')

@endsection

@section('js')
    <script src="cp/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
    <script src="cp/plugins/global/highcharts/js/highcharts.js" type="text/javascript"></script>
    <script src="cp/plugins/global/highcharts/js/highcharts-3d.js" type="text/javascript"></script>
    <script src="cp/plugins/global/highcharts/js/highcharts-more.js" type="text/javascript"></script>
    <script src="cp/plugins/global/highcharts/js/modules/exporting.js"></script>
    <script src="cp/js/dashboard.js" type="text/javascript"></script>
@endsection

@section('content')
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet" style="background: transparent">
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-lg">
                    <div class="col-md-12 col-lg-6 col-xl-6 pr-2 mt-sm-2">
                        <div class="bg-white kt-widget24 dashboard-stat">
                            <a>
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                           Posts
                                        </h4>
                                    </div>
                                    <div class="visual">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-brand"  data-counter="counterup" data-value="{{$postsCount}}">
                                   0
                                </span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-6 pr-2 mt-sm-2">
                        <div class="bg-white kt-widget24 dashboard-stat">
                            <a>
                                <div class="kt-widget24__details">
                                    <div class="kt-widget24__info">
                                        <h4 class="kt-widget24__title">
                                            Views
                                        </h4>
                                    </div>
                                    <div class="visual">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-warning" data-counter="counterup" data-value="{{number_format($postsViews)}}">
                                   0
                                </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6 order-lg-1 order-xl-1">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Visitors Counties View
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div id="report_chart_country" class="CSSAnimationChart chart-showing"></div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 order-lg-1 order-xl-1">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                VISITORS AND PAGE VIEWS
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div id="report_chart_visitors" class="CSSAnimationChart chart-showing"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6 order-lg-1 order-xl-1">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Most Visited Pages
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div id="report_chart_most_visited" class="CSSAnimationChart chart-showing"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 order-lg-1 order-xl-1">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Recent Posts
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-widget5">
                            @foreach($posts as $post)
                                <div class="kt-widget5__item">
                                    <div class="kt-widget5__content">
                                        <div class="kt-widget5__pic">
                                            <a href="{{route('edit_post',['id'=>$post->id])}}"
                                               class="kt-widget5__title">
                                                <img class="kt-widget7__img"
                                                     src="{{loadImage($post->cover_image,'posts',110,110,80,'',0)}}"
                                                     alt="">
                                            </a>
                                        </div>
                                        <div class="kt-widget5__section">
                                            <a href="{{route('edit_post',['id'=>$post->id])}}"
                                               class="kt-widget5__title">
                                                {{$post->title}}
                                            </a>
                                            <p class="kt-widget5__desc">
                                                {{\Str::limit($post->summary, 100)}}
                                            </p>

                                        </div>
                                    </div>
                                    <div class="kt-widget5__content">
                                        <div class="kt-widget5__stats">
                                            {{getTimeLeft(strtotime($post->date),$locale)}}
                                        </div>
                                        <div class="kt-widget5__stats">

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
