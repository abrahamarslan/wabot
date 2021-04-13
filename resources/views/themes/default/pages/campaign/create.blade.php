@extends('themes.default._layouts.default')
@if($create)
    @section('title', 'Create Campaign')
@else
    @section('title', 'Update Campaign')
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
                                            {!! Form::open(['route' => 'campaign.create', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                                        @else
                                            {{Form::model($record, array('url' => URL::route('campaign.postUpdate', $record->id), 'files' => true,'id' => 'form', 'class' => 'form-horizontal form-bordered form-row-stripped'))}}
                                        @endif
                                        {!! Form::token() !!}

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label" for="example-helping">Title</label>
                                                <div class="col-md-10">
                                                    {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'record-title', 'autocomplete' => 'on', 'placeholder' => 'Title'] ) !!}
                                                    <span class="help-block"><small>Name your campaign</small></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label" for="example-helping">Status</label>
                                                <div class="col-md-10">
                                                    {{Form::select('status',array('Active'=>'Active','Inactive'=>'Inactive'),null, array('id' => 'record-status', 'class' => 'form-control'))}}
                                                    <span class="help-block"><small>Status of the campaign</small></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label" for="example-helping">Is Completed</label>
                                                <div class="col-md-10">
                                                    {{Form::select('isCompleted',array('Yes'=>'Yes','No'=>'No'),null, array('id' => 'record-isCompleted', 'class' => 'form-control'))}}
                                                    <span class="help-block"><small>Has the campaign completed?</small></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label" for="example-helping">Start at</label>
                                                <div class="col-md-10">
                                                    {!! Form::text('start_at', null, ['class' => 'form-control', 'id' => 'example-date', 'type' => 'date', 'autocomplete' => 'on'] ) !!}
                                                    <span class="help-block"><small>Campaign date</small></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label" for="example-helping">Interval</label>
                                                <div class="col-md-10">
                                                    {{Form::selectRange('interval',1,30,null, array('id' => 'record-isCompleted', 'class' => 'form-control'))}}
                                                    <span class="help-block"><small>Message interval (In minutes)</small></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-2 col-form-label" for="example-helping">Description</label>
                                                <div class="col-md-10">
                                                    {!! Form::textarea('body', null, ['class' => 'form-control', 'id' => 'record-body', 'autocomplete' => 'on'] ) !!}
                                                    <span class="help-block"><small>Describe your campaign</small></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
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


