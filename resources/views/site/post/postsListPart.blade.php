@foreach($posts as $post)
    <li class="mvp-blog-story-wrap left relative infinite-post">
        <a href="{{route('post.show',['id'=>$post->id,'category'=>strtolower($post->category->slug),'slug'=>$post->slug])}}"
           rel="bookmark">
            <div class="mvp-blog-story-out relative">
                <div class="mvp-blog-story-img left relative">
                    <img width="400" height="240"
                         src="{{loadImage($post->cover_image,'posts',380,228,100,'',0)}}"
                         class="mvp-reg-img lazy" alt="{{$post->title}}"
                         loading="lazy" />
                    <img width="80"
                         height="80"
                         src="{{loadImage($post->cover_image,'posts',380,228,100,'',0)}}"
                         class="mvp-mob-img lazy"
                         alt="{{$post->title}}"
                         loading="lazy" />
                    @if(!empty($post->type->syslkp_data->icon))
                        <div
                            class="mvp-vid-box-wrap mvp-vid-box-mid">
                            <i class="{{$post->type->syslkp_data->icon}}"
                               aria-hidden="true"></i>
                        </div>
                    @endif
                </div>
                <div class="mvp-blog-story-in">
                    <div class="mvp-blog-story-text left relative">
                        <div class="mvp-cat-date-wrap left relative">
                            <span class="mvp-cd-cat left relative">{{strtolower($post->category->name->{$locale}??$post->category->name->{$fallbackLanguage}) }}</span><span
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
