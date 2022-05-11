<section class="mvp-widget-home left relative mvp_home_feat1_widget" id="mvp_home_feat1_widget-4">
    <div class="mvp-main-box">
        <div class="mvp-widget-home-head">
            <h4 class="mvp-widget-home-title">
                <span class="mvp-widget-home-title">{{trans('site.resources')}}</span>
            </h4>
        </div>
        <div class="mvp-widget-feat1-wrap left relative">
            <div class="mvp-widget-feat1-cont left relative">
                @foreach($featured_resources as $post)
                    <a href="{{route('post.show',['id'=>$post->id,'category'=> strtolower($post->category->slug),'slug'=>$post->slug])}}"
                       rel="bookmark">
                        <div class="mvp-widget-feat1-top-story left relative">
                            <div class="mvp-widget-feat1-top-img left relative">
                                <img alt="{{$post->title}}" class="mvp-reg-img lazy"
                                     loading="lazy" src="{{loadImage($post->cover_image,'posts',590,350,100,'',0)}}"
                                /> <img alt="{{$post->title}}"
                                        class="mvp-mob-img lazy"
                                        loading="lazy"
                                        src="{{loadImage($post->cover_image,'posts',320,192,100,'',0)}}"/>
                                @if(!empty($post->type->syslkp_data->icon))
                                    <div class="mvp-vid-box-wrap mvp-vid-marg">
                                        <i class="{{$post->type->syslkp_data->icon}}"
                                           aria-hidden="true"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mvp-widget-feat1-top-text left relative">
                                <div class="mvp-cat-date-wrap left relative">
                                    <span
                                        class="mvp-cd-cat left relative">{{$post->category->name->{$locale}??$post->category->name->{$fallbackLanguage} }}</span><span
                                        class="mvp-cd-date left relative">{{getTimeLeft(strtotime($post->date),$locale)}}</span>
                                </div>
                                <h2>{{$post->title}}</h2>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mvp-widget-feat1-cont left relative">
                @foreach($resources as $post)
                    <a href="{{route('post.show',['id'=>$post->id,'category'=> strtolower($post->category->slug),'slug'=>$post->slug])}}"
                       rel="bookmark">
                        <div class="mvp-widget-feat1-bot-story left relative">
                            <div class="mvp-widget-feat1-bot-img left relative">
                                <img alt="{{$post->title}}" class="mvp-reg-img lazy"
                                     height="240"
                                     loading="lazy" sizes="(max-width: 400px) 100vw, 400px"
                                     src="{{loadImage($post->cover_image,'posts',285,160,100,'',0)}}"
                                     width="400"/>
                                <img alt="{{$post->title}}"
                                     class="mvp-mob-img lazy"
                                     height="80"
                                     loading="lazy"
                                     src="{{loadImage($post->cover_image,'posts',285,160,100,'',0)}}"
                                     width="80"/>
                                @if(!empty($post->type->syslkp_data->icon))
                                    <div class="mvp-vid-box-wrap mvp-vid-box-mid">
                                        <i class="{{$post->type->syslkp_data->icon}}"
                                           aria-hidden="true"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mvp-widget-feat1-bot-text left relative">
                                <div class="mvp-cat-date-wrap left relative">
                                    <span
                                        class="mvp-cd-cat left relative">{{$post->category->name->{$locale} ?? $post->category->name->{$fallbackLanguage} }}</span><span
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
</section>
