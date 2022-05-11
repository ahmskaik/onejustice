@extends('site.layout.layout')
@section('js')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var flag = true;
            jQuery(document).on("click", "#loadPosts", function () {
                var postsList = jQuery("#postsList");
                let self = jQuery(this);

                if (flag && self.attr("data-has-more") && self.attr("data-next-page")) {
                    flag = false;
                    jQuery.ajax({
                        url: self.attr("data-next-page"),
                        method: "GET",
                        dataType: "json",
                        beforeSend: function () {
                            jQuery(".loading-circle").removeClass("display-none");
                        },
                        success: function (data) {
                            jQuery(".loading-circle").addClass("display-none");
                            flag = true;
                            if (data.status) {
                                postsList.append(data.data);
                                self.attr({
                                    "data-has-more": data.hasMore,
                                    "data-next-page": data.nextPage
                                });
                                if (data.hasMore === 0) {
                                    self.addClass('display-none');
                                }
                            }
                        },
                        error: function (data) {
                            jQuery(".loading-circle").addClass("display-none");
                            flag = true;
                        }
                    });
                }
            });
        });
    </script>
@endsection
@section('content')
    <div id="mvp-main-body-wrap" class="left relative">
        <div class="mvp-main-blog-wrap left relative">
            <div class="mvp-main-box">
                <div class="mvp-main-blog-cont left relative">
                    <div class="mvp-main-blog-out left relative">
                        <div class="mvp-main-blog-in2">
                            @if($types)
                                <ul class="" id="block-categories-menu">
                                    @foreach($types as $type)
                                        <li class="">
                                            <a href="{{route('events.all',['type'=>$type->slug])}}">{{$type->text }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <div class="mvp-main-blog-body left relative" style="margin-top: 2rem;">
                                <div id="mvp-cat-feat-wrap" class="left relative">
                                    @if($main_event)
                                        <div class="mvp-widget-feat2-left left relative mvp-widget-feat2-left-alt">
                                            <a href="{{route('event.show',['id'=>$main_event->id,'type'=>  \Str::slug($main_event->type->syslkp_data->en ),'slug'=>\Str::slug($main_event->the_title)])}}"
                                               rel="bookmark">
                                                <div class="mvp-widget-feat2-left-cont left relative">
                                                    <div class="mvp-feat1-feat-img left relative">
                                                        <img width="560" height="600"
                                                             src="uploads/events/{{$main_event->cover_image}}"
                                                             class="attachment-mvp-port-thumb size-mvp-port-thumb"
                                                             alt="{{$main_event->the_title}}" loading="lazy"/>
                                                    </div>
                                                    <div class="mvp-feat1-feat-text left relative">
                                                        <div class="mvp-cat-date-wrap left relative">
                                                            <span
                                                                class="mvp-cd-cat left relative">{{$main_event->type->syslkp_data->{$locale}??
                                                                                                   $main_event->type->syslkp_data->{$fallbackLanguage} }}</span>
                                                            <span
                                                                class="mvp-cd-date left relative">{{date('Y-m-d',strtotime($main_event->date)) }}</span>
                                                        </div>
                                                        <h2>{{$main_event->the_title}}</h2>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="mvp-widget-feat2-right left relative">
                                        @if($type)
                                            <h1 class="mvp-feat1-pop-head">
                                                <span
                                                    class="mvp-feat1-pop-head">{{$type->syslkp_data->{$locale}  ??$type->text}}</span>
                                            </h1>
                                        @endif
                                        <div class="mvp-widget-feat2-right-main left relative">
                                            @foreach($featured_events as $event)
                                                <a href="{{route('event.show',['id'=>$event->id,'type'=>  \Str::slug($event->type->syslkp_data->en ),'slug'=>\Str::slug($event->the_title)])}}"
                                                   rel="bookmark">
                                                    <div class="mvp-widget-feat2-right-cont left relative">
                                                        <div class="mvp-widget-feat2-right-img left relative">
                                                            <img
                                                                src="{{loadImage($event->cover_image,'events',448,180,100,'',0)}}"
                                                                class="mvp-reg-img lazy"
                                                                alt="{{$event->the_title}}"
                                                                loading="lazy"
                                                            />
                                                            <img
                                                                width="80"
                                                                height="80"
                                                                src="{{loadImage($event->cover_image,'events',445,180,100,'',0)}}"
                                                                class="mvp-mob-img lazy"
                                                                alt=""
                                                                loading="lazy"
                                                            />
                                                        </div>
                                                        <div class="mvp-widget-feat2-right-text left relative">
                                                            <div class="mvp-cat-date-wrap left relative">
                                                                <span
                                                                    class="mvp-cd-cat left relative">{{$event->type->syslkp_data->{$locale}??$event->type->syslkp_data->{$fallbackLanguage} }}</span>

                                                                <span
                                                                    class="mvp-cd-date left relative">{{date('Y-m-d',strtotime($event->date))}}</span>
                                                            </div>
                                                            <h2>{{$event->the_title}}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <ul class="mvp-blog-story-list left relative infinite-content" id="postsList">
                                    @include('site.event.eventsListPart')
                                </ul>
                                @if($hasMore)
                                    <div class="mvp-inf-more-wrap left relative">
                                        <a href="javascript:;" class="mvp-inf-more-but" id="loadPosts"
                                           data-next-page="{{$nextPage}}"
                                           data-has-more="{{$hasMore}}">{{trans('site.more_posts')}}</a>
                                        <div class="mvp-nav-links">
                                        </div>
                                    </div>
                                    <div class="loading-circle display-none" style="width: 100%; text-align: center;">
                                        <div class="circle-loader">Loading...</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
