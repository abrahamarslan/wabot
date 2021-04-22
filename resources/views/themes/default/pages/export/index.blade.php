@extends('themes.default._layouts.default')
@if($create)
    @section('title', 'Export Campaign')
@else
    @section('title', 'Export Campaign')
@endif
@section('custom_style')
    <link href="{!! asset('themes/default/libs/bootstrap-datepicker/bootstrap-datepicker.css') !!}" rel="stylesheet">
@stop
@section('content')

    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            @if($create)
                                <h4 class="header-title">Export Campaign</h4>
                                <p class="sub-header">
                                    Export data
                                </p>
                            @else
                                <h4 class="header-title">Update Record</h4>
                                <p class="sub-header">
                                    Update record
                                </p>
                            @endif

                            <div class="row">
                                <div class="col-12">
                                    <div class="p-2">
                                        {!! Form::open(['route' => 'export.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                                        {!! Form::token() !!}
                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Campaign</label>
                                            <div class="col-md-10">
                                                {{Form::select('campaign_id',$campaigns,null, array('id' => 'record-campaigns', 'class' => 'form-control'))}}
                                                <span class="help-block"><small>Select the campaign you want to export</small></span>
                                            </div>
                                        </div>
                                        <div class="form-group ml-1 row">
                                            <button type="submit" class="btn btn-success">Export</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div> <!-- end card-box -->
                    </div><!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- container-fluid -->
        </div> <!-- content -->
        @include('themes.default._partials.footer')
    </div>

@stop
@section('custom_script')
    <script src="{!! asset('themes/default/libs/moment/moment.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') !!}"></script>

    </script>
@stop


