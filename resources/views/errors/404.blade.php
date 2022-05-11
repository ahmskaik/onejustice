@extends('site.layout.layout')
@section('css')
    <style>

    </style>
@endsection

@section('content')
    <div class="mvp-main-box">
        <section id="mvp-404">
            <h1>404!</h1>
            <p>{{trans('site.errors.404')}}</p>
            <br>
            <br>
            <a href="{{route('site.home')}}" class="fcf-btn fcf-btn-primary fcf-btn-lg fcf-btn-block">{{trans('site.back_to_home')}}</a>
        </section>
    </div>
@endsection
