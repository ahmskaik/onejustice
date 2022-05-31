<input type="hidden" id="totalrecord" name="totalrecord" value="5"/>
<h3>
    @if(isset($country)&& $country->iso_code)
        <img title="" src="assets/images/flags/png16px/{{$country->iso_code}}.png">
        {{$country->CountryName}} <small style="color: #ccd6dd">({{$country->TotalNews}} {{trans('site.post')}})</small>
    @endif
</h3>
@foreach($latestNews as $post)
    <div class="newsHolder" id="{{$post->id}}">
        <div class="imageHolder">
            <a href="" target="_blank">
                <img src="{{loadImage($post->cover_image,'posts',155,88,100,'',0)}}"
                     alt="{{$post->title}}"
                     title="{{$post->title}}"/>
            </a>
        </div>
        <div class="linkTimeHolder">
            <h1><a href="" target="_blank">{{$post->title}}</a></h1>
            <span class="topicMod">القسم:</span>
            <a href=""
               target="_blank">{{$post->category->name->{$locale}??$post->category->name->{$fallbackLanguage}  }}</a>
            {{-- <time>{{date('d-m-Y',strtotime($post->date))}}</time>--}}

            <div class="related_topics_areas">
                @if($post->countries)
                    <p class="meta">
                        المناطق:
                        @foreach($post->countries as $country)
                            <a class="meta">{{$country->CountryName}} </a>
                        @endforeach
                    </p>
                @endif
                @if($post->tags)
                    <p class="meta">
                        مواضيع وقضايا:
                        @foreach(json_decode($post->tags) as $tag)
                            <a>{{$tag}}</a>
                        @endforeach
                    </p>
                @endif
            </div>

        </div>
    </div>

@endforeach
