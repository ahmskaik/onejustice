@extends('site.layout.layout')
@section('css')
    <link rel='stylesheet' href='assets/css/stripe-donate.css?ver=6.0' type='text/css' media='all'/>
    <style>
        #mvp-main-body-wrap {
            padding-bottom: 5px !important;
        }

        .featured-fluid-section {
            position: relative;
            padding: 0px;
            min-height: 250px;
            background: #f9f9f9;
        }

        .featured-fluid-section .column {
            position: relative;
            display: block;
            float: left;
            width: 50%;
        }

        .featured-fluid-section .image-column {
            position: absolute;
            left: 0px;
            top: 0px;
            width: 50%;
            height: 150%;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            float: right;
        }

        .clearfix:before {
            display: table;
            content: " ";
        }

        .featured-fluid-section .text-column {
            float: right;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .featured-fluid-section .text-column .content-box {
            position: relative;
            max-width: 600px;
            padding-left: 15px;
        }

        .featured-fluid-section .dark-column .content-box {
            padding: 88px 15px 101px 75px;
            color: #a8a8a8;
        }

        .pull-left {
            float: left !important;
        }

        .featured-fluid-section .dark-column:before {
            content: '';
            position: absolute;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background: rgba(25, 25, 25, 0.95);
        }

        .featured-fluid-section.style-two .dark-column:before {
            background: rgba(106, 198, 16, 0.95);
        }

        .featured-fluid-section .dark-column h2 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            line-height: 1.2em;
            font-family: 'Droid Arabic Kufi', "Arial", sans-serif;
        }

        .featured-fluid-section .dark-column .title-text {
            position: relative;
            color: #ffffff;
            font-size: 18px;
            font-weight: 300;
            margin-bottom: 40px;
            padding-bottom: 15px;
        }

        .featured-fluid-section.style-two .dark-column .title-text a {
            color: #ffffff;
        }

        .featured-fluid-section .dark-column .title-text:after {
            content: '';
            position: absolute;
            top: 100%;
            width: 30px;
            height: 3px;
            background: #6ac610;
            color: #ffffff;
        }

        .featured-fluid-section.style-two .dark-column .title-text:after {
            background: #ffffff;
        }

        .featured-fluid-section .theme-btn {
            margin-right: 15px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .featured-fluid-section .dark-column .text {
            position: relative;
            color: #d5d5d5;
            font-size: 15px;
            margin-bottom: 50px;
        }

        .featured-fluid-section.style-two .dark-column .text {
            color: #f2f2f2;
        }

        .btn-style-one {
            margin-right: 15px;
            position: relative;
            display: inline-block;
            line-height: 24px;
            padding: 11px 25px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            background: #6ac610;
            color: #ffffff !important;
            border: 2px solid #6ac610 !important;
            border-radius: 3px;
            font-family: 'Droid Arabic Kufi', "Arial", sans-serif;
        }
    </style>

@endsection

@section('js')
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script type='text/javascript' src='https://checkout.stripe.com/checkout.js?ver=6.0'
            id='stripe-checkout-js'></script>
    <script>
        var handler_Demo = StripeCheckout.configure({
            key: 'pk_live_51InPstJGgSCoxU8otlYIHhBFbETITJJLvy51ObjlQEB4QO45dHC41kUaCrTx0ugcniAypkkMbkNLE6M4wuq4mE5J00sQvijyCt',
            // key: 'pk_test_ngsCwDpgOU5BW69TiM7nAI4V00buaToWlk',
            image: '',
            token: function (token) {
                var donation_amount = jQuery('#stripe-donate-amount').val().replace(/,/, "");
                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                jQuery.ajax(
                    {
                        type: "POST",
                        url: 'en/donate',
                        data: {
                            token: token.id,
                            amount: donation_amount
                        },
                        success: function (msg) {
                            if (msg) {
                                /*jQuery('#stripe-donate-form, #vav-stripe-donation-error-Demo').hide();*/
                                jQuery('#donation-success').html(msg).show();
                            }
                        },
                        error: function (xhr, status, error) {
                            jQuery('#donation-success').hide();
                            jQuery('#vav-stripe-donation-error-Demo').html(xhr.responseText).show();
                        }
                    });
            }
        });
        $(document).on('click', '#stripe-donate-button', function (e) {
            var ajax_donation_amount = $('#stripe-donate-amount').val().replace(/,/, "");
            if (ajax_donation_amount && $.isNumeric(ajax_donation_amount) && ajax_donation_amount != 0.00) {
                $("#vav-stripe-donation-error-Demo").html('').hide();

                // Open Checkout with further options
                handler_Demo.open({
                    name: '{{strtoupper(env('app_name'))}}',
                    description: 'Donation of thanks',
                    amount: ajax_donation_amount * 100,
                    panelLabel: "Donate ",
                    allowRememberMe: false,
                    currency: 'USD',
                    zipCode: false,
                    email: ''
                });
                e.preventDefault();
            } else {
                $("#vav-stripe-donation-error-Demo").html('Please enter an amount you would like to donate').slideDown('fast');
            }
        });
    </script>
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <article id="mvp-article-wrap" itemscope itemtype="http://schema.org/NewsArticle">
        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage"
              itemid="#"/>
        <div id="mvp-article-cont" class="{{$locale==='ar'?'right':'left'}} relative">
            <section class="featured-fluid-section">
                <div class="outer clearfix">
                    <div class="image-column" style="background-image:url(assets/images/donate.jpg);"></div>
                    <article class="column text-column dark-column wow fadeInRight animated" data-wow-delay="0ms"
                             data-wow-duration="1500ms"
                             style="background-image: url(&quot;images/resource/fluid-image-2.jpg&quot;); visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInRight;">

                        <div class="content-box" style="padding-right: 6rem;">
                            <h2>{{trans('site.donate_for_us')}}
                            </h2>
                            <div class="title-text">{{trans('site.donate_small_amount')}}
                            </div>
                            {{--<a href="#" class="theme-btn btn-style-one">{{trans('site.donate_now')}}</a>--}}
                            <div class="entry-content">
                                <div class="vav-stripe-donation-wrap vav-stripe-donation-layout-user-amount">
                                    <div id="donation-success"
                                         class="vav-stripe-donation-message-box vav-stripe-donation-success-message-box"></div>
                                    <div id="vav-stripe-donation-error-Demo"
                                         class="vav-stripe-donation-message-box vav-stripe-donation-error-message-box"></div>
                                    <div id="stripe-donate-form" class="vav-stripe-donate-form-user-amount">
                                        <p>
                                            {{trans('site.amount')}}: $ <input type="text" id="stripe-donate-amount"
                                                                               name="vav-ajax-donate-amount" value="5"
                                                                               style="width:75px;">&nbsp;
                                            <button id="stripe-donate-button"
                                                    class="vav-stripe-donation-button">{{trans('site.donate_now')}}
                                            </button>
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </article>
@endsection
