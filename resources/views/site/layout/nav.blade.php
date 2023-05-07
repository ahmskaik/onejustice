<li class="menu-item"><a href="{{route('site.home')}}">{{trans('site.home')}}</a></li>
<li class="menu-item"><a href="{{route('site.about')}}">{{trans('site.about_us')}}</a></li>
@foreach($categories as $_category)
    <li class="menu-item @if($_category->activeSubCategories && count($_category->activeSubCategories)) menu-item-has-children @endif">
        <a href="{{route('site.getPostsByCategory',['category'=>$_category->slug])}}">{{$_category->title }}</a>
        @if($_category->activeSubCategories && count($_category->activeSubCategories))
            <ul class="sub-menu">
                @foreach($_category->activeSubCategories as $subCategory)
                    <li class="menu-item">
                        <a href="{{route('site.getPostsByCategory',['category'=>$subCategory->slug])}}">{{$subCategory->name->{$locale}??$subCategory->name->{$fallbackLanguage} }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach

<li class="menu-item"><a href="{{route('site.home')}}#newsmap">{{trans('site.news_map')}}</a></li>
{{--<li class="menu-item"><a href="{{route('site.contact.index')}}">{{trans('site.contact_us')}}</a></li>--}}
{{--<li class="menu-item"><a href="{{route('site.donate.index')}}">{{trans('site.donate')}}</a></li>--}}
<li class="menu-item"><a target="_blank" href="http://onejustice.assoc.pro/">{{trans('site.donate')}}</a></li>
