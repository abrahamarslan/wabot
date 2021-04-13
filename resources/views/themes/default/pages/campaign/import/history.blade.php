@extends('themes.default._layouts.default')
@section('title', 'List Campaigns')
@section('custom_style')

@stop
@section('content')

    <div class="content-page" style="height: 100vh;">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="conversation-list-card card">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <h5 class="mt-0 mb-1 text-truncate">{!! $record->name !!}</h5>
                                        <p class="font-13 text-muted mb-0">History</p>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop font-20" data-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <a href="{!! route('campaign.contact.deleteHistory', $record->id) !!}" class="dropdown-item">Delete History</a>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-3">

                                <div>
                                    <ul class="conversation-list history" style="max-height: 100%;">
                                        <li>
                                            <div class="message-list">
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <span class="user-name">{!! env('APP_NAME') !!}</span>
                                                        <p>
                                                            Hello!
                                                        </p>
                                                    </div>
                                                    <span class="time">10:00</span>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="odd">
                                            <div class="message-list">
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <span class="user-name">User</span>
                                                        <p>
                                                            Hi, How are you? What about our next meeting?
                                                        </p>
                                                    </div>
                                                    <span class="time">10:01</span>
                                                </div>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="message-list">
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <span class="user-name">{!! env('APP_NAME') !!}</span>
                                                        <p>
                                                            Yeah everything is fine
                                                        </p>
                                                    </div>
                                                    <span class="time">10:03</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message-list">
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <span class="user-name">{!! env('APP_NAME') !!}</span>
                                                        <p>
                                                            & Next meeting tomorrow 10.00AM
                                                        </p>
                                                    </div>
                                                    <span class="time">10:03</span>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="odd">
                                            <div class="message-list">
                                                <div class="conversation-text">
                                                    <div class="ctext-wrap">
                                                        <span class="user-name">User</span>
                                                        <p>
                                                            Wow that's great
                                                        </p>
                                                    </div>
                                                    <span class="time">10:04</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- container-fluid -->
        </div> <!-- content -->
        @include('themes.default._partials.footer')
    </div>

@stop
@section('custom_script')
<script type="text/javascript">
    $(document).ready(function() {
        $('.history').slimScroll({
            height: 'auto',
            position: 'right',
            size: "8px",
            touchScrollStep: 20,
            color: '#9ea5ab'
        });
    });
</script>
@stop


