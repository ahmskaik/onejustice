<!DOCTYPE html>
<html lang="{{$locale}}">

<head>
    <base href="{{ URL::asset('/') }}"/>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"
          id="viewport"
          name="viewport"/>
    <meta content="{{ $siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}"
          property="og:description"/>
    <title>{{ $title ?? $siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}</title>
    <meta content='max-image-preview:large' name='robots'/>

    @if($locale==='ar')
        <link href='assets/css/style.rtl.css?ver=7.8.1' media='all' rel='stylesheet' type='text/css'/>
        <link href='assets/css/media-queries.rtl.css?ver=5.9' media='all' rel='stylesheet' type='text/css'/>
    @else
        <link href='assets/css/style.css?ver=7.7' media='all' rel='stylesheet' type='text/css'/>
        <link href='assets/css/media-queries.css?ver=5.9' media='all' rel='stylesheet' type='text/css'/>
    @endif

    <link href='assets/css/reset.css?ver=5.7' media='all' rel='stylesheet' type='text/css'/>
    <link href='assets/css/fonts/font-awesome/font-awesome.css?ver=5.8' media='all' rel='stylesheet' type='text/css'/>
    <link crossorigin="anonymous"
          href='https://fonts.googleapis.com/css?family=Roboto:300,400,700,900|Open Sans:700|&subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese'
          media='all'
          rel='stylesheet' type='text/css'/>

    @yield('css')

    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body class="page" dir="{{$locale==='ar'  ?'rtl':'ltr'}}">
<div id="mvp-fly-wrap">
    <div class="left relative" id="mvp-fly-menu-top">
        <div class="mvp-fly-top-out left relative">
            <div class="mvp-fly-top-in">
                <div class="left relative" id="mvp-fly-logo">
                    <a href="{{route('site.home')}}">
                        <img
                            alt="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}"
                            data-rjs="2" src="assets/images/logos/logo-nav.png"/></a>
                </div>
            </div>
            <div class="mvp-fly-but-wrap mvp-fly-but-menu mvp-fly-but-click">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <div id="mvp-fly-menu-wrap">
        <nav class="mvp-fly-nav-menu left relative">
            <div class="menu-main-menu-container">
                <ul class="menu">
                    @include('site.layout.nav')
                </ul>
            </div>
        </nav>
    </div>
    @include('site.layout.social')
</div>
<div class="left relative" id="mvp-site">
    <div id="mvp-search-wrap">
        <div id="mvp-search-box">
            <form action="{{route('site.search')}}" id="searchform" method="get">
                <input id="s" name="s" onblur='if (this.value == "") { this.value = "{{trans('site.search')}}"; }'
                       onfocus='if (this.value == "{{trans('site.search')}}") { this.value = ""; }'
                       type="text"
                       value="{{trans('site.search')}}"/>
                <input id="searchsubmit" type="hidden" value="{{trans('site.search')}}"/>
            </form>
        </div>
        <div class="mvp-search-but-wrap mvp-search-click">
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="left relative" id="mvp-site-wall">
        <div class="left relative" id="mvp-site-main">
            @include('site.layout.header')
            <div class="left relative" id="mvp-main-body-wrap">
                @yield('content')
            </div>
            @include('site.layout.footer')
        </div>
    </div>
</div>
<div class="mvp-fly-top back-to-top">
    <i class="fa fa-angle-up fa-3"></i>
</div>
<div class="mvp-fly-fade mvp-fly-but-click">
</div>
<script src='assets/js/jquery.min.js?ver=3.5.1' type='text/javascript'></script>
<script src='assets/js/main.js?ver=1.7.0' type='text/javascript'></script>
<script src='assets/js/scripts.js?ver=5.7' type='text/javascript'></script>
@yield('js')
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-58445510-2', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
