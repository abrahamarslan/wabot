@extends('themes.default._layouts.default')
@if($create)
    @section('title', 'Create Conditions')
@else
    @section('title', 'Update Conditions')
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
                        </div> <!-- end card-box -->
                    </div><!-- end col -->
                </div>
                @if(!empty($records))
                    <?php $i = 1; ?>
                    @foreach($records as $row)
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="p-2">
                                                @if($create)
                                                    {!! Form::open(['route' => 'sequence.create', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                                                @else
                                                    {{Form::model($record, array('url' => URL::route('sequence.postUpdate', $record->id), 'files' => true,'id' => 'form', 'class' => 'form-horizontal form-bordered form-row-stripped'))}}
                                                @endif
                                                {!! Form::token() !!}
                                                <div class="condition">
                                                    <div class="form-group row flex align-items-center">
                                                        <label class="col-md-2 col-form-label" for="example-helping">Sequence</label>
                                                        <div class="col-md-10">
                                                            {!! $row->title !!}
                                                        </div>
                                                    </div>
                                                    @if($i !== 1)
                                                        <div class="form-group row">
                                                            <label class="col-md-2 col-form-label" for="example-helping"><strong> If </strong></label>
                                                            <div class="col-md-10">
                                                                {{Form::select('sequence_id',$sequences->except($row->id),null, array('id' => 'sequence_id_' . $row->id, 'class' => 'form-control sequence', 'data-id' => $row->id))}}
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $options = $row->options;
                                                        if(!empty($options) && !is_null($options))
                                                        {

                                                        }
                                                        ?>
                                                        <div class="form-group row">
                                                            <label class="col-md-2 col-form-label" for="example-helping"><strong> Is </strong></label>
                                                            <div class="col-md-10">
                                                                {{Form::select('sequence_answer',$row->options,null, array('id' => 'record-campaigns', 'class' => 'form-control'))}}
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-2 col-form-label" for="example-helping"><strong> Else </strong></label>
                                                            <div class="col-md-10">
                                                                {{Form::select('campaign_id',$sequences,null, array('id' => 'record-campaigns', 'class' => 'form-control'))}}
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                                <br/>
                                                <br/>
                                                @if($i !== 1)
                                                <div class="form-group row text-center ml-1">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                                @endif
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                        <?php $i++; ?>
                    @endforeach
                @endif
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
        function changeSequence(sequenceID) {

        }
        $(document).ready(function() {
            var currentSelected = $('.sequence').find(':selected').text();
            alert(currentSelected);
            $('.sequence').on('change', function (e) {
                const sequenceID = $(this).data("id");
                alert(sequenceID);
            });
        });


    </script>
@stop


