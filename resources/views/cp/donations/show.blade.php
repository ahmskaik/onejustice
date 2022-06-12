@extends('cp.layout.layout')

@section('css')
    <style type="text/css">
        .order-details__portlet {
            border: 1px solid #ebedf2;
        }

        .order-details__portlet .kt-portlet__head {
            background: #ebedf2;
            min-height: 40px;
        }

        .order-details__portlet .kt-portlet__body {
            padding: 10px 25px 0 25px;
        }

        .order-details__portlet .kt-widget4 .kt-widget4__item {
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
        }


        @media (min-width: 1024px) {
            .history-modal {
                max-width: 800px;
            }
        }

        @media (min-width: 1399px) {
            .history-modal {
                max-width: 1140px;
            }
        }

        @media (min-width: 1400px) {
            .history-modal {
                max-width: 1000px;
            }
        }

        .order-items__list .kt-widget__img {
            max-width: 7rem;
        }
    </style>
@endsection

@section('js')

@endsection

@section('content')
    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <span class="kt-portlet__head-icon">
                        <i class="kt-font-brand flaticon2-list"></i>
                    </span>
                    <h3 class="kt-portlet__head-title">
                        Donation Details
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-portlet kt-portlet--height-fluid order-details__portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        Details
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="kt-widget4">
                                    <div class="kt-widget4__item">
                                            <span class="kt-widget4__icon">
                                                <i class="flaticon2-envelope kt-font-info"></i>
                                            </span>
                                        <div class="kt-widget4__info">
                                                    <span
                                                        class="kt-widget4__title kt-widget4__title--light kt-font-bold">
                                                        Email
                                                    </span>
                                            <div
                                                class="kt-widget4__text">{{$donation->email}}</div>
                                        </div>
                                    </div>
                                    <div class="kt-widget4__item">
                                            <span class="kt-widget4__icon">
                                                <i class="fa fa-money-bill kt-font-info"></i>
                                            </span>
                                        <div class="kt-widget4__info">
                                        <span class="kt-widget4__title kt-widget4__title--light kt-font-bold">
                                            Amount
                                        </span>
                                            <div class="kt-widget4__text">
                                                {{$donation->amount.' '.$donation->currency}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-widget4__item">
                                                <span class="kt-widget4__icon">
                                                    <i class="flaticon2-calendar-1 kt-font-info"></i>
                                                </span>
                                        <div class="kt-widget4__info">
                                            <span class="kt-widget4__title kt-widget4__title--light kt-font-bold">
                                                Donation Date
                                            </span>
                                            <div class="kt-widget4__text">{{$donation->created_at}}</div>
                                        </div>
                                    </div>
                                    <div class="kt-widget4__item">
                                            <span class="kt-widget4__icon">
                                                <i class="fa fa-credit-card kt-font-info"></i>
                                            </span>
                                        <div class="kt-widget4__info">
                                        <span class="kt-widget4__title kt-widget4__title--light kt-font-bold">
                                            Gateway/Brand
                                        </span>
                                            <div class="kt-widget4__text kt-font-bold">
                                                {{$donation->gateway.'/'.$donation->brand }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-portlet kt-portlet--height-fluid order-details__portlet">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">
                                        Details
                                    </h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="kt-widget4">
                                    <div class="kt-widget4__item">
                                                <span class="kt-widget4__icon">
                                                    <i class="flaticon2-tools-and-utensils kt-font-info"></i>
                                                </span>
                                        <div class="kt-widget4__info">
                                            <span class="kt-widget4__title kt-widget4__title--light kt-font-bold">
                                                Token
                                            </span>
                                            <div class="kt-widget4__text">{{$donation->token}}</div>
                                        </div>
                                    </div>
                                    <div class="kt-widget4__item">
                                            <span class="kt-widget4__icon">
                                                <i class="flaticon2-cardiogram kt-font-info"></i>
                                            </span>
                                        <div class="kt-widget4__info">
                                                    <span
                                                        class="kt-widget4__title kt-widget4__title--light kt-font-bold">
                                                        Card last4
                                                    </span>
                                            <div class="kt-widget4__text">
                                                {{$donation->last4}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-widget4__item">
                                            <span class="kt-widget4__icon">
                                                <i class="flaticon2-crisp-icons kt-font-info"></i>
                                                </span>
                                        <div class="kt-widget4__info">
                                                    <span
                                                        class="kt-widget4__title kt-widget4__title--light kt-font-bold">
                                                        IP
                                                    </span>
                                            <div class="kt-widget4__text">
                                                {{$donation->ip}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-widget4__item">
                                            <span class="kt-widget4__icon">
                                                <i class="flaticon2-location kt-font-info"></i>
                                                </span>
                                        <div class="kt-widget4__info">
                                            <span class="kt-widget4__title kt-widget4__title--light kt-font-bold">
                                                Address
                                            </span>
                                            <div class="kt-widget4__text">
                                                {{$donation->payload->address_country ??'--'}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="kt-portlet kt-portlet--mobile kt-hidden">
            <div class="kt-portlet__body">
                <div class="row">
                    <div class="col-md-12">
                        <pre>
                            {{print_r($donation->toArray())}}
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
