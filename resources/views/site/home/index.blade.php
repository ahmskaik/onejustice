@extends('site.layout.layout')
@section('content')
    @include('site.home.parts.hero'.($siteSetting['active_theme'][0]??1))
    <div class="left relative" id="mvp-home-widget-wrap">
        @include('site.home.parts.reports')
        @include('site.home.parts.media')
        @include('site.home.parts.get_involved')
        @include('site.home.parts.resources')
        @include('site.home.parts.videos')
    </div>
    @include('site.home.parts.more_news')
@endsection
