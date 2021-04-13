@extends('themes.default._layouts.default')
@if($create)
    @section('title', 'Import Data')
@else
    @section('title', 'Update Data')
@endif
@section('custom_style')
    <link href="{!! asset('themes/default/libs/dropify/dropify.min.css') !!}" rel="stylesheet">
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
                                <h4 class="header-title">Upload File | Campaign: {!! $record->title !!}</h4>
                                <p class="sub-header">
                                    Upload a file of contacts to the campaign.<br/>
                                    <code>Sample File:</code> <a href="{!! asset(\Config::get('global.contacts.upload_folder_path') .  'default.xlsx') !!}">Click here to download</a><br/>
                                    <code>Maximum Size:</code> 2 MBs<br/>
                                </p>
                            @else
                                <h4 class="header-title">Update Record</h4>
                                <p class="sub-header">
                                    Update record
                                </p>
                            @endif

                            <div class="row">
                                <div class="col-12">

                                        @if($create)
                                            {!! Form::open(['route' => ['campaign.contact.postImport', $record->id], 'method' => 'POST', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                                        @else
                                            {{Form::model($record, array('url' => URL::route('campaign.postUpdate', $record->id), 'files' => true,'id' => 'form', 'class' => 'form-horizontal form-bordered form-row-stripped'))}}
                                        @endif
                                        {!! Form::token() !!}

                                        <input name="file" type="file" class="dropify" data-height="300" data-max-file-size="2M" />
                                        <br/>
                                        <br/>
                                        <div class="form-group row pl-2">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>

                                        {!! Form::close() !!}

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
    <!-- dropify js -->
    <script src="{!! asset('themes/default/libs/dropify/dropify.min.js') !!}"></script>
    <!-- form-upload init -->
    <script src="{!! asset('themes/default/js/pages/form-fileupload.init.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

        });
    </script>
@stop


