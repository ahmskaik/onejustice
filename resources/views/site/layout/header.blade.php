<header class="left relative" id="mvp-main-head-wrap">
    <nav class="left relative" id="mvp-main-nav-wrap">
        <div class="left relative mvp-nav-menu left "
             id="mvp-main-nav-top">
            <div class="mvp-main-box">
                <div class="left relative" id="mvp-nav-top-wrap">
                    <div
                        class="mvp-nav-top-right-out left relative"
                        style="top: 5px;">
                        <div class="mvp-nav-top-left-in" style="margin-left: auto;">
                            <div class="mvp-nav-top-cont left relative">
                                <div class="mvp-nav-top-left-out relative">
                                    <div class="mvp-nav-top-left">
                                        <div class="mvp-nav-soc-wrap">
                                            @foreach($siteSetting['social_accounts'] as $account=>$link)
                                                @if(!empty($link))
                                                    <a href="{{$link}}" target="_blank"><span
                                                            class="mvp-nav-soc-but fa fa-{{$account=='youtube'?($account.'-play'):$account}}"></span></a>
                                                @endif
                                            @endforeach
                                            <div style="margin-right: 2rem;color: #fff;"
                                                 class="mvp-nav-bot-left left relative">
                                                <span style="padding-left: 5rem;"
                                                    class="mvp-nav-search-but fa fa-search fa-2 mvp-search-click"></span>
                                            </div>
                                        </div>
                                        <div class="mvp-nav-top-right">
                                            <ul class="menu">
                                                <li class="menu-item language-menu-item">
                                                    <a href="javascript:;">
                                                        <img class=""
                                                             src="assets/images/flags/png16px/{{$active_language['flag']}}.png"
                                                             alt=""/>
                                                        {{$active_language->translations->{$locale}??$active_language->translations->{$fallbackLanguage} }}
                                                    </a>
                                                    <ul class="sub-menu">
                                                        @foreach($languages as $language)
                                                            @if($language['id'] != $active_language['id'])
                                                                <li class="menu-item">
                                                                    <a href="changeLang/{{$language['iso_code']}}">
                                                                        <img class=""
                                                                             src="assets/images/flags/png16px/{{$language['flag']}}.png"
                                                                             alt=""/>
                                                                        {{$language['translations']->{$locale}??$language['translations']->{$fallbackLanguage} }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        <div
                                            class="mvp-fly-but-wrap mvp-fly-but-click left relative">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="mvp-nav-top-left-in">
                                        <div class="mvp-nav-top-mid left relative"
                                             itemscope
                                             itemtype="http://schema.org/Organization">
                                            <a class="mvp-nav-logo-small"
                                               href="{{route('site.home')}}">
                                                <img
                                                    alt="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}"
                                                    data-rjs="2"
                                                    src="assets/images/logos/logo-light.png"/></a>
                                            <h2 class="mvp-logo-title">{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="left relative" id="mvp-main-nav-bot">
            <div class="left" id="mvp-main-nav-bot-cont">
                <div class="mvp-main-box">
                    <div class="left" id="mvp-nav-bot-wrap">
                        <div
                            class="mvp-nav-bot-left-out left">
                            <div class="mvp-nav-bot-left-in">
                                <div class="mvp-nav-bot-cont left">
                                    <div class="mvp-nav-bot-left-out">
                                        <div
                                            class="mvp-nav-bot-left left relative">
                                            <div
                                                class="mvp-fly-but-wrap mvp-fly-but-click left relative">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="mvp-nav-bot-left-in" style="display: flex;position: relative;">
                                            <a class="mvp-nav-logo-reg"
                                               href="{{route('site.home')}}"
                                               itemprop="url">
                                                <img
                                                    alt="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}"
                                                    data-rjs="2"
                                                    itemprop="logo" style="width: 145px; position: relative;"
                                                    src="assets/images/logos/logo-light.png"/></a>

                                            <div class="mvp-nav-menu left">
                                                <div class="menu-main-menu-container">
                                                    <ul class="menu" id="menu-main-menu-1">
                                                        @include('site.layout.nav')
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div
                                class="mvp-nav-bot-left left relative">
                                <span class="mvp-nav-search-but fa fa-search fa-2 mvp-search-click"></span>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
