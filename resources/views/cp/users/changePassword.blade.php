<!DOCTYPE html>
<html class="no-js">
<head>
    <base href="{{ URL::asset('/') }}"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
    <title>Change Password</title>
</head>
<body style="margin:0;padding:0;">
<center style="padding: 0;">
    <table cellpadding="0" cellspacing="0" width="800" height="920" bgcolor="#5dcadf" background="images/body-bg.png"
           style="direction: ltr;">
        <tr>
            <td style="vertical-align: top;padding-top:58px;">
                <center>
                    <table cellpadding="0" cellspacing="0" style="width: 480px;height:550px;">
                        <tr>
                            <td>
                                <table cellpadding="0" cellspacing="0" style="width: 100%">
                                    <tr>
                                        <td style="width: 50%;">
                                            <img src="{{ url("site/img/logo.png") }}" width="74" height="43"
                                                 style="display:block;"/>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:56px;">
                                <table cellpadding="0" cellspacing="0"
                                       style="width: 100%;height:516px;border-radius:10px;box-shadow:0 0 43px rgba(0,0,0,0.09);"
                                       bgcolor="#fff">
                                    <tr>
                                        <td style="width:100%;height:206px;vertical-align: middle;border-radius:10px 10px 0 0;"
                                            background="{{ url("site/img/forget-image.jpg") }}">
                                            <font style="text-align:center;color:#fff;font-size:22px;font-family:tahoma;display:block;padding: 0 100px;">Don’t
                                                worry your account will be back</font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:40px 30px 30px 30px;vertical-align: top;">
                                            <font style="text-align:center;color:#000;font-size:24px;font-family:tahoma;display:block;">Hey {{ $name }}</font>
                                            <font style="text-align:center;color:#000;font-size:16px;font-family:tahoma;display:block;">We
                                                got a request to reset your password</font>
                                            <font style="text-align:center;color:#000;font-size:16px;font-family:tahoma;display:block;">Use
                                                this password to login</font>
                                            <center style="padding-top:20px;">
                                                <a style="display:block;border-radius:10px;background-color:#14caed;font-size:16px;font-family:tahoma;color:#fff;font-weight:bold;width:200px;padding:14px 20px;text-decoration:none;box-shadow:0 10px 13px rgba(0,0,0,0.14);">{{ $newPassword }}</a>
                                            </center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 40px;vertical-align: top;">
                                            <span style="width:100%;height:1px;background-color:#a7a7a7;opacity:0.2;display:block;"></span>
                                            <font style="padding:30px 40px;text-align:center;color:#7c7c7c;font-size:16px;font-family:tahoma;display:block;">if
                                                you ignore this message, your password won't be changed.</font>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:48px 40px 40px 40px;">
                                <table cellpadding="0" cellspacing="0" style="width:100%;">
                                    <tr>
                                        <td style="width:50%;vertical-align: middle;">
                                            <font style="text-align:center;color:#fff;font-size:12px;font-weight:bold;font-family:tahoma;display:block;padding-right: 30px;padding-bottom: 4px;">Join
                                                our Social Networks</font>
                                        </td>
                                        <td style="width:50%;vertical-align: middle;">
                                            @if($twitterLink)
                                                <a href="https://twitter.com/{{ $twitterLink }}" target="_blank"
                                                   style="text-decoration:none;display:inline-block;padding:0 8px;">
                                                    <img src="{{ url("site/img/twitter.png") }}"
                                                         style="width:16px;height:16px;display:block;"/>
                                                </a>
                                            @endif
                                            @if($instagramLink)
                                                <a href="https://www.instagram.com/{{ $instagramLink }}" target="_blank"
                                                   style="text-decoration:none;display:inline-block;padding:0 8px;">
                                                    <img src="{{ url("site/img/instagram.png") }}"
                                                         style="width:16px;height:16px;display:block;"/>
                                                </a>
                                            @endif
                                            @if($linkedInLink)
                                                <a href="https://www.linkedin.com/{{ $linkedInLink }}" target="_blank"
                                                   style="text-decoration:none;display:inline-block;padding:0 8px;">
                                                    <img src="{{ url("site/img/linkedin.png") }}"
                                                         style="width:16px;height:16px;display:block;"/>
                                                </a>
                                            @endif
                                            @if($facebookLink)
                                                <a href="https://www.facebook.com/{{ $facebookLink }}" target="_blank"
                                                   style="text-decoration:none;display:inline-block;padding:0 8px;">
                                                    <img src="{{ url("site/img/facebook.png") }}"
                                                         style="width:16px;height:16px;display:block;"/>
                                                </a>
                                            @endif
                                            @if($youtubeLink)
                                                <a href="https://youtube.com/{{ $youtubeLink }}" target="_blank"
                                                   style="text-decoration:none;display:inline-block;padding:0 8px;">
                                                    <img src="{{ url("site/img/youtube.png") }}"
                                                         style="width:18px;height:18px;display:block;"/>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="width:100%;height:1px;background-color:#fff;opacity:0.2;display:block;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <font style="padding:46px 30px 50px 30px;text-align:center;color:#a6f0ff;font-size:12px;font-weight:bold;font-family:tahoma;display:block;letter-spacing: 2px;">All
                                    rights reserved to TravelPathway {{ date("Y") }}</font>
                            </td>
                        </tr>
                    </table>
                </center>
            </td>
        </tr>
    </table>
</center>
</body>
</html>

