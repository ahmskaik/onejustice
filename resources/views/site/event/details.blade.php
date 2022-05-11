@extends('site.layout.layout')
@section('js')
    <div data-theiaStickySidebar-sidebarSelector='"#mvp-side-wrap,.mvp-post-soc-wrap,.mvp-flex-side-wrap,.mvp-alp-side"'
         data-theiaStickySidebar-options='{"containerSelector":"","additionalMarginTop":120,"additionalMarginBottom":20,"updateSidebarHeight":false,"minWidth":1004,"sidebarBehavior":"modern","disableOnResponsiveLayouts":true}'></div>

    <script type='text/javascript' src='assets/js/theia-sticky-sidebar.js?ver=1.7.0'></script>
    <script type='text/javascript' src='assets/js/share.js'></script>
@endsection
@section('content')
    <article id="mvp-event-wrap" itemscope itemtype="http://schema.org/NewsArticle">
        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage"
              itemid="#"/>
        <div id="mvp-article-cont" class="{{$locale==='ar'?'right':'left'}} relative">
            <div class="mvp-main-box">
                <div id="mvp-post-main" class="{{$locale==='ar'?'right':'left'}} relative">
                    <header id="mvp-post-head" class="{{$locale==='ar'?'right':'left'}} relative">
                        <h3 class="mvp-post-cat {{$locale==='ar'?'right':'left'}} relative">
                            <a class="mvp-post-cat-link" href="{{route('events.all',['type'=>$event->type->slug])}}">
                                <span class="mvp-post-cat {{$locale==='ar'?'right':'left'}}">{{$event->type->syslkp_data->{$locale} }}</span>
                            </a>
                        </h3>
                        <h1 class="mvp-post-title left entry-title" itemprop="headline">{{$event->the_title}}</h1>
                        <div class="mvp-author-info-wrap left relative">
                            <div class="mvp-author-info-text left relative">
                                <div class="mvp-author-info-date left relative">
                                    <p>{{trans('site.published')}}</p> <span
                                        class="mvp-post-date">{{getTimeLeft(strtotime($event->date),$locale)}}</span>
                                    <p>{{trans('site.on')}}</p> <span class="mvp-post-date updated">
                                        <time class="post-date updated"
                                              itemprop="datePublished"
                                              datetime="{{date('F d, Y',strtotime($event->date))}}">{{date('F d, Y',strtotime($event->date))}}</time>
                                    </span>
                                    <meta itemprop="dateModified" content="{{date('F d, Y',strtotime($event->date))}}"/>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="mvp-post-main-out left relative">
                        <div class="mvp-post-main-in">
                            <div id="mvp-post-content" class="left relative">
                                <div id="mvp-post-feat-img" class="left relative mvp-post-feat-img-wide2"
                                     itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                                    <img width="1000" height="600"
                                         src="uploads/events/{{$event->cover_image}}"
                                         class="attachment- size-" alt="" loading="lazy"
                                         srcset="uploads/events/{{$event->cover_image}} 1000w,
                                          uploads/events/{{$event->cover_image}} 600w,
                                           uploads/events/{{$event->cover_image}} 300w,
                                            uploads/events/{{$event->cover_image}} 768w,
                                             uploads/events/{{$event->cover_image}} 590w,
                                              uploads/events/{{$event->cover_image}} 400w"
                                         sizes="(max-width: 1000px) 100vw, 1000px"/>
                                    <meta itemprop="url"
                                          content="uploads/events/{{$event->cover_image}}">
                                    <meta itemprop="width" content="1000">
                                    <meta itemprop="height" content="600">
                                </div>
                                <div id="mvp-content-wrap" class="left relative">
                                    <div class="mvp-post-soc-out right relative">
                                        @include('site.event.share')
                                        <div class="mvp-post-soc-in">
                                            <div id="mvp-content-body" class="left relative">
                                                <div id="mvp-content-body-top" class="left relative">
                                                    <div id="mvp-content-main" class="left relative">
                                                        <div id="tps_slideContainer_76" class="theiaPostSlider_slides">
                                                            <div class="theiaPostSlider_preloadedSlide">
                                                                {!! $event->the_body !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="mvp-content-bot" class="left">
                                                        {{--@include('site.post.gallery')--}}
                                                        <div class="mvp-org-wrap" itemprop="publisher" itemscope
                                                             itemtype="https://schema.org/Organization">
                                                            <div class="mvp-org-logo" itemprop="logo" itemscope
                                                                 itemtype="https://schema.org/ImageObject">
                                                                <img
                                                                    src="{{url('assets/images/logos/logo-nav.png')}}"
                                                                    alt="{{$siteSetting['app_brand']->{$locale} }}"/>
                                                                <meta itemprop="url"
                                                                      content="{{url('assets/images/logos/logo-nav.png')}}}">
                                                            </div>
                                                            <meta itemprop="name"
                                                                  content="{{$siteSetting['app_brand']->{$locale} }}}">
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
                </div>

                <div id="mvp-post-more-wrap" class="left relative">
                    <h4 class="mvp-widget-home-title">
                        <span class="mvp-widget-home-title">{{trans('site.you_may_like')}}</span>
                    </h4>
                    <ul class="mvp-post-more-list left relative">
                        @foreach($events_may_like as $event)
                            <a href="{{route('event.show',['id'=>$event->id,'type'=>  \Str::slug($event->type->syslkp_data->en ),'slug'=>\Str::slug($event->the_title)])}}"
                               rel="bookmark">
                                <li>
                                    <div class="mvp-post-more-img left relative">
                                        <img width="400" height="240"
                                             src="{{loadImage($event->cover_image,'events',214,128,100,'',0)}}"
                                             class="mvp-reg-img" alt="{{$event->the_title}}" loading="lazy">
                                        <img width="80" height="80"
                                             src="{{loadImage($event->cover_image,'events',214,128,100,'',0)}}"
                                             class="mvp-mob-img"
                                             alt="{{$event->the_title}}" loading="lazy">
                                    </div><!--mvp-post-more-img-->
                                    <div class="mvp-post-more-text left relative">
                                        <div class="mvp-cat-date-wrap left relative">
                                            <span class="mvp-cd-date left relative">{{date('Y-m-d',strtotime($event->date))}}</span>
                                        </div>
                                        <p>{{$event->the_title}}</p>
                                    </div>
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </article>
@endsection
