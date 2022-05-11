@extends('site.layout.layout')
@section('css')
    <style>
        .table {
            color: #212529;
            background-color: transparent;
            clear: both;
            border-top: none;
            width: 100% !important;
            border-collapse: initial !important;
            border-spacing: 0 !important;
            margin: 0 !important;
        }

        .table tbody tr td {
            font-size: 17px;
            border-bottom: dashed 1px #cde6fc;
        }

        .table tbody tr td:nth-child(2) {
            font-size: {{$locale==='ar'?'17':'14'}}px !important;

        }

        .table-bordered {
            border: 1px solid #ebedf2;
        }

        table.table-bordered.dataTable tbody td {
            border-bottom-width: 0;
            border-{{$locale==='ar'?'left':'right'}}-width: 0;
            color: #595d6e;
            vertical-align: middle;
        }

        .table-bordered th, .table-bordered td {
            padding: 0.55rem;
            text-align: {{$locale==='ar'?'right':'left'}};
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f7f8fa;
        }

        .table-hover tbody tr:hover {
            color: #212529;
            background-color: #fafbfc;
        }
    </style>
@endsection

@section('content')
    <div class="mvp-main-box">
        <div class="mvp-main-blog-cont left relative">
            <header id="mvp-post-head" class="left relative">
                <h1 class="mvp-post-title left entry-title" itemprop="headline">{{trans('site.newsletters')}}</h1>
            </header>
            <div class="mvp-main-blog-out left relative" style="margin-bottom: 2rem">
                <div class="mvp-main-blog-in2">
                    <div class="mvp-main-blog-body left relative">
                        <div class="newsletters-list">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('site.date')}}</th>
                                    <th>{{trans('site.title')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($newsletters as $newsletter)

                                    <tr class="newsletter-item">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$newsletter->date}}</td>
                                        <td><a target="_blank" href="{{$newsletter->link}}">{{$newsletter->title}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="left relative" id="mvp-home-widget-wrap">
        @include('site.home.parts.newsletter')

    </div>
@endsection
