<head>
    <meta charset="utf-8" />
    <title>@yield('title') | {!! env('APP_NAME') !!}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{!! env('APP_DESCRIPTION') !!}" name="description" />
    <meta content="{!! env('APP_DEVELOPER') !!}" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{!! asset('themes/default/images/favicon.ico') !!}">
    @include('themes.default._partials.styles')
</head>
