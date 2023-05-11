<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-header__brand " id="kt_header_brand">
            <div class="kt-header__brand-logo">
                <a href="{{url($cp_route_name)}}">
                    <img alt="Logo" src="cp/media/logos/logo-light.png" width="80"/>
                </a>
            </div>
        </div>
        <div class="kt-header__topbar">
            <div class="kt-header__topbar-item kt-header__topbar-item--langs">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                <span class="kt-header__topbar-icon">
                    @if( \Cookie::get('locale'))
                        <img class="" alt=""
                             src="cp/media/flags/{{
                            \Cookie::get('locale')=='ar'?'133-saudi-arabia.svg'
                            :(
                                \Cookie::get('locale')=='en'? '226-united-states.svg':'218-turkey.svg'
                            )}}">
                    @else
                        <img class="" alt="" src="cp/media/flags/226-united-states.svg">
                    @endif
                </span>
                </div>
                <div
                    class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
                    <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                        <li class="kt-nav__item kt-nav__item--{{\Cookie::get('locale')=='en'?'active':''}}">
                            <a href="{{route('admin.changeLang',['locale'=>'en'])}}" class="kt-nav__link">
                                <span class="kt-nav__link-icon"><img src="cp/media/flags/226-united-states.svg" alt=""></span>
                                <span class="kt-nav__link-text">English</span>
                            </a>
                        </li>
                        <li class="kt-nav__item kt-nav__item--{{\Cookie::get('locale')=='ar'?'active':''}}">
                            <a href="{{route('admin.changeLang',['locale'=>'ar'])}}" class="kt-nav__link">
                            <span class="kt-nav__link-icon">
                                <img src="cp/media/flags/133-saudi-arabia.svg" alt=""/>
                            </span>
                                <span class="kt-nav__link-text">Arabic</span>
                            </a>
                        </li>
                        <li class="kt-nav__item kt-nav__item--{{\Cookie::get('locale')=='tr'?'active':''}}">
                            <a href="{{route('admin.changeLang',['locale'=>'tr'])}}" class="kt-nav__link">
                            <span class="kt-nav__link-icon">
                                <img src="cp/media/flags/218-turkey.svg" alt=""/>
                            </span>
                                <span class="kt-nav__link-text">Turkish</span>
                            </a>
                        </li>
                        <li class="kt-nav__item kt-nav__item--{{\Cookie::get('locale')=='fr'?'active':''}}">
                            <a href="{{route('admin.changeLang',['locale'=>'fr'])}}" class="kt-nav__link">
                            <span class="kt-nav__link-icon">
                                <img src="cp/media/flags/195-france.svg" alt=""/>
                            </span>
                                <span class="kt-nav__link-text">French</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                    <span class="kt-header__topbar-welcome kt-visible-desktop">Hi,</span>
                    <span
                        class="kt-header__topbar-username kt-visible-desktop">{{Auth::user('admin')->full_name}}</span>
                    @if(Auth::user('admin')->thumb_image)
                        <img class="" alt="{{Auth::user('admin')->full_name}}"
                             src="{{loadImage(Auth::user('admin')->avatar,'users','29','29') }}"/>
                    @else
                        <span
                            class="kt-header__topbar-icon kt-bg-brand"><b>{{generateNameInitials(Auth::user('admin')->full_name)}}</b></span>
                    @endif
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                    <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                         style="background-image: url(cp/media/misc/bg-1.jpg)">
                        <div class="kt-user-card__avatar">
                            @if(Auth::user('admin')->avatar)
                                <img class="" alt="Pic"
                                     src="{{loadImage(Auth::user('admin')->avatar,'users','29','29') }}"/>

                            @else
                                <span
                                    class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">
                                {{generateNameInitials(Auth::user('admin')->full_name)}}</span>
                            @endif
                        </div>
                        <div class="kt-user-card__name">
                            {{Auth::user('admin')->full_name}}
                        </div>
                        <div class="kt-user-card__badge">
                            <span class="btn btn-success btn-sm btn-bold btn-font-md text-uppercase">Admin</span>
                        </div>
                    </div>
                    <div class="kt-notification">
                        <a href="{{route('profile_overview')}}"
                           class="kt-notification__item">
                            <div class="kt-notification__item-icon">
                                <i class="flaticon2-calendar-3 kt-font-success"></i>
                            </div>
                            <div class="kt-notification__item-details">
                                <div class="kt-notification__item-title kt-font-bold">
                                    My Profile
                                </div>
                                <div class="kt-notification__item-time">
                                    Account settings and more
                                </div>
                            </div>
                        </a>
                        <div class="kt-notification__custom kt-space-between">
                            <a href="{{ config('app.cp_route_name') }}/logout"
                               class="btn btn-label btn-label-brand btn-sm btn-bold">{{trans('admin/dashboard.sign_out')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
