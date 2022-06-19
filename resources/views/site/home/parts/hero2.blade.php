<section class="left relative" id="mvp-feat3-wrap">
    <div class="mvp-main-box">
        <div class="mvp-feat3-cont">
            @if($featured_article)
                <div class="mvp-feat3-main-wrap left relative">
                    <a href="{{route('post.show',['id'=>$featured_article->id,'category'=>$featured_article->category->slug,'slug'=>$featured_article->slug])}}"
                       rel="bookmark">
                        <div class="mvp-feat3-main-story left relative">
                            <div class="mvp-feat3-main-img left relative">
                                <img alt="{{$featured_article->title}}"
                                     class="attachment-mvp-port-thumb size-mvp-port-thumb"
                                     loading="lazy"
                                     src="{{loadImage($featured_article->cover_image,'posts',560,600,100,'',1)}}"/>

                                @if(!empty($featured_article->type->syslkp_data->icon))
                                    <div class="mvp-vid-box-wrap mvp-vid-marg">
                                        <i aria-hidden="true"
                                           class="{{$featured_article->type->syslkp_data->icon}}"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mvp-feat3-main-text">
                                <div class="mvp-cat-date-wrap left relative">
                                <span
                                    class="mvp-cd-cat left relative">{{$featured_article->category->name->{$locale} ??$featured_article->category->name->{$fallbackLanguage} }}</span><span
                                        class="mvp-cd-date left relative">{{getTimeLeft(strtotime($featured_article->date),$locale)}}</span>
                                </div>
                                <h2>{{$featured_article->title}}</h2>
                                <p>{{$featured_article->summary}}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            <div class="mvp-feat3-sub-wrap left relative">
                @foreach($featured_news as $post)
                    @if($loop->iteration==3)
                        @break
                    @endif
                    <a href="{{route('post.show',['id'=>$post->id,'category'=>strtolower($post->category->slug),'slug'=>$post->slug])}}"
                       rel="bookmark">
                        <div class="mvp-feat3-sub-story left relative">
                            <div class="mvp-feat3-sub-img left relative">
                                <img alt="{{$post->title}}" class="mvp-reg-img"
                                     loading="lazy" src="{{loadImage($post->cover_image,'posts',620,290,100,'',0)}}"/>
                                <img alt="{{$post->title}}"
                                     class="mvp-mob-img"
                                     loading="lazy"
                                     src="{{loadImage($post->cover_image,'posts',620,290,100,'',0)}}"/>
                                @if(!empty($post->type->syslkp_data->icon))
                                    <div class="mvp-vid-box-wrap mvp-vid-box-mid">
                                        <i class="{{$post->type->syslkp_data->icon}}"
                                           aria-hidden="true"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mvp-feat3-sub-text">
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
</section>
