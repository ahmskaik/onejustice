<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
    <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
        <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
             data-ktmenu-dropdown-timeout="500">
            <ul class="kt-menu__nav">
                <li class="kt-menu__item">
                    <a href="{{ config('app.cp_route_name') }}" class="kt-menu__link">
                       <span class="kt-menu__link-icon">
                         <i class="flaticon-home"></i>
                       </span>
                        <span class="kt-menu__link-text">{{trans('admin/dashboard.home_page')}}</span>
                    </a>
                </li>
                @foreach($menuActions as $action)
                    @if(in_array($action->id,$allowedActions)
                         || ($action->actionsMenu
                         && sizeof($action->actionsMenu)
                         && hasOneChild($allowedActions,$action->actionsMenu)))
                        <li class="kt-menu__item {{ isset($active_menu) && $active_menu==$action->routes[0]->route_name? "kt-menu__item--submenu kt-menu__item--open kt-menu__item--here":"" }}"
                            aria-haspopup="true">
                            <a href="{{ route($action->routes[0]->route_name) }}"
                               class="kt-menu__link kt-menu__toggle kt-menu__link">
                                <span class="kt-menu__link-icon">
                                    <i class="{{ $action->icon }}"></i>
                                </span>
                                <span class="kt-menu__link-text">
                                    @if($action->actionsMenu && sizeof($action->actionsMenu))
                                        {{ $action->menu_group_name->{$locale} ??  $action->group_name }}
                                    @else
                                        {{ $action->name->{$locale}??$action->name->en }}
                                    @endif
                                </span>
                                @if( isset($menuActionsValue[$action->id]) && $menuActionsValue[$action->id])
                                    {{--<span class="badge badge-danger">{{ $menuActionsValue[$action->id] }}</span>--}}
                                    <span
                                        class="kt-badge ml-2 kt-badge--warning kt-badge--rounded">{{$menuActionsValue[$action->id]}}</span>
                                @endif
                                @if($action->actionsMenu && sizeof($action->actionsMenu))
                                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                                @endif
                            </a>
                            @if($action->actionsMenu && sizeof($action->actionsMenu))
                                <div class="kt-menu__submenu ">
                                    <span class="kt-menu__arrow"></span>
                                    <ul class="kt-menu__subnav">
                                        @if(in_array($action->id,$allowedActions))
                                            <li class="kt-menu__item nav-item {{ isset($active_menuPlus) && $active_menuPlus==$action->routes[0]->route_name?"kt-menu__item--active":"" }} ">
                                                <a href="{{ route($action->routes[0]->route_name) }}"
                                                   class="nav-link kt-menu__link ">
                                                    <i class="{{--{{ $action->icon }} kt-menu__link-bullet mr-2--}} kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                                    <span
                                                        class="kt-menu__link-text"> {{$action->name->{$locale}??$action->name->en }}</span>
                                                    @if(isset($menuActionsValue[$action->id]) && $menuActionsValue[$action->id])
                                                        <span
                                                            class="badge badge-danger">{{ $menuActionsValue[$action->id] }}</span>
                                                    @endif
                                                </a>
                                            </li>
                                        @endif
                                        @foreach($action->actionsMenu as $subAction)
                                            @if(in_array($subAction->id,$allowedActions))
                                                <li class="kt-menu__item nav-item {{ isset($active_menuPlus) && $active_menuPlus==$subAction->routes[0]->route_name?"kt-menu__item--active":"" }} ">
                                                    <a href="{{ route($subAction->routes[0]->route_name) }}"
                                                       class="kt-menu__link kt-menu__toggle">
                                                        <i class="{{--{{ $subAction->icon }} kt-menu__link-bullet mr-2--}} kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                                        <span
                                                            class="kt-menu__link-text">
                                                            {{--{{ $subAction->group_name?$subAction->group_name:$subAction->name }}--}}
                                                            {{$subAction->name->{$locale} ??  $subAction->group_name }}
                                                        </span>
                                                        @if($subAction->actionsMenu && sizeof($subAction->actionsMenu))
                                                            <span class="arrow"></span>
                                                        @endif
                                                        @if(  isset($menuActionsValue[$subAction->id]) && $menuActionsValue[$subAction->id])
                                                            <span
                                                                class="badge badge-danger">{{ $menuActionsValue[$subAction->id] }}</span>
                                                        @endif
                                                    </a>

                                                    @if($subAction->countActionsMenu)
                                                        <div class="kt-menu__submenu ">
                                                            <span class="kt-menu__arrow"></span>
                                                            <ul class="kt-menu__subnav">
                                                                @if(in_array($subAction->id,$allowedActions))
                                                                    <li class="kt-menu__item  nav-item {{ isset($active_menuPlus2) && $active_menuPlus2==$subAction->routes[0]->route_name?"kt-menu__item--active":"" }} ">
                                                                        <a href="{{ route($subAction->routes[0]->route_name) }}"
                                                                           class="nav-link kt-menu__link">
                                                                            <i class="{{ $subAction->icon }}"></i>
                                                                            <span
                                                                                class="kt-menu__link-text"> {{ $subAction->name }}</span>
                                                                            @if($subAction->hasSpecial && isset($menuActionsValue[$subAction->id]) && $menuActionsValue[$subAction->id])
                                                                                <span
                                                                                    class="badge badge-danger">{{ $menuActionsValue[$subAction->id] }}</span>
                                                                            @endif
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @foreach($subAction->actionsMenu as $subSubAction)
                                                                    <li class="nav-item {{ isset($active_menuPlus2) && $active_menuPlus2==$subSubAction->routes[0]->route_name?"kt-menu__item--active":"" }} ">
                                                                        <a href="{{ route($subSubAction->routes[0]->route_name) }}"
                                                                           class="nav-link kt-menu__link">
                                                                            <i class="{{ $subSubAction->icon }} kt-menu__link-bullet"></i>
                                                                            <span
                                                                                class="kt-menu__link-text"> {{ $subSubAction->name }}</span>
                                                                            @if($subSubAction->hasSpecial && isset($menuActionsValue[$subSubAction->id]) && $menuActionsValue[$subSubAction->id])
                                                                                <span
                                                                                    class="badge badge-danger">{{ $menuActionsValue[$subSubAction->id] }}</span>
                                                                            @endif
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </li>
                    @endif
                @endforeach
                <li class="kt-menu__item">
                    <a href="{{ config('app.cp_route_name') }}/logout" class="kt-menu__link">
                       <span class="kt-menu__link-icon">
                         <i class="fa fa-power-off"></i>
                       </span>
                        <span class="kt-menu__link-text">{{trans('admin/dashboard.sign_out')}}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
