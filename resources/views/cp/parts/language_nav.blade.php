<ul class="kt-menu__nav nav-lang">
    @foreach($languages as $language)
        <li class="kt-menu__item kt-menu__item--rel
        @if($language->iso_code==$locale) active @endif">
            <a href="javascript:;"
               class="btn {{($language->iso_code==$locale)?'btn-outline-brand':'btn-outline-secondary'}}
                   language_switch tab{{ucfirst($language->name)}}"
               data-lang="{{$language->iso_code}}" data-lang-full="{{ucfirst($language->name)}}">
                @if($language->iso_code==$locale)
                    <i class="fa fa-check-circle"></i>
                @endif
                {{$language->name}}
            </a>
        </li>
    @endforeach
</ul>
