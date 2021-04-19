<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{!! asset('uploads/user/') . $user->image !!}" alt="user-img" title="{!! $user->username !!}" class="rounded-circle img-thumbnail avatar-md">
            <div class="dropdown">
                <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown"  aria-expanded="false">{!! $user->username !!}</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="{!! route('authentication.login.getLogout') !!}" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="{!! route('dashboard.index') !!}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);">
                        <i class="mdi mdi-page-layout-sidebar-left"></i>
                        <span> Campaigns </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{!! route('campaign.index') !!}">List</a></li>
                        <li><a href="{!! route('campaign.create') !!}">Create</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);">
                        <i class="mdi mdi-texture"></i>
                        <span class="badge badge-warning float-right">7</span>
                        <span> Sequence </span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{!! route('sequence.create') !!}">Create</a></li>
                    </ul>
                </li>

{{--                <li>--}}
{{--                    <a href="#">--}}
{{--                        <i class="mdi mdi-file"></i>--}}
{{--                        <span> Export </span>--}}
{{--                    </a>--}}
{{--                </li>--}}

{{--                <li>--}}
{{--                    <a href="#">--}}
{{--                        <i class="mdi mdi-cog"></i>--}}
{{--                        <span class="badge badge-purple float-right">New</span>--}}
{{--                        <span> Settings </span>--}}
{{--                    </a>--}}
{{--                </li>--}}

            </ul>

        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->
