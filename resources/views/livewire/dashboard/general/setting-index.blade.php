<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Settings')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Settings')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">


            <div class="row">
                <div class="col-md-2">
                    <div class="nav flex-column nav-pills text-start" id="v-pills-tab" role="tablist"
                        aria-orientation="vertical"
                        style="border: 1px solid #0000004d;padding: 10px 6px;box-shadow: 0px 9px 12px #00000017;">
                        <a class="nav-link mb-2 active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home"
                            role="tab" aria-controls="v-pills-home" aria-selected="true"><i
                                class="ri-settings-4-line me-1"></i>@lang('General Setting')</a>
                        <a class="nav-link mb-2" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile"
                            role="tab" aria-controls="v-pills-profile" aria-selected="false" tabindex="-1"><i
                                class="ri-links-line me-1"></i>@lang('Social Media')</a>
                        <a class="nav-link mb-2" id="orders-tab" data-bs-toggle="pill" href="#v-pills-orders"
                            role="tab" aria-controls="v-pills-orders" aria-selected="false" tabindex="-1"><i
                                class="ri-shopping-cart-line me-1"></i>@lang('Orders')</a>
                        <a class="nav-link mb-2" id="maintenance-tab" data-bs-toggle="pill" href="#v-pills-maintenance"
                            role="tab" aria-controls="v-pills-maintenance" aria-selected="false" tabindex="-1"><i
                                class="ri-tools-line me-1"></i>@lang('Maintenance')</a>
                    </div>
                </div>

                <div class="col-md-10">

                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">

                                @include('livewire.dashboard.general.setting.general')

                                @include('livewire.dashboard.general.setting.socialmedia')

                                @include('livewire.dashboard.general.setting.orders')

                                @include('livewire.dashboard.general.setting.maintenance')
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
