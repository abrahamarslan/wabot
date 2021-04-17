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
                                                                <select id="sequence_id_{!! $row->id !!}" data-id="{!! $row->id !!}" class="form-control sequence">
                                                                    @foreach($sequences->except($row->id) as $k => $v)
                                                                        <option value="{!! $k !!}" class="sequence-option" data-parent="{!! $row->id !!}" data-sequence="{!! $k !!}" data-id="{!! $k !!}">{!! $v !!}</option>
                                                                    @endforeach
                                                                </select>
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
                                                            <select id="if_option_id_{!! $row->id !!}" data-id="{!! $row->id !!}" class="form-control options" disabled>

                                                            </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-2 col-form-label" for="example-helping"><strong> Else </strong></label>
                                                            <div class="col-md-10">
                                                                <select id="else_sequence_id_{!! $row->id !!}" data-id="{!! $row->id !!}" class="form-control sequence-else" disabled>
                                                                    @foreach($sequences->except($row->id) as $k => $v)
                                                                        <option value="{!! $k !!}" class="sequence-else-option" data-parent="{!! $row->id !!}" data-sequence="{!! $k !!}" data-id="{!! $k !!}">{!! $v !!}</option>
                                                                    @endforeach
                                                                </select>
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
        const url = '{!! route('sequence.postConditionalOptions') !!}';
        function populateIfOptions(data, parentID){
            //console.log(data);
            //const optionID = $(this).find("option:selected").attr("data-id");
            //Populate the Options box
            //<option value="{!! $k !!}" class="sequence-option" data-parent="{!! $row->id !!}" data-sequence="{!! $k !!}" data-id="{!! $k !!}">{!! $v !!}</option>

            if(data.data) {
                var hasOptions = false;
                const ifSelect = $('#if_option_id_' + parentID);
                $.each(data.data, function(key, val) {
                    if(val !== '') {
                        hasOptions = true;
                        console.log('val', val)
                        //optionsValues += '<option value="' + item.key + '">' + item.value + '</option>';
                        ifSelect.append($("<option />").val(val["key"]).text(val["value"]));
                    } else {
                        hasOptions = false;
                    }
                });
                if(hasOptions) {
                    ifSelect.attr('disabled', false);
                    const elseSelect = $('#else_sequence_id_' + parentID);
                    elseSelect.empty().attr("disabled", true);
                }
            }
        }
        function changeSequence(sequenceID, parentID) {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    sequenceID
                },
                error: function() {
                    alert('Some error occurred!');
                    //$('#info').html('<p>An error has occurred</p>');
                },
                //dataType: 'jsonp',
                success: function(data) {
                    populateIfOptions(data, parentID);
                }
            });
        }
        $(document).ready(function() {
            $('.sequence').on('change', function (e) {
                const selectedSequence = $(this).find(":selected");
                const parentID = selectedSequence.attr('data-parent');
                const sequenceID = selectedSequence.attr('data-sequence');
                console.log('sequence', sequenceID);
                if(sequenceID === '-1') {
                    const ifSelect = $('#if_option_id_' + parentID);
                    const elseSelect = $('#else_sequence_id_' + parentID);
                    ifSelect.empty().attr("disabled", true);
                    elseSelect.empty().attr("disabled", true);
                } else {
                    changeSequence(sequenceID, parentID);
                }
            });

            $('.sequence-option').on('change', function (e) {
                const parentID = $(this).attr("data-parent");
                const sequenceID = $(this).attr("data-sequence");
                console.log('here');
            });
        });


    </script>
@stop


