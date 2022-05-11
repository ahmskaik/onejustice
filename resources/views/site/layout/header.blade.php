<header class="left relative" id="mvp-main-head-wrap">
    <nav class="left relative" id="mvp-main-nav-wrap">
        <div class="left relative" id="mvp-main-nav-top">
            <div class="mvp-main-box">
                <div class="left relative" id="mvp-nav-top-wrap">
                    <div class="mvp-nav-top-right-out left relative">
                        <div class="mvp-nav-top-right-in">
                            <div class="mvp-nav-top-cont left relative">
                                <div class="mvp-nav-top-left-out relative">
                                    <div class="mvp-nav-top-left">
                                        <div class="mvp-fly-but-wrap mvp-fly-but-click left relative">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="mvp-nav-top-left">
                                        <div class="mvp-nav-top-mid left relative" itemscope
                                             itemtype="http://schema.org/Organization">
                                            <a class="mvp-nav-logo-reg"
                                               href="{{route('site.home')}}"
                                               itemprop="url">
                                                <img alt="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}" data-rjs="2"
                                                     itemprop="logo" style="width: 80px; top: -12px; position: relative;"
                                                     src="assets/images/logos/web_logo_sm.png"/></a>
                                            <a class="mvp-nav-logo-small"
                                               href="{{route('site.home')}}">
                                                <img
                                                    alt="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}"
                                                    data-rjs="2"
                                                    src="assets/images/logos/logo2-nav.png"/></a>
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
                        <div class="mvp-nav-bot-right-out left">
                            <div class="mvp-nav-bot-right-in">
                                <div class="mvp-nav-bot-cont left">
                                    <div class="mvp-nav-bot-left-out">
                                        <div class="mvp-nav-bot-left left relative">
                                            <div class="mvp-fly-but-wrap mvp-fly-but-click left relative">
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                                <span></span>
                                            </div>
                                        </div>
                                        <div class="mvp-nav-bot-left-in">
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
                            <div class="mvp-nav-soc-wrap">
                                @foreach($siteSetting['social_accounts'] as $account=>$link)
                                    @if(!empty($link))
                                        <a href="{{$link}}"
                                           target="_blank"><span
                                                class="mvp-nav-soc-but fa fa-{{$account=='youtube'?($account.'-play'):$account}} fa-2"></span></a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="mvp-nav-bot-right left relative">
                                <span class="mvp-nav-search-but fa fa-search fa-2 mvp-search-click"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
