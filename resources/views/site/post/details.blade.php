@extends('site.layout.layout')
@section('js')
    <div data-theiaStickySidebar-sidebarSelector='"#mvp-side-wrap,.mvp-post-soc-wrap,.mvp-flex-side-wrap,.mvp-alp-side"'
         data-theiaStickySidebar-options='{"containerSelector":"","additionalMarginTop":120,"additionalMarginBottom":20,"updateSidebarHeight":false,"minWidth":1004,"sidebarBehavior":"modern","disableOnResponsiveLayouts":true}'></div>

    <script type='text/javascript' src='assets/js/theia-sticky-sidebar.js?ver=1.7.0'></script>
    <script type='text/javascript' src='assets/js/share.js'></script>
@endsection
@section('content')
    <article id="mvp-article-wrap" itemscope itemtype="http://schema.org/NewsArticle">
        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage"
              itemid="#"/>
        <div id="mvp-article-cont" class="left relative light-bg" style="padding: 0!important;">
            <div class="mvp-main-box">
                <div id="mvp-post-main" class="left relative">
                    <header id="mvp-post-head" class="left relative">
                        <h3 class="mvp-post-cat left relative">
                            <a class=""
                               href="{{route('site.home')}}">
                                <span  style="border: none!important;"  class="mvp-post-cat left"> {{trans('site.home')}} | </span>
                            </a>
                            <a class="mvp-post-cat-link"
                               href="{{route('site.getPostsByCategory',['category'=>strtolower(str_replace(' ','_',$post->category->slug))])}}">
                                <span
                                    class="mvp-post-cat left">{{$post->category->name->{$locale}??$post->category->name->{$fallbackLanguage} }}</span>
                            </a>
                        </h3>
                        <h1 class="mvp-post-title left entry-title" itemprop="headline">{{$post->title}}</h1>
                        <span class="mvp-post-excerpt left">
                            <p>{{$post->summary}}</p>
                        </span>
                        <div class="mvp-author-info-wrap left relative">
                            <div class="mvp-author-info-text left relative">
                                <div class="mvp-author-info-date left relative">
                                    <p>{{trans('site.published')}}</p> <span
                                        class="mvp-post-date">{{getTimeLeft(strtotime($post->date),$locale)}}</span>
                                    <p>{{trans('site.on')}}</p> <span class="mvp-post-date updated">
                                        <time class="post-date updated"
                                              itemprop="datePublished"
                                              datetime="{{date('F d, Y',strtotime($post->date))}}">{{date('F d, Y',strtotime($post->date))}}</time>
                                    </span>
                                    <meta itemprop="dateModified" content="{{date('F d, Y',strtotime($post->date))}}"/>
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
                                         src="uploads/posts/{{$post->cover_image}}"
                                         class="" alt="" loading="lazy"
                                         srcset="uploads/posts/{{$post->cover_image}} 1000w,
                                          uploads/posts/{{$post->cover_image}} 600w,
                                           uploads/posts/{{$post->cover_image}} 300w,
                                            uploads/posts/{{$post->cover_image}} 768w,
                                             uploads/posts/{{$post->cover_image}} 590w,
                                              uploads/posts/{{$post->cover_image}} 400w"
                                         sizes="(max-width: 1000px) 100vw, 1000px"/>
                                    <meta itemprop="url"
                                          content="uploads/posts/{{$post->cover_image}}">
                                    <meta itemprop="width" content="1000">
                                    <meta itemprop="height" content="600">
                                </div>
                                <div id="mvp-content-wrap" class="left relative">
                                    <div class="mvp-post-soc-out right relative">
                                        @include('site.post.share')
                                        <div class="mvp-post-soc-in">
                                            <div id="mvp-content-body" class="left relative">
                                                <div id="mvp-content-body-top" class="left relative">
                                                    <div id="mvp-content-main" class="left relative">
                                                        <div id="tps_slideContainer_76" class="theiaPostSlider_slides">
                                                            <div class="theiaPostSlider_preloadedSlide"
                                                                 style="font-size: 20px;">
                                                                {!! $post->body !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="mvp-content-bot" class="left">
                                                        {{--@include('site.post.gallery')--}}
                                                        @if(json_decode($post->tags))
                                                            <div class="mvp-post-tags">
                                                                <span
                                                                    class="mvp-post-tags-header">{{trans('site.related_topics')}}:</span>
                                                                <span itemprop="keywords">
                                                              @foreach(json_decode($post->tags) as $tag)
                                                                        <a href="#" rel="tag">{{$tag}}</a>
                                                                    @endforeach
                                                            </span>
                                                            </div>
                                                        @endif
                                                        <div class="mvp-org-wrap" itemprop="publisher" itemscope
                                                             itemtype="https://schema.org/Organization">
                                                            <div class="mvp-org-logo" itemprop="logo" itemscope
                                                                 itemtype="https://schema.org/ImageObject">
                                                                <img
                                                                    src="{{url('assets/images/logos/logo-nav.png')}}"
                                                                    alt="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}"/>
                                                                <meta itemprop="url"
                                                                      content="{{url('assets/images/logos/logo-nav.png')}}}">
                                                            </div>
                                                            <meta itemprop="name"
                                                                  content="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mvp-cont-read-wrap">
                                                    <hr>
                                                    <div id="mvp-related-posts" class="left relative">
                                                        <h4 class="mvp-widget-home-title">
                                                            <span style="font-size: 1vw;"
                                                                  class="mvp-widget-home-title">{{trans('site.you_may_like')}}</span>
                                                        </h4>
                                                        <ul class="mvp-related-posts-list left related">
                                                            @foreach($posts_may_like as $post)
                                                                <a href="{{route('post.show',['id'=>$post->id,'category'=>strtolower($post->category->slug),'slug'=>$post->slug])}}"
                                                                   rel="bookmark">
                                                                    <li>
                                                                        <div class="mvp-related-img left relative">
                                                                            <img width="400" height="240"
                                                                                 src="{{loadImage($post->cover_image,'posts',214,128,100,'',0)}}"
                                                                                 class="mvp-reg-img"
                                                                                 alt="{{$post->title}}"
                                                                                 loading="lazy"/>
                                                                            <img width="80" height="80"
                                                                                 src="{{loadImage($post->cover_image,'posts',214,128,100,'',0)}}"
                                                                                 class="mvp-mob-img"
                                                                                 alt="{{$post->title}}"
                                                                                 loading="lazy">
                                                                            @if(!empty($post->type->syslkp_data->icon))
                                                                                <div
                                                                                    class="mvp-vid-box-wrap mvp-vid-box-mid">
                                                                                    <i class="{{$post->type->syslkp_data->icon}}"
                                                                                       aria-hidden="true"></i>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="mvp-related-text left relative">
                                                                            <p>{{$post->title}} {{--{{\Str::limit($post->title, 230)}}--}}</p>
                                                                        </div>
                                                                    </li>
                                                                </a>
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
                        <div id="mvp-side-wrap" class="left relative theiaStickySidebar">
                            <section class="mvp-side-widget mvp_tabber_widget">
                                <div class="mvp-widget-tab-wrap left relative">
                                    <div class="mvp-feat1-list-wrap left relative">
                                        <div class="mvp-feat1-list left relative">
                                            <span class="mvp-widget-home-title"
                                                  style="font-size: 1vw!important;border: solid 3px #fb772c;">{{trans('site.read_also')}}</span>
                                            @foreach($related_posts as $post)
                                                <a href="{{route('post.show',['id'=>$post->id,'category'=>strtolower($post->category->slug),'slug'=>$post->slug])}}"
                                                   rel="bookmark">
                                                    <div class="mvp-feat1-list-cont left relative">
                                                        <div class="mvp-feat1-list-out relative">
                                                            <div class="mvp-feat1-list-img left relative">
                                                                <img width="80" height="80"
                                                                     src="{{loadImage($post->cover_image,'posts',80,80,100,'',0)}}"
                                                                     class="attachment-mvp-small-thumb size-mvp-small-thumb"
                                                                     alt="{{$post->title}}" loading="lazy"/></div>
                                                            <div class="mvp-feat1-list-in">
                                                                <div class="mvp-feat1-list-text">
                                                                    <div class="mvp-cat-date-wrap left relative">
                                                                        <span
                                                                            class="mvp-cd-cat left relative">{{$post->category->name->{$locale}??$post->category->name->{$fallbackLanguage}  }}</span><span
                                                                            class="mvp-cd-date left relative">{{getTimeLeft(strtotime($post->date),$locale)}}</span>
                                                                    </div>
                                                                    <h2>{{$post->title}}</h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection
