<footer class="left relative" id="mvp-foot-wrap">
    <div class="left relative" id="mvp-foot-top">
        <div class="mvp-main-box">
            <div class="left relative" id="mvp-foot-logo">
                <a href="{{route('site.home')}}">
                    <img alt="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}"
                         data-rjs="2" width="130" src="assets/images/logos/logo-nav.png"/>
                </a>
            </div>
            <div class="left relative" id="mvp-foot-description" style="margin-bottom: 1rem">
                <span style="color: #fff;">
                    {{trans('site.footer_description')}}
                </span>
            </div>
            <div class="left relative" id="mvp-foot-soc">
                <ul class="mvp-foot-soc-list left relative">
                    @foreach($siteSetting['social_accounts'] as $account=>$link)
                        @if(!empty($link))
                            <li><a class="fa fa-{{$account=='youtube'?($account.'-play'):$account}} fa-2"
                                   href="{{$link}}"
                                   target="_blank"></a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="left relative" id="mvp-foot-menu-wrap">
                <div class="left relative" id="mvp-foot-menu">
                    <div class="menu-footer-menu-container">
                        <ul class="menu" id="menu-footer-menu">
                            <li class="menu-item"><a href="{{route('site.home')}}">{{trans('site.home')}}</a></li>
                            <li class="menu-item @if(isset($active_tab)&& $active_tab=='about_us') active @endif"><a
                                    href="{{route('site.about')}}">{{trans('site.about_us')}}</a></li>
                          {{--  <li class="menu-item @if(isset($active_tab)&& $active_tab=='terms') active @endif"><a
                                    href="{{ route('site.terms') }}">{{trans('site.terms_and_conditions')}}</a></li>--}}
                            {{--<li class="menu-item @if(isset($active_tab)&& $active_tab=='accessibility') active @endif">
                                <a
                                    href="{{route('site.accessibility')}}">{{trans('site.website_accessibility')}}</a>
                            </li>--}}
                         {{--   <li class="menu-item @if(isset($active_tab)&& $active_tab =='safety') active @endif"><a
                                    href="{{route('site.safety')}}">{{trans('site.safety_and_security')}}</a></li>--}}
                            <li class="menu-item @if(isset($active_tab)&& $active_tab =='contact') active @endif"><a
                                    href="{{route('site.contact.index')}}">{{trans('site.contact_us')}}</a></li>
                            <li class="menu-item @if(isset($active_tab)&& $active_tab =='contact') active @endif"><a
                                    href="{{route('site.donate.index')}}">{{trans('site.donate')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="left relative" id="mvp-foot-bot">
        <div class="mvp-main-box">
            <div class="left relative" id="mvp-foot-copy">
                <p>{{trans('site.copyright')}} © {{date('Y').' '.($siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage})  }} </p>
            </div>
        </div>
    </div>
</footer>
