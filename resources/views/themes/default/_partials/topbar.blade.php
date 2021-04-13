<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="{!! asset('uploads/user') . '/' . $user->image !!}" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                                {!! $user->username !!} <i class="mdi mdi-chevron-down"></i>
                            </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Settings</h6>
                </div>
                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{!! route('authentication.login.getLogout') !!}" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="#" class="logo logo-dark text-center">
                        <span class="logo-lg">
                            <img src="{!! asset('logo.png') !!}" alt="" height="16">
                        </span>
            <span class="logo-sm">
                            <img src="{!! asset('logo-sm.png') !!}" alt="" height="24">
                        </span>
        </a>
        <a href="#" class="logo logo-light text-center">
                        <span class="logo-lg">
                            <img src="{!! asset('logo.png') !!}" alt="" height="16">
                        </span>
            <span class="logo-sm">
                            <img src="{!! asset('logo-sm.png') !!}" alt="" height="24">
                        </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li>
            <h4 class="page-title-main">{!! env('APP_NAME') !!}</h4>
        </li>

    </ul>

</div>
<!-- end Topbar -->
