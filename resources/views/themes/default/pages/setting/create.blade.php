@extends('themes.default._layouts.default')
@if($create)
    @section('title', 'Create Record')
@else
    @section('title', 'Update Record')
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
                                <h4 class="header-title">New Record</h4>
                                <p class="sub-header">
                                    Create a new record
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
                                        @if($create)
                                            {!! Form::open(['route' => 'setting.store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                                        @else
                                            {{Form::model($record, array('url' => URL::route('setting.postUpdate', $record->id), 'files' => true,'id' => 'form', 'class' => 'form-horizontal form-bordered form-row-stripped'))}}
                                        @endif
                                        {!! Form::token() !!}

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Setting Key</label>
                                            <div class="col-md-10">
                                                {!! Form::text('setting_key', null, ['class' => 'form-control', 'id' => 'record-title', 'autocomplete' => 'on', 'placeholder' => 'Setting Key'] ) !!}
                                                <span class="help-block"><small>Setting key title</small></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Setting Value</label>
                                            <div class="col-md-10">
                                                {!! Form::text('setting_value', null, ['class' => 'form-control', 'id' => 'record-title', 'autocomplete' => 'on', 'placeholder' => 'Setting Value'] ) !!}
                                                <span class="help-block"><small>Setting value</small></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Options</label>
                                            <div class="col-md-10">
                                                {{Form::select('setting_type',array('Text'=>'Text','Number' => 'Number','Currency' => 'Currency','Binary' => 'Binary','JSON'=>'JSON'),null, array('id' => 'record-status', 'class' => 'form-control'))}}
                                                <span class="help-block"><small>Options</small></span>
                                            </div>
                                        </div>
                                        <div class="form-group ml-1 row">
                                            <button type="submit" class="btn btn-primary">Save</button>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#example-date").datepicker({
                format:'yyyy-mm-dd',
                autoclose: !0,
                todayHighlight:!0
            });
        });
    </script>
@stop


