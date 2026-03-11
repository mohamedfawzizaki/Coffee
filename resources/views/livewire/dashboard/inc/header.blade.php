<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ $setting->logo }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ $setting->logo }}" alt="" height="17">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ $setting->logo }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ $setting->logo }}" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>


            </div>

            <div class="d-flex align-items-center">



                <div class="dropdown ms-1 topbar-head-dropdown header-item">

                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img id="header-lang-img" src="{{ asset('images/flags/' . LaravelLocalization::getCurrentLocale() . '.svg') }}" alt="Header Language" height="20" class="rounded">
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">

                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)


                            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                                <img src="{{ asset('images/flags/' . $localeCode . '.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                                <span class="align-middle"> {{ $properties['native'] }}</span>
                            </a>

                       @endforeach

                    </div>

                </div>



                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>



                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">

                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>

                        @if (Auth::guard('admin')->user()->unreadNotifications()->count() > 0)
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                                {{ Auth::guard('admin')->user()->unreadNotifications()->count() }}

                                <span class="visually-hidden">@lang('unread messages')</span></span>
                                @endif
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> @lang('Notifications') </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"> {{ Auth::guard('admin')->user()->unreadNotifications()->count() }} @lang('New')</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">

                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">

                                <div data-simplebar style="max-height: 300px;" class="pe-2">

                                    @foreach (Auth::guard('admin')->user()->notifications as $index => $notification)


                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author Graphic
                                                        Optimization <span class="text-secondary">reward</span> is
                                                        ready!
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-15">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="all-notification-check01">
                                                    <label class="form-check-label" for="all-notification-check01"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach


                                    @if (Auth::guard('admin')->user()->notifications->count() > 0)
                                    <div class="my-3 text-center view-all">
                                        <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                           @lang('View All Notifications') <i class="ri-arrow-right-line align-middle"></i></button>
                                    </div>
                                    @endif
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{ Auth::guard('admin')->user()->image }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text">{{ Auth::guard('admin')->user()->name }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <h6 class="dropdown-header">@lang('Welcome ' ) {{ Auth::guard('admin')->user()->name }}</h6>

                        <a class="dropdown-item" href="{{ route('dashboard.profile.index') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">@lang('Profile')</span></a>

                        <a class="dropdown-item" href="{{ route('dashboard.setting.index') }}"><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">@lang('Settings')</span></a>

                        <div class="dropdown-divider"></div>
                        {{--  <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">@lang('Balance') : <b>$5971.67</b></span></a>  --}}

                        <a class="dropdown-item" href="{{ route('dashboard.logout') }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">@lang('Logout')</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
