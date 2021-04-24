@extends('themes.default._layouts.default')
@section('title', 'Dashboard')
@section('custom_style')

@stop
@section('content')
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="font-weight-normal text-primary">{!! $sent_today !!}</h2>
                                <h5>Sent today</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="font-weight-normal text-pink">{!! $received_today !!}</h2>
                                <h5>Received today</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="font-weight-normal text-warning">{!! $campaigns !!}</h2>
                                <h5>Campaigns</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box widget-user">
                            <div class="text-center">
                                <h2 class="font-weight-normal text-info">{!! $users !!}</h2>
                                <h5>Users</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
       @include('themes.default._partials.footer')
    </div>
@stop
@section('custom_script')
    <!-- knob plugin -->
    <script src="{!! asset('themes/default/libs/jquery-knob/jquery.knob.min.js') !!}"></script>
    <!--Morris Chart-->
    <script src="{!! asset('themes/default/libs/morris-js/morris.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/raphael/raphael.min.js') !!}"></script>
    <!-- Dashboard init js-->
    <script src="{!! asset('themes/default/js/pages/dashboard.init.js') !!}"></script>
@stop


