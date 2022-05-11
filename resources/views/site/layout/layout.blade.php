<!DOCTYPE html>
<html lang="{{$locale}}">

<head>
    <base href="{{ URL::asset('/') }}"/>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"
          id="viewport"
          name="viewport"/>
    <meta content="Europal Forum" property="og:description"/>
    <title>{{ $title ?? $siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}</title>
    <meta content='max-image-preview:large' name='robots'/>
    @if($locale==='ar')
        <link href='assets/css/style.rtl.min.css?ver=5.7' media='all' rel='stylesheet' type='text/css'/>
        <link href='assets/css/style.rtl.css?ver=5.7' id='mvp-custom-style-css' media='all' rel='stylesheet'
              type='text/css'/>
        <style type='text/css'>
            .mvp-feat1-feat-text h2,
            h1.mvp-post-title,
            .mvp-feat2-top-text h2,
            .mvp-feat3-main-text h2 {
                font-family: 'NassimArabic-Rg', "Arial", sans-serif;
                font-weight: 600;
                letter-spacing: normal;
                line-height: 1;
            }
        </style>
    @else
        <link href='assets/css/style.min.css?ver=5.7' media='all' rel='stylesheet' type='text/css'/>
        <link href='assets/css/style.css?ver=5.7' id='mvp-custom-style-css' media='all' rel='stylesheet'
              type='text/css'/>
        <style type='text/css'>
            .mvp-feat1-feat-text h2,
            h1.mvp-post-title,
            .mvp-feat2-top-text h2,
            .mvp-feat3-main-text h2 {
                font-family: "Roboto", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
                font-weight: 600;
                letter-spacing: normal;
                line-height: 1;
            }
        </style>
    @endif
    <link href='assets/css/fonts/dashicons/dashicons.min.css?ver=5.7' media='all' rel='stylesheet' type='text/css'/>

    <link href='assets/css/reset.css?ver=5.7' media='all' rel='stylesheet' type='text/css'/>
    <link href='assets/css/fonts/font-awesome/font-awesome.css?ver=5.7' media='all' rel='stylesheet' type='text/css'/>
    <link crossorigin="anonymous"
          href='https://fonts.googleapis.com/css?family=Roboto:300,400,700,900|Open Sans:700|&subset=latin,latin-ext,cyrillic,cyrillic-ext,greek-ext,greek,vietnamese'
          media='all'
          rel='stylesheet' type='text/css'/>

    <link href='assets/css/media-queries.css?ver=5.7' media='all' rel='stylesheet' type='text/css'/>

    <style type="text/css">
        #mvp-main-nav-top {
            background: #fff;
            padding: 15px 0 0;
        }

        #mvp-fly-wrap, .mvp-soc-mob-right, #mvp-main-nav-small-cont {
            background: #fff;
        }

        #mvp-event-wrap .mvp-post-main-in {
            margin-right: 0 !important;
        }

        #mvp-event-wrap #mvp-post-main {
            margin: 10px 0 60px;
            width: 100%;
        }

        #mvp-main-nav-small .mvp-fly-but-wrap span,
        #mvp-main-nav-small .mvp-search-but-wrap span,
        .mvp-nav-top-left .mvp-fly-but-wrap span,
        #mvp-fly-wrap .mvp-fly-but-wrap span {
            background: #000;
        }

        .mvp-nav-top-right .mvp-nav-search-but,
        span.mvp-fly-soc-head,
        .mvp-soc-mob-right i,
        #mvp-main-nav-small span.mvp-nav-search-but,
        #mvp-main-nav-small .mvp-nav-menu ul li a {
            color: #000;
        }

        #mvp-main-nav-small .mvp-nav-menu ul li.menu-item-has-children a:after {
            border-color: #000 transparent transparent transparent;
        }


        span.mvp-nav-soc-but,
        ul.mvp-fly-soc-list li a {
            background: rgba(0, 0, 0, .8);
        }


        nav.mvp-fly-nav-menu ul li,
        nav.mvp-fly-nav-menu ul li ul.sub-menu {
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        nav.mvp-fly-nav-menu ul li a {
            color: #000;
        }

        .mvp-drop-nav-title h4 {
            color: #000;
        }
    </style>
    @yield('css')
    <link href="assets/favicon/apple-icon-57x57.png" rel="apple-touch-icon" sizes="57x57">
    <link href="assets/favicon/apple-icon-60x60.png" rel="apple-touch-icon" sizes="60x60">
    <link href="assets/favicon/apple-icon-72x72.png" rel="apple-touch-icon" sizes="72x72">
    <link href="assets/favicon/apple-icon-76x76.png" rel="apple-touch-icon" sizes="76x76">
    <link href="assets/favicon/apple-icon-114x114.png" rel="apple-touch-icon" sizes="114x114">
    <link href="assets/favicon/apple-icon-120x120.png" rel="apple-touch-icon" sizes="120x120">
    <link href="assets/favicon/apple-icon-144x144.png" rel="apple-touch-icon" sizes="144x144">
    <link href="assets/favicon/apple-icon-152x152.png" rel="apple-touch-icon" sizes="152x152">
    <link href="assets/favicon/apple-icon-180x180.png" rel="apple-touch-icon" sizes="180x180">
    <link href="assets/favicon/android-icon-192x192.png" rel="icon" sizes="192x192" type="image/png">
    <link href="assets/favicon/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png">
    <link href="assets/favicon/favicon-96x96.png" rel="icon" sizes="96x96" type="image/png">
    <link href="assets/favicon/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png">
    <link href="assets/favicon/manifest.json" rel="manifest">
    <meta content="#ffffff" name="msapplication-TileColor">
    <meta content="assets/favicon/ms-icon-144x144.png" name="msapplication-TileImage">
    <meta content="#ffffff" name="theme-color">
</head>
<body class="page" dir="{{$locale==='ar'  ?'rtl':'ltr'}}">
<div id="mvp-fly-wrap">
    <div class="left relative" id="mvp-fly-menu-top">
        <div class="mvp-fly-top-out left relative">
            <div class="mvp-fly-top-in">
                <div class="left relative" id="mvp-fly-logo">
                    <a href="{{route('site.home')}}">
                        <img alt="{{$siteSetting['app_brand']->{$locale}??$siteSetting['app_brand']->{$fallbackLanguage} }}"
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
{{--    <div id="cookie-law-info-bar" data-nosnippet="true"
         style="background-color: rgb(255, 255, 255); color: rgb(0, 0, 0); font-family: inherit; bottom: 0px; position: fixed; display: block;">
        <span>We use cookies to  give you the best experience on our website. To learn more, please visit our
            <a href="{{route('site.safety')}}">Privacy Policy</a>.
            By continuing on our website, you accept the use of cookies and our revised
            <a href="{{route('site.safety')}}">Privacy Policy</a>
            <a role="button"
               tabindex="0"
               class="cli_action_button cli-accept-button medium cli-plugin-button green"
               data-cli_action="accept">Accept</a>
        </span>
    </div>--}}
</div>
<div class="mvp-fly-top back-to-top">
    <i class="fa fa-angle-up fa-3"></i>
</div>
<div class="mvp-fly-fade mvp-fly-but-click">
</div>
<script src='assets/js/jquery.min.js?ver=3.5.1' type='text/javascript'></script>
<script src='assets/js/main.js?ver=1.7.0' type='text/javascript'></script>
<script src='assets/js/scripts.js?ver=5.7' type='text/javascript'></script>
<script src='assets/js/retina.js?ver=5.7' type='text/javascript'></script>
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
