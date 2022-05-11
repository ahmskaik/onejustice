<div id="mvp-fly-soc-wrap">
    <span class="mvp-fly-soc-head">Connect with us</span>
    <ul class="mvp-fly-soc-list left relative">
        @foreach($siteSetting['social_accounts'] as $account=>$link)
            @if(!empty($link))
                <li><a class="fa fa-{{$account=='youtube'?($account.'-play'):$account}} fa-2" href="{{$link}}"
                       target="_blank"></a></li>
            @endif
        @endforeach
    </ul>
</div>
