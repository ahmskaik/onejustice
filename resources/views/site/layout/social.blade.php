<div id="mvp-fly-soc-wrap">
    <span class="mvp-fly-soc-head">Connect with us</span>
    <ul class="mvp-fly-soc-list left relative">
        @foreach($siteSetting['social_accounts'] as $account=>$link)
            @if(!empty($link))
                <li><a class="fa fa-{{$account=='youtube'?($account.'-play'):$account}} fa-2" href="{{$link}}"
                       target="_blank"></a></li>
            @endif
        @endforeach
        <li style="text-align: center; display: block;    margin-top: 1rem;">
            <ul class="mvp-fly-soc-list left relative">
                @foreach($languages as $language)
                    @if($language['id'] != $active_language['id'])
                        <li class="">
                            <a href="changeLang/{{$language['iso_code']}}">
                                <img class=""
                                     src="assets/images/flags/png16px/{{$language['flag']}}.png"
                                     alt=""/>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li>
    </ul>
</div>
