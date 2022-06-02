<section class="left relative" id="mvp-feat3-wrap">
    <div class="mvp-main-box">
        <div class="mvp-widget-home-head">
            <h4 class="mvp-widget-home-title">
                <span class="mvp-widget-home-title">{{trans('site.statements')}}</span>
            </h4>
        </div>
        <div class="mvp-feat3-cont">
            @if($featured_statement)
                <div class="mvp-feat3-main-wrap left relative">
                    <a href="{{route('post.show',['id'=>$featured_statement->id,'category'=> strtolower($featured_statement->category->slug),'slug'=>$featured_statement->slug])}}"
                       rel="bookmark">
                        <div class="mvp-feat3-main-story left relative">
                            <div class="mvp-feat3-main-img left relative">
                                <img alt="{{$featured_statement->title}}"
                                     class="attachment-mvp-port-thumb size-mvp-port-thumb"
                                     loading="lazy"
                                     src="{{loadImage($featured_statement->cover_image,'posts',560,600,100,'',1)}}"/>
                                @if(!empty($featured_statement->type->syslkp_data->icon))
                                    <div class="mvp-vid-box-wrap mvp-vid-marg">
                                        <i aria-hidden="true"
                                           class="{{$featured_statement->type->syslkp_data->icon}}"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mvp-feat3-main-text">
                                <div class="mvp-cat-date-wrap left relative">
                                <span
                                    class="mvp-cd-cat left relative">{{$featured_statement->category->name->{$locale}??$featured_statement->category->name->{$fallbackLanguage} }}</span>
                                    <span
                                        class="mvp-cd-date left relative">{{date('Y-m-d',strtotime($featured_statement->date))}}</span>
                                </div>
                                <h2>{{$featured_statement->title}}</h2>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            <div class="mvp-feat3-sub-wrap left relative">
                @foreach($statements as $statement)
                    <a href="{{route('post.show',['id'=>$statement->id,'category'=> strtolower($statement->category->slug),'slug'=>$statement->slug])}}"
                       rel="bookmark">
                        <div class="mvp-feat3-sub-story left relative">
                            <div class="mvp-feat3-sub-img left relative">
                                <img alt="{{$statement->title}}" class="mvp-reg-img"
                                     loading="lazy"
                                     src="{{loadImage($statement->cover_image,'posts',620,290,100,'',0)}}"/>
                                <img alt="{{$statement->title}}"
                                     class="mvp-mob-img"
                                     loading="lazy"
                                     src="{{loadImage($statement->cover_image,'posts',620,290,100,'',0)}}"/>
                            </div>
                            <div class="mvp-feat3-sub-text">
                                <div class="mvp-cat-date-wrap left relative">
                                    <span
                                        class="mvp-cd-cat left relative">{{$statement->category->name->{$locale}??$statement->category->name->{$fallbackLanguage} }}</span><span
                                        class="mvp-cd-date left relative"> {{date('Y-m-d',strtotime($statement->date))}}</span>
                                </div>
                                <h2>{{$statement->title}}</h2>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
