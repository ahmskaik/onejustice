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
    <div class="mvp-main-blog-wrap left relative">
        <div class="mvp-main-box">
            <div class="mvp-main-blog-cont left relative">
                <div class="mvp-main-blog-out left relative">
                    <header id="mvp-post-head" style="padding: 13px 0 0 0;margin: 0" class="left relative light-bg">
                        <h3 class="mvp-post-cat left relative">
                            <a class="" href="{{route('site.home')}}">
                                <span style="border: none!important;font-size: 0.8rem !important;"
                                      class="mvp-post-cat left"> {{trans('site.home')}} | </span>
                            </a>
                            <a class="mvp-post-cat-link">
                                <span style="font-size: 0.8rem !important;"
                                      class="mvp-post-cat left">{{$category->name->{$locale}??$category->name->{$fallbackLanguage} }}</span>
                            </a>

                        </h3>
                    </header>
                    <div class="mvp-main-blog-in2">
                        @if(count($category->activeSubCategories))
                            <ul class="" id="block-categories-menu">
                                @foreach($category->activeSubCategories as $subCategory)
                                    <li class="">
                                        <a href="{{route('site.getPostsByCategory',['category'=>$subCategory->slug])}}">{{$subCategory->name->{$locale}??$subCategory->name->{$fallbackLanguage} }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="mvp-main-blog-body left relative">
                                <div id="mvp-cat-feat-wrap" class="light-bg left relative" @if(!count($featured_posts)) style="width: 100%!important;" @endif>
                                    @if($main_post)
                                        <div class="mvp-widget-feat2-left left relative mvp-widget-feat2-left-alt">
                                            <a href="{{route('post.show',['id'=>$main_post->id,'category'=>strtolower($main_post->category->slug),'slug'=>$main_post->slug])}}"
                                               rel="bookmark">
                                                <div class="mvp-widget-feat2-left-cont left relative">
                                                    <div class="mvp-feat1-feat-img left relative">
                                                        <img width="560" height="600"
                                                             src="uploads/posts/{{$main_post->cover_image}}"
                                                             class="attachment-mvp-port-thumb size-mvp-port-thumb"
                                                             alt="{{$main_post->title}}" loading="lazy"/>
                                                        @if(!empty($main_post->type->syslkp_data->icon))
                                                            <div
                                                                class="mvp-vid-box-wrap mvp-vid-box-mid">
                                                                <i class="{{$main_post->type->syslkp_data->icon}}"
                                                                   aria-hidden="true"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="mvp-feat1-feat-text left relative">
                                                        <div class="mvp-cat-date-wrap left relative">
                                                        <span
                                                            class="mvp-cd-cat left relative">{{$category->name->{$locale} ??$category->name->{$fallbackLanguage} }}</span><span
                                                                class="mvp-cd-date left relative">{{getTimeLeft(strtotime($main_post->date),$locale)}}</span>
                                                        </div>
                                                        <h2>{{$main_post->title}}</h2>
                                                        <p>{{$main_post->summary}}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="mvp-widget-feat2-right left relative">
                                        <div class="mvp-widget-feat2-right-main left relative">
                                            @foreach($featured_posts as $post)
                                                <a href="{{route('post.show',['id'=>$post->id,'category'=>strtolower($post->category->slug),'slug'=>$post->slug])}}"
                                                   rel="bookmark">
                                                    <div class="mvp-widget-feat2-right-cont left relative">
                                                        <div class="mvp-widget-feat2-right-img left relative">
                                                            <img
                                                                src="{{loadImage($post->cover_image,'posts',448,180,100,'',0)}}"
                                                                class="mvp-reg-img lazy"
                                                                alt="{{$post->title}}"
                                                                loading="lazy"
                                                            />
                                                            <img
                                                                width="80"
                                                                height="80"
                                                                src="{{loadImage($post->cover_image,'posts',445,180,100,'',0)}}"
                                                                class="mvp-mob-img lazy"
                                                                alt=""
                                                                loading="lazy"
                                                            />
                                                            @if(!empty($post->type->syslkp_data->icon))
                                                                <div
                                                                    class="mvp-vid-box-wrap mvp-vid-box-mid">
                                                                    <i class="{{$post->type->syslkp_data->icon}}"
                                                                       aria-hidden="true"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="mvp-widget-feat2-right-text left relative">
                                                            <div class="mvp-cat-date-wrap left relative">
                                                                <span
                                                                    class="mvp-cd-cat left relative">{{ $post->category->name->{$locale} ?? $post->category->name->{$fallbackLanguage}  }}</span><span
                                                                    class="mvp-cd-date left relative">{{getTimeLeft(strtotime($post->date),$locale)}}</span>
                                                            </div>
                                                            <h2>{{$post->title}}</h2>
                                                        </div>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            <ul class="mvp-blog-story-list left relative infinite-content light-bg" id="postsList">
                                @include('site.post.postsListPart')
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
@endsection
