<li class="menu-item language-menu-item">
    <a href="javascript:;">
        <img class="" src="assets/images/flags/png16px/{{$active_language['flag']}}.png" alt=""/>
        {{$active_language->translations->{$locale}??$active_language->translations->{$fallbackLanguage} }}</a>
    <ul class="sub-menu">
        @foreach($languages as $language)
            @if($language['id'] != $active_language['id'])
                <li class="menu-item">
                    <a href="changeLang/{{$language['iso_code']}}">
                        <img class="" src="assets/images/flags/png16px/{{$language['flag']}}.png" alt=""/>
                        {{$language['translations']->{$locale}??$language['translations']->{$fallbackLanguage} }}</a></li>
            @endif
        @endforeach
    </ul>
</li>

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
<li class="menu-item @if($get_involved_types && count($get_involved_types)) menu-item-has-children @endif">
    <a href="{{route('events.all')}}">{{trans('site.get_involved')}}</a>
    @if($get_involved_types && count($get_involved_types))
        <ul class="sub-menu">
            @foreach($get_involved_types as $type)
                <li class="menu-item">
                    <a href="{{route('events.all',['type'=>$type->slug])}}">{{$type->text }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</li>

<li class="menu-item"><a href="newsletters">{{trans('site.newsletters')}}</a></li>
