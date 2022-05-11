<div class="mvp-post-soc-wrap left relative">
    <ul class="mvp-post-soc-list left relative">
        <a href="javascript:fbShare('{{url()->current()}}', 520, 350)"
           title="Share on Facebook">
            <li class="mvp-post-soc-fb">
                <i class="fa fa-2 fa-facebook" aria-hidden="true"></i>
            </li>
        </a>
        <a href="javascript:twitterShare('{{url()->current()}}', '{{ $post->title }}', 600, 585)"
           title="Tweet This Post">
            <li class="mvp-post-soc-twit">
                <i class="fa fa-2 fa-twitter" aria-hidden="true"></i>
            </li>
        </a>
    </ul>
</div>
<div id="mvp-soc-mob-wrap">
    <div class="mvp-soc-mob-out left relative">
        <div class="mvp-soc-mob-in">
            <div class="mvp-soc-mob-left left relative">
                <ul class="mvp-soc-mob-list left relative">
                    <a href="javascript:fbShare('{{url()->current()}}', 520, 350)"
                       title="Share on Facebook">
                        <li class="mvp-soc-mob-fb">
                            <i class="fa fa-facebook"
                               aria-hidden="true"></i><span
                                class="mvp-soc-mob-fb">Share</span>
                        </li>
                    </a>
                    <a href="javascript:twitterShare('{{url()->current()}}', '{{ $post->title }}', 600, 585)"
                       title="Tweet This Post">
                        <li class="mvp-soc-mob-twit">
                            <i class="fa fa-twitter"
                               aria-hidden="true"></i><span
                                class="mvp-soc-mob-fb">Tweet</span>
                        </li>
                    </a>
                </ul>
            </div>
        </div>
        <div class="mvp-soc-mob-right left relative">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
    </div>
</div>
