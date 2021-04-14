@extends('themes.default._layouts.default')
@if($create)
    @section('title', 'Create Sequence')
@else
    @section('title', 'Update Sequence')
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
                                            {!! Form::open(['route' => 'sequence.create', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                                        @else
                                            {{Form::model($record, array('url' => URL::route('sequence.postUpdate', $record->id), 'files' => true,'id' => 'form', 'class' => 'form-horizontal form-bordered form-row-stripped'))}}
                                        @endif
                                        {!! Form::token() !!}

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Title</label>
                                            <div class="col-md-10">
                                                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'record-title', 'autocomplete' => 'on', 'placeholder' => 'Title'] ) !!}
                                                <span class="help-block"><small>Sequence Title</small></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Campaign</label>
                                            <div class="col-md-10">
                                                {{Form::select('campaign_id',$campaigns,null, array('id' => 'record-campaigns', 'class' => 'form-control'))}}
                                                <span class="help-block"><small>Status of the sequence</small></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Status</label>
                                            <div class="col-md-10">
                                                {{Form::select('status',array('1'=>'Active','0'=>'Inactive'),null, array('id' => 'record-status', 'class' => 'form-control'))}}
                                                <span class="help-block"><small>Status of the sequence</small></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Order</label>
                                            <div class="col-md-10">
                                                {{Form::number('order',null, array('id' => 'record-order', 'class' => 'form-control'))}}
                                                <span class="help-block"><small>Sequence Order</small></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-2 col-form-label" for="example-helping">Description</label>
                                            <div class="col-md-10">
                                                {!! Form::textarea('body', null, ['class' => 'form-control', 'id' => 'record-body', 'autocomplete' => 'on'] ) !!}
                                                <span class="help-block"><small>Sequence Body</small></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                {!! Form::checkbox('hasOptions', '1', null, ['class' => 'pt-1', 'id' => 'hasOptions']); !!}
                                                <label>Has Options?</label>
                                            </div>
                                        </div>

                                        <div class="form-group row" id="requirement_repeater">
                                            <label class="col-md-2 col-form-label" for="example-helping">
                                                Options
                                                <br/>
                                                <div data-repeater-create class="btn btn-success waves-effect waves-light"> <i class="fa fa-plus"></i></div>
                                            </label>
                                            <div class="col-md-10">
                                                <div data-repeater-list="options">
                                                    <div data-repeater-item class="mb-2">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="options" placeholder="Enter Option"/>
                                                            <div class="input-group-append">
                                                                <a href="javascript:;" data-repeater-delete="" class="btn font-weight-bold btn-danger btn-icon">
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <br/>
                                        <div class="form-group row ml-1">
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
    <script src="{!! asset('themes/default/libs/jquery.repeater.js') !!}"></script>
    <script type="text/javascript">

        $(document).on("change", "#hasOptions", function () {
            if($(this).is(':checked')){
                $('#requirement_repeater').slideDown();
            } else {
                $('#requirement_repeater').slideUp();
            }
        });

        $(document).ready(function() {
            if($('#hasOptions').is(':checked')){
                $('#requirement_repeater').slideDown();
            } else {
                $('#requirement_repeater').hide();
            }

                $("#example-date").datepicker({
                format:'yyyy-mm-dd',
                autoclose: !0,
                todayHighlight:!0
            });
            /**
             * Initialize Repeater
             */
            var $requirements = $('#requirement_repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'text-input': 'Enter Option'
                },
                show: function () {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if(confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: true
            });

            /**
             Initialize templates of repeaters if edit
             */
            @if(isset($record) and count($record->options) > 0)
            $requirements.setList(@json($record->options))
            @endif
        });
    </script>
@stop


