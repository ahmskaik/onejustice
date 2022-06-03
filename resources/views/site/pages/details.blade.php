@extends('site.layout.layout')
@section('content')
    <article id="mvp-article-wrap" itemscope itemtype="http://schema.org/NewsArticle">
        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage"
              itemid="#"/>
        <div id="mvp-article-cont" class="left relative">
            <div class="mvp-main-box">
                <div id="mvp-post-main" class="left relative">
                    <header id="mvp-post-head" style="padding: 13px 0 0 0;margin: 1rem 0 3rem 0"
                            class="left relative light-bg">
                        <h3 class="mvp-post-cat left relative">
                            <a>
                                <span style="border: none!important;font-size: 1.5rem !important;"
                                      class="mvp-post-cat left"> {{$title}} </span>
                            </a>
                        </h3>
                    </header>
                    <div class="mvp-post-main-out left relative">
                        <div class="mvp-post-main-in2">
                            <div id="mvp-post-content" class="left relative">
                                <div id="mvp-content-wrap" class="left relative">
                                    <div class="mvp-post-soc-out right relative">
                                        <div class="mvp-post-soc-in">
                                            <div id="mvp-content-body" class="left relative">
                                                <div id="mvp-content-body-top" class="left relative">
                                                    <div id="mvp-content-main" class="left relative">
                                                        <div id="tps_slideContainer_76" class="theiaPostSlider_slides">
                                                            <div class="theiaPostSlider_preloadedSlide">
                                                                {!! $data->the_body !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="mvp-content-bot" class="left">
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
                                                                  content="{{$siteSetting['app_brand']->{$locale}?? $siteSetting['app_brand']->{$fallbackLanguage} }}">
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
            </div>
        </div>
    </article>
@endsection
