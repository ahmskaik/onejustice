<section class="mvp-widget-home left relative mvp_home_feat2_widget" id="subscribe-section">
    <div class="mvp-main-box">
        <div class="mvp-widget-home-head">
            <h4 class="mvp-widget-home-title">
                <span class="mvp-widget-home-title">{{trans('site.subscribe_to_our_newsletter')}}</span>
            </h4>
        </div>
        <div class="mvp-widget-feat2-wrap left relative">
            <div class="mvp-widget-feat2-out left relative">
                <div class="mvp-widget-feat1-top-story left relative" style="margin-left: 0;">
                    <h2 class="">
                        {{trans('site.subscribe_to_our_newsletter')}}
                    </h2>
                    <div class="heading__description">
                        <p>{{trans('site.to_receive_the_latest_newsletters')}}</p>
                    </div>
                </div>
                <div class="mvp-widget-feat1-top-story left relative">

                    <form class="subscribe-form" method="post" action="{{route('site.subscribe')}}">
                        @csrf
                        <div class="subscribe-form-wrapper">
                            <p class="">
                                <label>
                                    <input type="email" name="email" placeholder="{{trans('site.your_email')}}"
                                           required="" value="{{ old('email')}}">
                                </label>
                                <input type="submit" class="btn-submit" value="{{trans('site.subscribe')}}">
                            </p>
                            @if(isset($success))
                                <span style="color: #5aff5d">{{$success}}</span>
                            @endif
                            @if(count($errors))
                                <span style="color: #d94932">{{$errors->first()}}</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
