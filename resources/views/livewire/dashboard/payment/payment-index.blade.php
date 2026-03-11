<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Payments')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Payments')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-4 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('Today Payments')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                        data-target="{{ $today }}">0</span></h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i data-feather="dollar-sign" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('Month Payments')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                        data-target="{{ $month }}">0</span></h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i data-feather="credit-card" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('Total Payments')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                        data-target="{{ $total }}">0</span></h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i data-feather="trending-up" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            {{--  <div class="card">

                <div class="card-header border-0 align-items-center d-flex">

                    <h4 class="card-title mb-0 flex-grow-1">@lang('Payments Summary')</h4>

                    <div>
                        <button type="button" class="btn btn-secondary btn-sm shadow-none">
                            @lang('All')
                        </button>

                        <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                            @lang('Today')
                        </button>

                        <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                            @lang('Yesterday')
                        </button>

                        <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                            @lang('This Week')
                        </button>

                        <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                            @lang('This Month')
                        </button>

                        <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                            @lang('6 Months')
                        </button>

                        <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                            @lang('1 Year')
                        </button>
                    </div>

                </div>

                <div class="card-body">
                    @include('inc.nodata')
                </div>

            </div>  --}}

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <livewire:dashboard.payment.payment-table />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
