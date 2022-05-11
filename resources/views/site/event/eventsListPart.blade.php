@foreach($events as $event)
    <li class="mvp-blog-story-wrap left relative infinite-post">
        <a href="{{route('event.show',['id'=>$event->id,'type'=>  \Str::slug($event->type->syslkp_data->en ),'slug'=>\Str::slug($event->the_title)])}}"
           rel="bookmark">
            <div class="mvp-blog-story-out relative">
                <div class="mvp-blog-story-img left relative">
                    <img width="400" height="240"
                         src="{{loadImage($event->cover_image,'events',380,228,100,'',0)}}"
                         class="mvp-reg-img lazy" alt="{{$event->the_title}}"
                         loading="lazy" />
                    <img width="80"
                         height="80"
                         src="{{loadImage($event->cover_image,'events',380,228,100,'',0)}}"
                         class="mvp-mob-img lazy"
                         alt="{{$event->the_title}}"
                         loading="lazy" />
                </div>
                <div class="mvp-blog-story-in">
                    <div class="mvp-blog-story-text left relative">
                        <div class="mvp-cat-date-wrap left relative">
                            <span class="mvp-cd-cat left relative">{{$event->type->syslkp_data->{$locale}??$event->type->syslkp_data->{$fallbackLanguage} }}</span><span
                                class="mvp-cd-date left relative">{{date('Y-m-d',strtotime($event->date))}}</span>
                        </div>
                        <h2>{{$event->the_title}}</h2>
                    </div>
                </div>
            </div>
        </a>
    </li>
@endforeach
