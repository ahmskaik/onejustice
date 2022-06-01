<section class="mvp-widget-home left relative">
    <div class="mvp-widget-dark-wrap left relative">
        <div class="mvp-main-box">
            <div class="mvp-widget-home-head">
                <h4 class="mvp-widget-home-title"><span class="mvp-widget-home-title">{{trans('site.videos')}}</span>
                </h4>
            </div>
            <div class="mvp-widget-dark-main left relative">
                @if($featured_video)
                    <div class="mvp-widget-dark-left left relative">
                        <a href="{{route('post.show',['id'=>$featured_video->id,'category'=> strtolower($featured_video->category->slug),'slug'=>$featured_video->slug])}}"
                           rel="bookmark">
                            <div class="mvp-widget-dark-feat left relative">
                                <div class="mvp-widget-dark-feat-img left relative">
                                    <img alt="{{$featured_video->title}}" class="mvp-reg-img lazy wp-post-image"
                                         height="600"
                                         loading="lazy" sizes="(max-width: 1000px) 100vw, 1000px"
                                         src="uploads/posts/{{$featured_video->cover_image}}"
                                         width="1000"/>
                                    <img alt="{{$featured_video->title}}"
                                         class="mvp-mob-img lazy wp-post-image"
                                         height="240"
                                         loading="lazy"
                                         sizes="(max-width: 400px) 100vw, 400px"
                                         src="uploads/posts/{{$featured_video->cover_image}}"
                                         width="400"/>
                                    @if(!empty($featured_video->type->syslkp_data->icon))
                                        <div class="mvp-vid-box-wrap mvp-vid-marg">
                                            <i class="{{$featured_video->type->syslkp_data->icon}}"
                                               aria-hidden="true"></i>
                                        </div>
                                    @endif

                                </div>
                                <div class="mvp-widget-dark-feat-text left relative">
                                    <div class="mvp-cat-date-wrap left relative">
                                        <span class="mvp-cd-cat left relative">{{trans('site.videos')}}</span><span
                                            class="mvp-cd-date left relative">{{getTimeLeft(strtotime($featured_video->date),$locale)}}</span>
                                    </div>
                                    <h2>{{$featured_video->title}}</h2>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                <div class="mvp-widget-dark-right left relative">
                    @foreach($videos as $post)
                        <a href="{{route('post.show',['id'=>$post->id,'category'=> strtolower($post->category->slug),'slug'=>$post->slug])}}"
                           rel="bookmark">
                            <div class="mvp-widget-dark-sub left relative">
                                <div class="mvp-widget-dark-sub-out right relative">
                                    <div class="mvp-widget-dark-sub-img left relative">
                                        <img alt="{{$post->title}}" class="mvp-reg-img lazy wp-post-image"
                                             height="240"
                                             loading="lazy" sizes="(max-width: 400px) 100vw, 400px"
                                             src="uploads/posts/{{$post->cover_image}}"
                                             width="400"/>
                                        <img alt="{{$post->title}}"
                                             class="mvp-mob-img lazy wp-post-image"
                                             height="80"
                                             loading="lazy"
                                             sizes="(max-width: 80px) 100vw, 80px"
                                             src="uploads/posts/{{$post->cover_image}}"
                                             width="80"/>
                                        @if(!empty($post->type->syslkp_data->icon))
                                            <div class="mvp-vid-box-wrap mvp-vid-box-mid">
                                                <i class="{{$post->type->syslkp_data->icon}}"
                                                   aria-hidden="true"></i>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="mvp-widget-dark-sub-in">
                                        <div class="mvp-widget-dark-sub-text left relative">
                                            <div class="mvp-cat-date-wrap left relative">
                                                <span class="mvp-cd-cat left relative">{{trans('site.videos')}}</span>
                                                <span class="mvp-cd-date left relative">{{getTimeLeft(strtotime($post->date),$locale)}}</span>
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
    </div>
</section>
