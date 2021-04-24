@extends('themes.default._layouts.default')
@section('title', 'Contact History')
@section('custom_style')

@stop
@section('content')

    <div class="content-page">
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
                                @if(isset($records) and !empty($records) and !is_null($records))
                                    <div>
                                        <ul class="conversation-list history" style="max-height: 100%;">
                                            @foreach($records as $row)
                                                <li @if($row->direction=='received') class="odd" @endif>
                                                    <div class="message-list">
                                                        <div class="conversation-text">
                                                            <div class="ctext-wrap">
                                                                <span class="user-name">{!! GeneralHelper::getSetting('APP_NAME') !!}</span>
                                                                <p>
                                                                    {!! $row->body !!}
                                                                </p>
                                                            </div>
                                                            <span class="time">{!! \Carbon\Carbon::parse($row->created_at)->diffForHumans() !!}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div>
                                        <ul class="conversation-list history text-center" style="max-height: 100%;">
                                            <h3>No conversation history with this contact.</h3>
                                        </ul>
                                    </div>
                                @endif
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


