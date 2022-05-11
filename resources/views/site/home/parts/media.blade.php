<section class="left relative mvp-widget-home" id="mvp-feat2-wrap">
    <div class="mvp-feat2-bot-wrap left relative">
        <div class="mvp-main-box">
            <div class="mvp-widget-home-head"><h4 class="mvp-widget-home-title"><span
                        class="mvp-widget-home-title">{{trans('site.media')}}</span></h4></div>
            <div class="mvp-feat2-bot left relative">
                @foreach($media as $post)
                    <a href="{{route('post.show',['id'=>$post->id,'category'=> strtolower($post->category->slug),'slug'=>$post->slug])}}"
                       rel="bookmark">
                        <div class="mvp-feat2-bot-story left relative">
                            <div class="mvp-feat2-bot-img left relative">
                                <img alt="{{$post->title}}" class="mvp-reg-img"
                                     height="240"
                                     loading="lazy"
                                     src="{{loadImage($post->cover_image,'posts',285,171,100,'',0)}}">
                                <img alt="{{$post->title}}"
                                     class="mvp-mob-img"
                                     height="80"
                                     loading="lazy"
                                     src="{{loadImage($post->cover_image,'posts',285,171,100,'',0)}}">
                                @if(!empty($post->type->syslkp_data->icon))
                                    <div class="mvp-vid-box-wrap mvp-vid-box-mid">
                                        <i class="{{$post->type->syslkp_data->icon}}"
                                           aria-hidden="true"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mvp-feat2-bot-text left relative">
                                <div class="mvp-cat-date-wrap left relative">
                                    <span class="mvp-cd-cat left relative">{{$post->category->name->{$locale} ??$post->category->name->{$fallbackLanguage} }}</span><span
                                        class="mvp-cd-date left relative">{{getTimeLeft(strtotime($post->date),$locale)}}</span>
                                </div>
                                <h2>{{$post->title}}</h2>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <a href="{{route('site.getPostsByCategory',['category'=>'media'])}}">
                <div class="mvp-widget-feat2-side-more-but left relative">
                    <span
                        class="mvp-widget-feat2-side-more">{{trans('site.more_of').' '.trans('site.media')}}</span><i
                        aria-hidden="true" class="fa fa-long-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</section>
