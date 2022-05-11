<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ URL::asset('/') }}"></base>
    <meta charset="utf-8"/>
    <title>{{ trans('admin/dashboard.admin_dashboard').' | '.trans('admin/dashboard.brand')}}</title>
    <meta name="description"
          content="{{ trans('admin/dashboard.admin_dashboard').' | '.trans('admin/dashboard.brand')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <link href="cp/css/pages/login/login-4.css" rel="stylesheet" type="text/css"/>
    <link href="cp/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="cp/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="cp/css/skins/header/base/light.css" rel="stylesheet" type="text/css"/>
    <link href="cp/css/skins/header/menu/light.css" rel="stylesheet" type="text/css"/>
    <link href="cp/css/skins/brand/dark.css" rel="stylesheet" type="text/css"/>
    <link href="cp/css/skins/aside/dark.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="cp/media/logos/favicon.ico"/>
    <style type="text/css">
        .kt-login.kt-login--v4.kt-login--signin .kt-login__signin {
            display: block;
            background-color: #fff;
            -webkit-border-radius: 7px;
            -moz-border-radius: 7px;
            -ms-border-radius: 7px;
            -o-border-radius: 7px;
            border-radius: 7px;
            width: 400px;
            margin: 40px auto 10px;
            padding: 10px 30px 30px;
            overflow: hidden;
            position: relative;
        }

        .kt-login.kt-login--v4 .kt-login__wrapper .kt-login__container .kt-form .kt-login__actions .kt-login__btn-secondary, .kt-login.kt-login--v4 .kt-login__wrapper .kt-login__container .kt-form .kt-login__actions .kt-login__btn-primary {
            height: 40px;
            padding-left: 2rem;
            padding-right: 2rem;
        }
    </style>
</head>

<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v4 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor"
             style="background-color: #364150!important;">
            <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                <div class="kt-login__container">
                    <div class="kt-login__logo">
                        <a href="#">
                            <img src="assets/images/logos/logo-light.png">
                        </a>
                    </div>
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">Sign In To Admin</h3>
                        </div>
                        {!! Form::open(['method'=>'post', 'action'=> 'Admin\LoginController@check','class'=>'kt-form login-form ']) !!}
                        <div class="alert alert-danger {{ (isset($error))?"":"kt-hidden" }}">
                            <button class="close" data-close="alert"></button>
                            <span> {{ isset($error) ? $error : "Enter any username and password. " }}</span>
                        </div>
                        <div class="input-group">
                            {!! Form::text('user_name',null,['class'=>'form-control form-control-solid placeholder-no-fix','autocomplete'=>'off','placeholder'=>trans('admin/dashboard.user_name')]) !!}
                        </div>
                        <div class="input-group">
                            {!! Form::password('password',['class'=>'form-control form-control-solid placeholder-no-fix','autocomplete'=>'off','placeholder'=>trans('admin/dashboard.password')]) !!}
                        </div>
                        <div class="kt-login__actions">
                            <button id="" class="btn btn-brand kt-login__btn-primary">
                                {{trans('admin/dashboard.login')}}
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="kt-login__account">
                        <span class="kt-login__account-msg">
                            {{date('Y')}} © {{trans('admin/dashboard.admin_dashboard')}}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>
<script src="cp/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="cp/js/scripts.bundle.js" type="text/javascript"></script>
<script src="cp/js/pages/custom/login/login-general.js" type="text/javascript"></script>
</body>
</html>
