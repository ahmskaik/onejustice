@extends('site.layout.layout')
@section('css')
    <style>
        .kt-separator {
            margin: 2.5rem 0;
            border-bottom: 1px dashed #ebedf2;
            height: 0;
        }

        .contact-details {

            padding: 0 2rem;
        }

        .contact-details-item {
            margin: 1rem 0;
            display: block;
        }

        .contact-details-item:last-child {
            margin: 0.5rem 0;
        }

        .contact-details-item i {
            padding: 0 5px;
        }

        .contact-details ul.mvp-foot-soc-list {
            text-align: unset !important;margin-top: 10px;
        }

        .fcf-form-group {
            margin-bottom: 1rem;
        }

        .fcf-input-group {
            position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
        }

        .fcf-form-control {
            display: block;
            width: 100%;
            height: calc(1.4em + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            outline: none;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .fcf-form-control:focus {
            border: 1px solid #313131;
        }

        select.fcf-form-control[size], select.fcf-form-control[multiple] {
            height: auto;
        }

        textarea.fcf-form-control {
            height: auto;
        }

        label.fcf-label {
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .fcf-btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            .fcf-btn {
                transition: none;
            }
        }

        .fcf-btn:hover {
            color: #212529;
            text-decoration: none;
        }

        .fcf-btn:focus, .fcf-btn.focus {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .fcf-btn-primary {
            color: #fff;
            background-color: #428bca;
            border-color: #3d80ba;
        }

        .fcf-btn-primary:hover {
            color: #fff;
            background-color: #3d80ba;
            border-color: #428bca;
        }

        .fcf-btn-primary:focus, .fcf-btn-primary.focus {
            color: #fff;
            background-color: #3d80ba;
            border-color: #428bca;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        .fcf-btn-lg, .fcf-btn-group-lg > .fcf-btn {
            padding: 0.3rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.3rem;
        }

        .fcf-btn-block {
            display: block;
            width: 100%;
        }

        .fcf-btn-block + .fcf-btn-block {
            margin-top: 0.5rem;
        }

        input[type="submit"].fcf-btn-block, input[type="reset"].fcf-btn-block, input[type="button"].fcf-btn-block {
            width: 100%;
        }</style>
@endsection

@section('content')
    <div class="mvp-main-box">
        <div class="mvp-main-blog-cont left relative">
            <header id="mvp-post-head" style="padding: 13px 0 0 0;margin: 1rem 0 3rem 0"
                    class="left relative light-bg">
                <h3 class="mvp-post-cat left relative">
                    <a>
                        <span style="border: none!important;font-size: 1.5rem !important;"
                              class="mvp-post-cat left"> {{$title}} </span>
                    </a>
                </h3>
            </header>
            <div class="mvp-main-blog-out left relative light-bg">
                <div class="mvp-main-blog-in">
                    <div class="mvp-main-blog-body left relative">
                        <p style="text-align: center">
                            <img src="assets/images/logos/logo2-nav.png">
                        </p>
                        {!! $content->the_body !!}
                        <div class="contact-details">
                            <div class="kt-separator kt-separator--space-lg kt-separator--border-dashed"></div>
                            <p>{{trans('site.contact_us')}}:</p>
                            @if(isset($siteSetting['contact_phone'][0]))
                                <a class="contact-details-item">
                                    <i aria-hidden="true" class="fa fa-phone"></i> {{$siteSetting['contact_phone'][0]}}
                                </a>
                            @endif
                            @if(isset($siteSetting['contact_phone'][0]))
                                <a class="contact-details-item">
                                    <i aria-hidden="true"
                                       class="fa fa-envelope"></i> {{$siteSetting['contact_email'][0]}}
                                </a>
                            @endif
                            <div class="kt-separator kt-separator--space-lg kt-separator--border-dashed"></div>
                            <p>{{trans('site.keep_in_touch')}}:</p>
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
                    </div>
                </div>
                <div id="mvp-side-wrap" class="left relative ">
                    <section id="mvp_tabber_widget-5" class="mvp-side-widget mvp_tabber_widget">
                        <div class="mvp-widget-tab-wrap left relative">
                            @if(session('success'))
                                <p style="color: #ffffff; background: #1dc9b7; padding: 0.7rem; margin-bottom: 1rem; border-radius: 6px;">{{session('success')}}</p>
                            @endif
                            <form id="fcf-form-id" class="fcf-form-class" method="post"
                                  action="{{route('site.contact.submit')}}">
                                @csrf
                                <div class="fcf-form-group">
                                    <label for="Name" class="fcf-label">{{trans('site.contact_us_page.name')}}</label>
                                    <div class="fcf-input-group">
                                        <input type="text" id="Name" name="name" value="{{old('name')}}"
                                               class="fcf-form-control" required>
                                    </div>
                                </div>
                                <div class="fcf-form-group">
                                    <label for="Email" class="fcf-label">{{trans('site.contact_us_page.email')}}</label>
                                    <div class="fcf-input-group">
                                        <input type="email" id="Email" name="email" value="{{old('email')}}"
                                               class="fcf-form-control" required>
                                    </div>
                                </div>
                                <div class="fcf-form-group">
                                    <label for="Message"
                                           class="fcf-label">{{trans('site.contact_us_page.message')}}</label>
                                    <div class="fcf-input-group">
                                        <textarea id="Message" name="message" class="fcf-form-control" rows="6"
                                                  maxlength="3000" required>{{old('message')}}</textarea>
                                    </div>
                                </div>
                                <div class="fcf-form-group">
                                    <button type="submit" id="fcf-button"
                                            class="fcf-btn fcf-btn-primary fcf-btn-lg fcf-btn-block">{{trans('site.contact_us_page.send')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
