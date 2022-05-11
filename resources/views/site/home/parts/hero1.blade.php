<section id="mvp-feat2-wrap" class="left relative">
    @if($featured_article)
        <div class="mvp-feat2-top left relative">
            <a href="{{route('post.show',['id'=>$featured_article->id,'category'=>strtolower($featured_article->category->slug),'slug'=>$featured_article->slug])}}"
               rel="bookmark">
                <div class="mvp-feat2-top-story left relative">
                    <div class="mvp-feat2-top-img left relative">
                        <img src="{{loadImage($featured_article->cover_image ,'posts',1519,912,100,'',1)}}"
                             class="mvp-reg-img" alt="{{$featured_article->title}}" loading="lazy">
                        <img src="uploads/posts/{{$featured_article->cover_image}}"
                             class="mvp-mob-img" alt="{{$featured_article->title}}"
                             loading="lazy"></div>
                    <div class="mvp-feat2-top-text-wrap">
                        <div class="mvp-feat2-top-text-box">
                            <div class="mvp-feat2-top-text left relative">
                                <h2>{{$featured_article->title}}</h2>
                                <p>{{$featured_article->summary}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
    <div class="mvp-feat2-bot-wrap left relative">
        <div class="mvp-main-box">
            <div class="mvp-feat2-bot left relative">
                @foreach($featured_news as $post)
                    <a href="{{route('post.show',['id'=>$post->id,'category'=> strtolower($post->category->slug),'slug'=>$post->slug])}}"
                       rel="bookmark">
                        <div class="mvp-feat2-bot-story left relative">
                            <div class="mvp-feat2-bot-img left relative">
                                <img src="{{loadImage($post->cover_image ,'posts',285,170,100,'',0)}}"
                                     class="mvp-reg-img" alt="{{$post->title}}" loading="lazy">
                                <img src="{{loadImage($post->cover_image ,'posts',285,170,100,'',0)}}"
                                     class="mvp-mob-img"
                                     alt="{{$post->title}}"
                                     loading="lazy">
                                @if(!empty($post->type->syslkp_data->icon))
                                    <div class="mvp-vid-box-wrap mvp-vid-box-mid">
                                        <i class="{{$post->type->syslkp_data->icon}}"
                                           aria-hidden="true"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mvp-feat2-bot-text left relative">
                                <div class="mvp-cat-date-wrap left relative">
                                    <span
                                        class="mvp-cd-cat left relative">{{strtolower($post->category->name->{$locale} ??$post->category->name->{$fallbackLanguage}) }}</span><span
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
