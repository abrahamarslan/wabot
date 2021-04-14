@extends('themes.default._layouts.default')
@section('title', 'List Sequences')
@section('custom_style')
    <style type="text/css">
        .green-bg {
            background: rgba(76, 175, 80, 0.2) /* Green background with 30% opacity */
        }
    </style>
    <!-- third party css -->
    <link href="{!! asset('themes/default/libs/datatables/dataTables.bootstrap4.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('themes/default/libs/datatables/responsive.bootstrap4.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('themes/default/libs/datatables/buttons.bootstrap4.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('themes/default/libs/datatables/select.bootstrap4.css') !!}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->
@stop
@section('content')

    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box table-responsive">
                            <h4 class="mt-0 header-title">List of Records</h4>
                            <p class="text-muted font-14 mb-3">
                                List of all sequence records
                            </p>

                            <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(count($records) > 0)
                                    @foreach($records as $record)
                                        <tr>
                                            <td>{!! $record->title !!}</td>
                                            <td>{!! $record->order !!}</td>
                                            <td>{!! ($record->status == 0 ? 'Inactive' : 'Active') !!}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-dots-vertical"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <!-- item-->
                                                        <a href="{!! route('sequence.update', $record->id) !!}" class="dropdown-item">Edit</a>
                                                        <!-- item-->
                                                        <a href="{!! route('sequence.delete', $record->id) !!}" class="dropdown-item">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center"><b>No records found</b></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div> <!-- content -->
        @include('themes.default._partials.footer')
    </div>

@stop
@section('custom_script')
    <!-- third party js -->
    <script src="{!! asset('themes/default/libs/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/dataTables.bootstrap4.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/responsive.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/dataTables.buttons.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/buttons.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/buttons.html5.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/buttons.flash.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/buttons.print.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/dataTables.keyTable.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/datatables/dataTables.select.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/pdfmake/pdfmake.min.js') !!}"></script>
    <script src="{!! asset('themes/default/libs/pdfmake/vfs_fonts.js') !!}"></script>
    <!-- third party js ends -->

    <!-- Datatables init -->
    <script src="{!! asset('themes/default/js/pages/datatables.init.js') !!}"></script>
@stop


