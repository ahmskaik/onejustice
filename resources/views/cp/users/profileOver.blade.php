@extends('cp.layout.layout')

@section('css')
@stop

@section('js')
    @if($errors->has(''))
        <script>
            jQuery(document).ready(function () {
                toasterMessage('error', 'The Number of Errors: {{ sizeof($errors->all()) }}', 'Check Errors Below');
            });

        </script>
    @endif

    @if(isset($success))
        <script>
            jQuery(document).ready(function () {
                toasterMessage('success', '{{ $success }}', 'Success Message');
            });

        </script>
    @endif
@stop

@section('content')
    <div class="kt-container  kt-grid__item kt-grid__item--fluid">
        <div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">
            @include("cp.users.profilePart")
            <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="kt-portlet kt-portlet--height-fluid">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-label">
                                    <h3 class="kt-portlet__head-title">Profile Account</h3>
                                </div>
                            </div>
                            <div class="kt-portlet__body">
                                <div class="info-datarow">
                                    <div class="info-datacell">
                                        <span>Full Name</span>
                                        <p>{{ ucfirst($user->full_name) }}</p>
                                    </div>

                                </div>
                                <div class="info-datarow">
                                    <div class="info-datacell">
                                        <span>Username</span>
                                        <p>{{ $user->user_name }}</p>
                                    </div>
                                    <div class="info-datacell">
                                        <span>Date of birth</span>
                                        <p>{{ $user->dob }}</p>
                                    </div>
                                </div>
                                <div class="info-datarow">
                                    <div class="info-datacell">
                                        <span>Email</span>
                                        <p>{{ $user->email }}</p>
                                    </div>
                                    <div class="info-datacell">
                                        <span>Mobile</span>
                                        <p>{{ $user->mobile }}</p>
                                    </div>
                                </div>
                                <div class="info-datarow">
                                    <div class="info-datacell">
                                        <span>Role Name</span>
                                        <p>{{ $user->roles && isset($user->roles[0])?$user->roles[0]->name:"-----" }}</p>
                                    </div>
                                    <div class="info-datacell">
                                        <span>Custom Role</span>
                                        <p>{{ ($user->is_customized)?"Yes":"No" }}</p>
                                    </div>
                                </div>
                                <div class="info-datarow">
                                    <div class="info-datacell">
                                        <span>Status</span>
                                        <p>Active</p>
                                    </div>
                                    <div class="info-datacell">
                                        <span>Creator Name</span>
                                        <p>{{ $user->user_name }}</p>
                                    </div>
                                </div>
                                <div class="info-datarow">
                                    <div class="info-datacell">
                                        <span>Last Login</span>
                                        <p>{{ $lastLogin }}</p>
                                    </div>
                                    <div class="info-datacell">
                                        <span>Last IP</span>
                                        <p>{{ $lastIP }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
