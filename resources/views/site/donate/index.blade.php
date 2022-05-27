@extends('site.layout.layout')
@section('css')
    <style>

        .featured-fluid-section {
            position: relative;
            padding: 0px;
            min-height: 250px;
            background: #f9f9f9;
        }

        .featured-fluid-section .column {
            position: relative;
            display: block;
            float: left;
            width: 50%;
        }

        .featured-fluid-section .image-column {
            position: absolute;
            left: 0px;
            top: 0px;
            width: 50%;
            height: 150%;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            float: right;
        }

        .clearfix:before {
            display: table;
            content: " ";
        }

        .featured-fluid-section .text-column {
            float: right;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .featured-fluid-section .text-column .content-box {
            position: relative;
            max-width: 600px;
            padding-left: 15px;
        }

        .featured-fluid-section .dark-column .content-box {
            padding: 88px 15px 101px 75px;
            color: #a8a8a8;
        }

        .pull-left {
            float: left !important;
        }

        .featured-fluid-section .dark-column:before {
            content: '';
            position: absolute;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background: rgba(25, 25, 25, 0.95);
        }

        .featured-fluid-section.style-two .dark-column:before {
            background: rgba(106, 198, 16, 0.95);
        }

        .featured-fluid-section .dark-column h2 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            line-height: 1.2em;
        }

        .featured-fluid-section .dark-column .title-text {
            position: relative;
            color: #ffffff;
            font-size: 18px;
            font-weight: 300;
            margin-bottom: 40px;
            padding-bottom: 15px;
        }

        .featured-fluid-section.style-two .dark-column .title-text a {
            color: #ffffff;
        }

        .featured-fluid-section .dark-column .title-text:after {
            content: '';
            position: absolute;
            top: 100%;
            width: 30px;
            height: 3px;
            background: #6ac610;
            color: #ffffff;
        }

        .featured-fluid-section.style-two .dark-column .title-text:after {
            background: #ffffff;
        }

        .featured-fluid-section .theme-btn {
            margin-right: 15px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .featured-fluid-section .dark-column .text {
            position: relative;
            color: #d5d5d5;
            font-size: 15px;
            margin-bottom: 50px;
        }

        .featured-fluid-section.style-two .dark-column .text {
            color: #f2f2f2;
        }
    </style>
@endsection

@section('js')
    <div data-theiaStickySidebar-sidebarSelector='"#mvp-side-wrap,.mvp-post-soc-wrap,.mvp-flex-side-wrap,.mvp-alp-side"'
         data-theiaStickySidebar-options='{"containerSelector":"","additionalMarginTop":120,"additionalMarginBottom":20,"updateSidebarHeight":false,"minWidth":1004,"sidebarBehavior":"modern","disableOnResponsiveLayouts":true}'></div>

@endsection
@section('content')
    <article id="mvp-article-wrap" itemscope itemtype="http://schema.org/NewsArticle">
        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage"
              itemid="#"/>
        <div id="mvp-article-cont" class="{{$locale==='ar'?'right':'left'}} relative">
            <section class="featured-fluid-section">
                <div class="outer clearfix">
                    <div class="image-column" style="background-image:url(assets/images/donate.jpg);"></div>
                    <article class="column text-column dark-column wow fadeInRight animated" data-wow-delay="0ms"
                             data-wow-duration="1500ms"
                             style="background-image: url(&quot;images/resource/fluid-image-2.jpg&quot;); visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInRight;">

                        <div class="content-box" style="padding-right: 6rem;">
                            <h2>{{trans('site.donate_for_us')}}
                            </h2>
                            <div class="title-text">{{trans('site.donate_small_amount')}}
                            </div>
                            <a href="#" class="theme-btn btn-style-one"
                               style="margin-right: 15px; padding-left: 30px; padding-right: 30px;background: #ffffff; color: #6ac610 !important; border-color: #6ac610;position: relative; display: inline-block; line-height: 24px; padding: 11px 25px; font-size: 13px; font-weight: 700; text-transform: uppercase; background: #6ac610; color: #ffffff !important; border: 2px solid #6ac610 !important; border-radius: 3px;">{{trans('site.donate_now')}}</a>
                        </div>
                        <div class="clearfix"></div>
                    </article>
                </div>
            </section>
        </div>
    </article>
@endsection
