<section class="left relative" id="mvp-feat3-wrap">
    <div class="mvp-main-box">
        <div class="mvp-widget-home-head">
            <h4 class="mvp-widget-home-title">
                <span class="mvp-widget-home-title">{{trans('site.get_involved')}}</span>
            </h4>
        </div>
        <div class="mvp-feat3-cont">
            @if($featured_get_involved)
                <div class="mvp-feat3-main-wrap left relative">
                    <a href="{{route('event.show',['id'=>$featured_get_involved->id,'type'=>  \Str::slug($featured_get_involved->type->syslkp_data->en ),'slug'=>\Str::slug($featured_get_involved->the_title)])}}"
                       rel="bookmark">
                        <div class="mvp-feat3-main-story left relative">
                            <div class="mvp-feat3-main-img left relative">
                                <img alt="{{$featured_get_involved->the_title}}"
                                     class="attachment-mvp-port-thumb size-mvp-port-thumb"
                                     loading="lazy"
                                     src="{{loadImage($featured_get_involved->cover_image,'events',560,600,100,'',1)}}"/>
                                <div class="mvp-vid-box-wrap mvp-vid-marg">
                                    <i aria-hidden="true" class="fa fa-2 fa-play"></i>
                                </div>
                            </div>
                            <div class="mvp-feat3-main-text">
                                <div class="mvp-cat-date-wrap left relative">
                                <span
                                    class="mvp-cd-cat left relative">{{$featured_get_involved->type->syslkp_data->{$locale}??$featured_get_involved->type->syslkp_data->{$fallbackLanguage} }}</span>
                                    <span
                                        class="mvp-cd-date left relative">{{date('Y-m-d',strtotime($featured_get_involved->date))}}</span>
                                </div>
                                <h2>{{$featured_get_involved->the_title}}</h2>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            <div class="mvp-feat3-sub-wrap left relative">
                @foreach($get_involved_left as $event)
                    <a href="{{route('event.show',['id'=>$event->id,'type'=>  \Str::slug($event->type->syslkp_data->en ),'slug'=>\Str::slug($event->the_title)])}}"
                       rel="bookmark">
                        <div class="mvp-feat3-sub-story left relative">
                            <div class="mvp-feat3-sub-img left relative">
                                <img alt="{{$event->the_title}}" class="mvp-reg-img"
                                     loading="lazy"
                                     src="{{loadImage($event->cover_image,'events',620,290,100,'',0)}}"/>
                                <img alt="{{$event->the_title}}"
                                     class="mvp-mob-img"
                                     loading="lazy"
                                     src="{{loadImage($event->cover_image,'events',620,290,100,'',0)}}"/>
                            </div>
                            <div class="mvp-feat3-sub-text">
                                <div class="mvp-cat-date-wrap left relative">
                                    <span
                                        class="mvp-cd-cat left relative">{{$event->type->syslkp_data->{$locale}??$event->type->syslkp_data->{$fallbackLanguage} }}</span><span
                                        class="mvp-cd-date left relative"> {{date('Y-m-d',strtotime($event->date))}}</span>
                                </div>
                                <h2>{{$event->the_title}}</h2>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <a href="#">
                <div class="mvp-widget-feat2-side-more-but left relative">
                    <span class="mvp-widget-feat2-side-more">{{trans('site.more_events_and_announcements')}}</span><i
                        aria-hidden="true" class="fa fa-long-arrow-right"></i>
                </div>
            </a>
        </div>
    </div>
</section>
