<!DOCTYPE html>
<html lang="en">
@include('themes.default._partials.header')
<body class="enlarged" data-layout-size="boxed" data-keep-enlarged="true">
@include('themes.default._partials.loader')
<!-- Begin page -->
<div id="wrapper">
    @include('themes.default._partials.topbar')
    @include('themes.default._partials.sidebar')
    @yield('content')
</div>
<!-- END wrapper -->
@include('themes.default._partials.scripts')
</body>
</html>