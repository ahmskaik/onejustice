<section class="mvp-widget-home left relative mvp_home_feat2_widget" id="mvp_home_feat2_widget-3">
    <div class="mvp-main-box">
        <div class="mvp-widget-home-head">
            <h4 class="mvp-widget-home-title">
                <span class="mvp-widget-home-title">{{trans('site.reports')}}</span>
            </h4></div>
        <div class="mvp-widget-feat2-wrap left relative">
            <div class="mvp-widget-feat2-out left relative">
                <div class="mvp-widget-feat2-in">
                    <div class="mvp-widget-feat2-main left relative">
                        @if($featured_report)
                            <div class="mvp-widget-feat2-left left relative">
                                <a href="{{route('post.show',['id'=>$featured_report->id,'category'=> strtolower($featured_report->category->slug),'slug'=>$featured_report->slug])}}"
                                   rel="bookmark">
                                    <div class="mvp-widget-feat2-left-cont left relative">
                                        <div class="mvp-feat1-feat-img left relative">
                                            <img alt="{{$featured_report->title}}"
                                                 class="attachment-mvp-port-thumb size-mvp-port-thumb"
                                                 height="600"
                                                 loading="lazy"
                                                 src="uploads/posts/{{$featured_report->cover_image}}" width="560"/>
                                            @if(!empty($featured_report->type->syslkp_data->icon))
                                                <div class="mvp-vid-box-wrap mvp-vid-marg">
                                                    <i class="{{$featured_report->type->syslkp_data->icon}}"
                                                       aria-hidden="true"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mvp-feat1-feat-text left relative">
                                            <div class="mvp-cat-date-wrap left relative">
                                            <span
                                                class="mvp-cd-cat left relative">{{$featured_report->category->name->{$locale} ??$featured_report->category->name->{$fallbackLanguage} }}</span><span
                                                    class="mvp-cd-date left relative">{{getTimeLeft(strtotime($featured_report->date),$locale)}}</span>
                                            </div>
                                            <h2>{{$featured_report->title}}</h2>
                                            <p>{{$featured_report->summary}}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                        <div class="mvp-widget-feat2-right left relative">
                            @foreach($featured_reports_middle as $post)
                                <a href="{{route('post.show',['id'=>$post->id,'category'=> strtolower($post->category->slug),'slug'=>$post->slug])}}"
                                   rel="bookmark">
                                    <div class="mvp-widget-feat2-right-cont left relative">
                                        <div class="mvp-widget-feat2-right-img left relative">
                                            <img alt="{{$post->title}}" class="mvp-reg-img lazy"
                                                 height="240"
                                                 loading="lazy" src="uploads/posts/{{$post->cover_image}}"
                                                 width="400"/>
                                            <img
                                                alt="{{$post->title}}" class="mvp-mob-img lazy"
                                                height="80"
                                                loading="lazy" src="{{$post->cover_image}}"
                                                width="80"/>
                                            @if(!empty($post->type->syslkp_data->icon))
                                                <div class="mvp-vid-box-wrap mvp-vid-box-mid">
                                                    <i class="{{$post->type->syslkp_data->icon}}"
                                                       aria-hidden="true"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mvp-widget-feat2-right-text left relative">
                                            <div class="mvp-cat-date-wrap left relative">
                                                <span
                                                    class="mvp-cd-cat left relative">{{$post->category->name->{$locale} ??$post->category->name->{$fallbackLanguage} }}</span>
                                                <span
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
                <div class="mvp-widget-feat2-side left relative">
                    <div class="mvp-widget-feat2-side-list left relative">
                        <div class="mvp-feat1-list left relative">
                            @foreach($reports as $post)
                                <a href="{{route('post.show',['id'=>$post->id,'category'=> strtolower($post->category->slug),'slug'=>$post->slug])}}"
                                   rel="bookmark">
                                    <div class="mvp-feat1-list-cont left relative">
                                        <div class="mvp-feat1-list-out relative">
                                            <div class="mvp-feat1-list-img left relative">
                                                <img width="80" height="80"
                                                     src="{{loadImage($post->cover_image,'posts',285,171,100,'',0)}}"
                                                     class="attachment-mvp-small-thumb size-mvp-small-thumb"
                                                     alt="{{$post->title}}" loading="lazy"></div>

                                            <div class="mvp-feat1-list-in">
                                                <div class="mvp-feat1-list-text">
                                                    <div class="mvp-cat-date-wrap left relative">
                                                        <span
                                                            class="mvp-cd-cat left relative">{{$post->category->name->{$locale} ?? $post->category->name->{$fallbackLanguage} }}</span><span
                                                            class="mvp-cd-date left relative">{{getTimeLeft(strtotime($post->date),$locale)}}</span>
                                                    </div>
                                                    <h2>{{$post->title}}</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{route('site.getPostsByCategory',['category'=>'reports'])}}">
                            <div class="mvp-widget-feat2-side-more-but left relative">
                                <span
                                    class="mvp-widget-feat2-side-more">{{trans('site.more_of').' ' .trans('site.reports')}}</span><i
                                    class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
