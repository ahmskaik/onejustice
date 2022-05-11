<div class="mvp-main-blog-wrap left relative">
    <div class="mvp-main-box">
        <div class="mvp-main-blog-cont left relative">
            <div class="mvp-widget-home-head">
                <h4 class="mvp-widget-home-title">
                    <span class="mvp-widget-home-title">{{trans('site.more_news')}}</span>
                </h4>
            </div>
            <div class="mvp-main-blog-out left relative">
                <div class="mvp-main-blog-in2">
                    <div class="mvp-main-blog-body left relative">
                        <ul class="mvp-blog-story-list left relative infinite-content">
                            @foreach($further_posts as $post )
                                <li class="mvp-blog-story-wrap left relative infinite-post">
                                    <a href="{{route('post.show',['id'=>$post->id,'category'=> strtolower($post->category->slug),'slug'=>$post->slug])}}"
                                       rel="bookmark">
                                        <div class="mvp-blog-story-out relative">
                                            <div class="mvp-blog-story-img left relative">
                                                <img alt="" class="mvp-reg-img lazy"
                                                      loading="lazy"
                                                     src="{{loadImage($post->cover_image,'posts',380,228,100,'',0)}}"
                                                    /> <img
                                                    alt="" class="mvp-mob-img lazy"
                                                    src="{{loadImage($post->cover_image,'posts',380,228,100,'',0)}}"
                                                    loading="lazy" /></div>

                                            <div class="mvp-blog-story-in">
                                                <div class="mvp-blog-story-text left relative">
                                                    <div class="mvp-cat-date-wrap left relative">
                                                        <span class="mvp-cd-cat left relative">{{$post->category->name->{$locale}??$post->category->name->{$fallbackLanguage} }}</span><span
                                                            class="mvp-cd-date left relative">{{getTimeLeft(strtotime($post->date),$locale)}}</span>
                                                    </div>
                                                    <h2>{{$post->title}}</h2>
                                                    <p>{{$post->summary}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                       {{-- <div class="mvp-inf-more-wrap left relative">
                            <a class="mvp-inf-more-but" href="#">More Posts</a>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
