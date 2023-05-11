@extends('cp.layout.layout')

@section('css')
    <style>
        .kt-notification .kt-notification__item:after {
            content: "" !important
        }</style>
@endsection

@section('js')
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
                                            {{trans('admin/post.posts')}}
                                        </h4>
                                    </div>
                                    <div class="visual">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-brand" data-counter="counterup"
                                          data-value="{{$postsCount}}">
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
                                            {{trans('admin/post.views')}}
                                        </h4>
                                    </div>
                                    <div class="visual">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <span class="kt-widget24__stats kt-font-warning" data-counter="counterup"
                                          data-value="{{number_format($postsViews)}}">
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
                                {{trans('admin/post.recent_posts')}}
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
                                                {{\Str::limit($post->title, 50)}}
                                            </a>
                                            <p class="kt-widget5__desc">
                                                {{\Str::limit($post->summary, 70)}}
                                            </p>

                                        </div>
                                    </div>
                                    <div class="kt-widget5__content">
                                        <div class="kt-widget5__stats px-0">
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
            <div class="col-md-12 col-lg-6 order-lg-1 order-xl-1">
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                {{trans('admin/dashboard.last_inquires')}}
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-notification">
                            @foreach($inquires as $inquiry)
                                <a class="kt-notification__item" href="{{route('inquiry_show',['id'=>$inquiry->id])}}" target="_blank">
                                    <div class="kt-notification__item-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                             viewBox="0 0 24 24" version="1.1" class="kt-svg-icon kt-svg-icon--brand">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path
                                                    d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z"
                                                    fill="#000000"></path>
                                                <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5"
                                                        r="2.5"></circle>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="kt-notification__item-details">
                                        <div class="kt-notification__item-title">
                                            {{\Str::limit(cleanString($inquiry->message), 100)}}
                                        </div>
                                        <div class="kt-notification__item-time">
                                            {{$inquiry->name}}
                                            <small class="pull-right">
                                                {{getTimeLeft(strtotime($inquiry->created_at),$locale)}}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
