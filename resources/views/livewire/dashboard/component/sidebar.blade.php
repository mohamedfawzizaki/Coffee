<div class="app-menu navbar-menu border-end">

    <div class="navbar-brand-box">

        <a href="{{ route('dashboard.') }}" class="logo logo-dark">

            <span class="logo-sm">
                <img src="{{ $setting->logo }}" alt="" height="50">
            </span>

            <span class="logo-lg">
                <img src="{{ $setting->logo }}" alt="" height="50">
            </span>

        </a>

        <a href="{{ route('dashboard.') }}" class="logo logo-light">

            <span class="logo-sm">
                <img src="{{ $setting->logo }}" alt="" height="50">
            </span>

            <span class="logo-lg">
                <img src="{{ $setting->logo }}" alt="" height="50">
            </span>

        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>

    </div>

    <div id="scrollbar">

        <div class="container-fluid">

            <div id="two-column-menu"></div>

            <ul class="navbar-nav" id="navbar-nav">

                @if ($user->id == 1 || $user->isAbleTo('dashboard-read'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $currentRoute == 'dashboard.' ? 'active' : '' }}"
                            href="{{ route('dashboard.') }}">
                            <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">@lang('Dashboard')</span>
                        </a>
                    </li>
                @endif

                <li class="menu-title"><span data-key="t-menu">@lang('Users')</span></li>


                @if ($user->isAbleTo('customer-read'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.customer.') ? 'active' : '' }}"
                            href="{{ route('dashboard.customer.index') }}">
                            <i class="ri-user-3-line"></i> <span data-key="t-authentication">@lang('Customers')</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.unregisteredcustomer.') ? 'active' : '' }}"
                            href="{{ route('dashboard.unregisteredcustomer.index') }}">
                            <i class="ri-user-3-line"></i> <span data-key="t-authentication">@lang('Unregistered customers')</span>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.point.') ? 'active' : '' }}"
                            href="{{ route('dashboard.point.index') }}">
                            <i class="ri-coins-line"></i> <span data-key="t-authentication">@lang('Points')</span>
                        </a>
                    </li>
                @endif

                @if ($user->isAbleTo('customer-read'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.branch.') ? 'active' : '' }}"
                            href="{{ route('dashboard.branch.index') }}">
                            <i class="ri-store-2-line"></i> <span data-key="t-authentication">@lang('Branches')</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.posmanager.') ? 'active' : '' }}"
                            href="{{ route('dashboard.posmanager.index') }}">
                            <i class="ri-computer-line"></i> <span data-key="t-authentication">@lang('Pos Manager')</span>
                        </a>
                    </li>
                @endif

                @php
                    $isMenuActive =
                        str_starts_with($currentRoute, 'dashboard.category.') ||
                        str_starts_with($currentRoute, 'dashboard.product.') ||
                        $currentRoute == 'dashboard.category-product';
                @endphp
                @if ($user->isAbleTo('product-read'))
                    <li class="menu-title"><span data-key="t-menu">@lang('menu')</span></li>

                    <li class="nav-item">

                        <a class="nav-link menu-link {{ $isMenuActive ? 'active' : '' }}" href="#pcategory"
                            data-bs-toggle="collapse" aria-expanded="{{ $isMenuActive ? 'true' : 'false' }}"
                            aria-controls="pcategory" onkeypress="#">
                            <i class="ri-menu-2-line"></i> <span data-key="t-apps">@lang('Menu')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ $isMenuActive ? 'show' : '' }}" id="pcategory">

                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{ route('dashboard.category.index') }}"
                                        class="nav-link {{ str_starts_with($currentRoute, 'dashboard.category.') ? 'active' : '' }}"
                                        data-key="t-calendar"> @lang('Main Categories') </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.product.') ? 'active' : '' }}"
                                        href="{{ route('dashboard.product.index') }}"> @lang('Products')
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ $currentRoute == 'dashboard.category-product' ? 'active' : '' }}"
                                        href="{{ route('dashboard.category-product') }}">
                                        @lang('Products Sorting') </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif

                @php
                    $isGiftsActive =
                        str_starts_with($currentRoute, 'dashboard.gift.') ||
                        str_starts_with($currentRoute, 'dashboard.gifttransfer.');
                    $isReportsActive = str_starts_with($currentRoute, 'dashboard.report.');
                @endphp
                @if ($user->isAbleTo('order-read'))
                    <li class="menu-title"><i class="ri-more-fill"></i> <span
                            data-key="t-pages">@lang('Finances')</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.order.') ? 'active' : '' }}"
                            href="{{ route('dashboard.order.index') }}">
                            <i class="ri-shopping-cart-2-line"></i> <span data-key="t-layouts">@lang('Orders')</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.pointorder.') ? 'active' : '' }}"
                            href="{{ route('dashboard.pointorder.index') }}">
                            <i class="ri-shopping-basket-2-line"></i> <span
                                data-key="t-layouts">@lang('Point Orders')</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.abandoned.') ? 'active' : '' }}"
                            href="{{ route('dashboard.abandoned.index') }}">
                            <i class="ri-shopping-cart-line"></i> <span data-key="t-layouts">@lang('Abandoned Carts')</span>
                        </a>
                    </li>

                    <li class="nav-item">

                        <a class="nav-link menu-link {{ $isGiftsActive ? 'active' : '' }}" href="#gifts"
                            data-bs-toggle="collapse" aria-expanded="{{ $isGiftsActive ? 'true' : 'false' }}"
                            aria-controls="gifts" onkeypress="#">
                            <i class="ri-gift-2-line"></i> <span data-key="t-apps">@lang('Gifts')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ $isGiftsActive ? 'show' : '' }}" id="gifts">

                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{ route('dashboard.gift.index') }}"
                                        class="nav-link {{ str_starts_with($currentRoute, 'dashboard.gift.') ? 'active' : '' }}"
                                        data-key="t-calendar"> @lang('Gift Orders') </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.gifttransfer.') ? 'active' : '' }}"
                                        href="{{ route('dashboard.gifttransfer.index') }}">
                                        @lang('Gifts Transfers') </a>
                                </li>

                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.map.') ? 'active' : '' }}"
                            href="{{ route('dashboard.map.index') }}">
                            <i class="ri-map-2-line"></i> <span data-key="t-layouts">@lang('Heat Map')</span>
                        </a>
                    </li>

                    <li class="nav-item">

                        <a class="nav-link menu-link {{ $isReportsActive ? 'active' : '' }}" href="#Reports"
                            data-bs-toggle="collapse" aria-expanded="{{ $isReportsActive ? 'true' : 'false' }}"
                            aria-controls="Reports" onkeypress="#">
                            <i class="ri-file-chart-line"></i> <span data-key="t-apps">@lang('Reports')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ $isReportsActive ? 'show' : '' }}" id="Reports">

                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{ route('dashboard.report.index') }}"
                                        class="nav-link {{ $currentRoute == 'dashboard.report.index' ? 'active' : '' }}"
                                        data-key="t-calendar"> @lang('Reports') </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ $currentRoute == 'dashboard.report.customer-orders' ? 'active' : '' }}"
                                        href="{{ route('dashboard.report.customer-orders') }}">
                                        @lang('Customer Orders') </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-link {{ $currentRoute == 'dashboard.report.month-orders' ? 'active' : '' }}"
                                        href="{{ route('dashboard.report.month-orders') }}">
                                        @lang('Month Orders') </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endif

                @if ($user->isAbleTo('finance-read'))
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.payment.') ? 'active' : '' }}"
                            href="{{ route('dashboard.payment.index') }}">
                            <i class="ri-bank-card-2-line"></i> <span data-key="t-pages">@lang('Payments')</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.customer.wallet') ? 'active' : '' }}"
                            href="{{ route('dashboard.customer.wallet') }}">
                            <i class="ri-wallet-3-line"></i> <span data-key="t-landing">@lang('Wallets')</span>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.coupon.') ? 'active' : '' }}"
                            href="{{ route('dashboard.coupon.index') }}">
                            <i class="ri-coupon-2-line"></i> <span data-key="t-landing">@lang('Coupons')</span>
                        </a>
                    </li>
                @endif

                @if ($user->isAbleTo('marketing-read'))
                    <li class="menu-title"><span data-key="t-menu">@lang('Contact Center')</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.marketing.') ? 'active' : '' }}"
                            href="{{ route('dashboard.marketing.index') }}">
                            <i class="ri-advertisement-line"></i> <span>@lang('Marketing')</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.contact.') ? 'active' : '' }}"
                            href="{{ route('dashboard.contact.index') }}">
                            <i class="ri-customer-service-2-line"></i> <span>@lang('Contact')</span>
                        </a>
                    </li>


                    <!-- <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.search.') ? 'active' : '' }}"
                            href="{{ route('dashboard.search.index') }}">
                            <i class="ri-search-eye-line"></i> <span>@lang('Search')</span>
                        </a>
                    </li> -->
                @endif

                @if ($user->isAbleTo('admin-read'))
                    <li class="menu-title"><i class="ri-more-fill"></i> <span
                            data-key="t-components">@lang('Team')</span></li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.role.') ? 'active' : '' }}"
                            href="{{ route('dashboard.role.index') }}">
                            <i class="ri-admin-line"></i> <span>@lang('Team Roles')</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.admin.') ? 'active' : '' }}"
                            href="{{ route('dashboard.admin.index') }}">
                            <i class="ri-team-fill"></i> <span>@lang('Team Members')</span>
                        </a>
                    </li>
                @endif

                @php
                    $isAppSettingsActive =
                        str_starts_with($currentRoute, 'dashboard.blog.') ||
                        str_starts_with($currentRoute, 'dashboard.banner.') ||
                        str_starts_with($currentRoute, 'dashboard.terms.');
                @endphp
                @if ($user->isAbleTo('setting-read'))


                    <li class="menu-title"><i class="ri-more-fill"></i> <span
                            data-key="t-components">@lang('Settings')</span></li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.setting.') ? 'active' : '' }}"
                            href="{{ route('dashboard.setting.index') }}">
                            <i class="ri-settings-5-line"></i> <span>@lang('General Settings')</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.customercard.') ? 'active' : '' }}"
                            href="{{ route('dashboard.customercard.index') }}">
                            <i class="ri-bank-card-line"></i> <span
                                data-key="t-authentication">@lang('Customers Cards')</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.birthday.') ? 'active' : '' }}"
                            href="{{ route('dashboard.birthday.index') }}">
                            <i class="ri-calendar-line"></i> <span
                                data-key="t-authentication">@lang('Customers Birthdays')</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $isAppSettingsActive ? 'active' : '' }}" href="#sidebarAuth"
                            data-bs-toggle="collapse" aria-expanded="{{ $isAppSettingsActive ? 'true' : 'false' }}"
                            aria-controls="sidebarAuth" onKeyPress="#">
                            <i class="ri-apps-2-line"></i> <span data-key="t-authentication">@lang('App Settings')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ $isAppSettingsActive ? 'show' : '' }}"
                            id="sidebarAuth">
                            <ul class="nav nav-sm flex-column">

                                @if ($user->isAbleTo('blog-read'))
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.blog.index') }}"
                                            class="nav-link {{ str_starts_with($currentRoute, 'dashboard.blog.') ? 'active' : '' }}">
                                            @lang('Blog') </a>
                                    </li>
                                @endif


                                <li class="nav-item">
                                    <a href="{{ route('dashboard.banner.index') }}"
                                        class="nav-link {{ str_starts_with($currentRoute, 'dashboard.banner.') ? 'active' : '' }}">
                                        @lang('Banners') </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('dashboard.terms.index') }}"
                                        class="nav-link {{ str_starts_with($currentRoute, 'dashboard.terms.') ? 'active' : '' }}">
                                        @lang('Terms & Conditions') </a>
                                </li>


                                {{--  <li class="nav-item">
                                <a href="#sidebarResetPass" class="nav-link" data-bs-toggle="collapse"  aria-expanded="false" aria-controls="sidebarResetPass" data-key="t-password-reset">Password Reset
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarResetPass">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-pass-reset-basic.html" class="nav-link" data-key="t-basic"> Basic </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-reset-cover.html" class="nav-link" data-key="t-cover"> Cover </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>  --}}

                            </ul>
                        </div>
                    </li>


                    @php
                        $isFoodicsActive = str_starts_with($currentRoute, 'dashboard.foodics-numbers.');
                    @endphp
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ $isFoodicsActive ? 'active' : '' }}" href="#sidebarFoodics"
                            data-bs-toggle="collapse" aria-expanded="{{ $isFoodicsActive ? 'true' : 'false' }}"
                            aria-controls="sidebarFoodics" onKeyPress="#">
                            <i class="ri-apps-2-line"></i> <span data-key="t-authentication">@lang('Foodics')</span>
                        </a>

                        <div class="collapse menu-dropdown {{ $isFoodicsActive ? 'show' : '' }}" id="sidebarFoodics">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{ route('dashboard.foodics-numbers.index') }}"
                                        class="nav-link {{ str_starts_with($currentRoute, 'dashboard.foodics-numbers.') ? 'active' : '' }}">
                                        @lang('Foodics Numbers') </a>
                                </li>

                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.activity.') ? 'active' : '' }}"
                            href="{{ route('dashboard.activity.index') }}">
                            <i class="ri-history-fill"></i> <span>@lang('Activity Log')</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link {{ str_starts_with($currentRoute, 'dashboard.notifications.') ? 'active' : '' }}"
                            href="{{ route('dashboard.notifications.index') }}">
                            <i class="ri-notification-4-line"></i> <span>@lang('Notifications')</span>
                        </a>
                    </li>


                    {{--  <li class="nav-item">
                    <a class="nav-link menu-link" href="#Archives" data-bs-toggle="collapse"  aria-expanded="false" aria-controls="Archives">
                        <i class="ri-archive-line"></i> <span data-key="t-landing">@lang('Archives')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="Archives">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="" class="nav-link" data-key="t-one-page">@lang('Providers') </a>
                            </li>

                            <li class="nav-item">
                                <a href="" class="nav-link" data-key="t-nft-landing">@lang('Customers') </a>
                            </li>

                            <li class="nav-item">
                                <a href="" class="nav-link" data-key="t-nft-landing">@lang('Services') </a>
                            </li>

                            <li class="nav-item">
                                <a href="" class="nav-link" data-key="t-nft-landing">@lang('Products') </a>
                            </li>

                        </ul>
                    </div>
                </li>  --}}

                @endif

            </ul>
        </div>

    </div>

    <div class="sidebar-background"></div>
</div>
