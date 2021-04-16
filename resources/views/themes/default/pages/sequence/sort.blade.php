@extends('themes.default._layouts.default')
@section('title', 'Sort Sequences')
@section('custom_style')

@stop
@section('content')

    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box table-responsive">
                            <h4 class="mt-0 header-title">Sort Sequences</h4>
                            <p class="text-muted font-14 mb-3">
                                Sort the sequence in campaign
                            </p>
                            <Sortable :campaign='@json($record)' :route='@json(route("sequence.postSort"))' :sequences='@json($sequences)'></Sortable>

                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div> <!-- content -->
        @include('themes.default._partials.footer')
    </div>

@stop
@section('custom_script')

@stop


