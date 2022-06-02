@extends('site.layout.layout')
@section('css')

    @if($locale==='ar')
        <link href='assets/css/newsmap.rtl.css?ver=5.7' media='all' rel="stylesheet"/>
    @else
        <link href='assets/css/newsmap.css?ver=5.7' media='all' rel="stylesheet"/>
    @endif

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC6Xu5RSDCwNEeR1o5LuqwWxt07CA4ly4&language=ar&sensor=false">
    </script>
@endsection

@section('js')
    <script src="assets/js/newsMap/newsMap.js"></script>
@endsection
@section('content')
    @include('site.home.parts.hero'.($siteSetting['active_theme'][0]??1))
    <div class="left relative" id="mvp-home-widget-wrap">
        @include('site.home.parts.reports')
        @include('site.home.parts.media')
        @include('site.home.parts.statements')
        {{--  @include('site.home.parts.get_involved')--}}
        {{-- @include('site.home.parts.resources')--}}
        @include('site.home.parts.videos')
    </div>
    {{--@include('site.home.parts.more_news')--}}
    @include('site.home.parts.newsmap')
@endsection
