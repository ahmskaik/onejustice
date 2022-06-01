@extends('site.layout.layout')
@section('js')
    <div data-theiaStickySidebar-sidebarSelector='"#mvp-side-wrap,.mvp-post-soc-wrap,.mvp-flex-side-wrap,.mvp-alp-side"'
         data-theiaStickySidebar-options='{"containerSelector":"","additionalMarginTop":120,"additionalMarginBottom":20,"updateSidebarHeight":false,"minWidth":1004,"sidebarBehavior":"modern","disableOnResponsiveLayouts":true}'></div>
    <script type='text/javascript' src='assets/js/theia-sticky-sidebar.js?ver=1.7.0'></script>

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
    <div class="mvp-main-box">
        <div class="mvp-main-blog-cont left relative">
            <header id="mvp-post-head" class="left relative">
                <h1 class="mvp-post-title left entry-title" itemprop="headline">{{trans('site.search_results_for')}}
                    "{{$query}}"</h1>
            </header>
            <div class="mvp-main-blog-out left relative">
                <div class="mvp-main-blog-body left relative">
                    <ul class="mvp-blog-story-list left relative infinite-content" id="postsList">
                        @if(count($posts))
                            @include('site.home.searchResultPart')
                        @else
                            <div class="mvp-search-text left relative">
                                {{-- <h2 class="fa fa-search fa-2">
                                 </h2>--}}
                                <p style="margin-bottom: 2rem;">{{trans('site.no_results')}}</p>
                            </div>
                        @endif
                    </ul>
                    @if($hasMore)
                        <div class="mvp-inf-more-wrap left relative">
                            <a href="javascript:;"
                               data-next-page="{{$nextPage.'&s='.$query}}"
                               data-has-more="{{$hasMore}}" id="loadPosts"
                               class="mvp-inf-more-but">{{trans('site.more_posts')}}</a>
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
@endsection
