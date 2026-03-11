
<div class="page-content">
    <div class="container-fluid" wire:ignore wire:poll.5s>

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Reports')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Reports')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Stats Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-white-50 text-truncate mb-0">@lang('Total Sales')</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white"><span class="counter-value" data-target="{{ $totalSales }}">{{ number_format($totalSales, 2) }}</span></h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-white-50 rounded fs-3">
                                    <i class="ri-money-dollar-circle-line text-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate bg-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-white-50 text-truncate mb-0">@lang('Net Profit')</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white"><span class="counter-value" data-target="{{ $netProfit }}">{{ number_format($netProfit, 2) }}</span></h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-white-50 rounded fs-3">
                                    <i class="ri-hand-coin-line text-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate bg-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-white-50 text-truncate mb-0">@lang('Total Customers')</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white"><span class="counter-value" data-target="{{ $totalCustomers }}">{{ $totalCustomers }}</span></h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-white-50 rounded fs-3">
                                    <i class="ri-user-follow-line text-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate bg-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-white-50 text-truncate mb-0">@lang('Total Orders')</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white"><span class="counter-value" data-target="{{ $totalOrdersCount }}">{{ $totalOrdersCount }}</span></h4>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-white-50 rounded fs-3">
                                    <i class="ri-shopping-cart-2-line text-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('Customer Tiers')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <ul class="list-group list-group-flush mb-0">
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span><i class="ri-checkbox-blank-circle-fill text-muted me-2"></i>@lang('Basic Tier')</span>
                                        <span class="fw-semibold">{{ $basicCustomers }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span><i class="ri-checkbox-blank-circle-fill text-silver me-2" style="color:#C0C0C0"></i>@lang('Silver Tier')</span>
                                        <span class="fw-semibold">{{ $silverCustomers }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span><i class="ri-checkbox-blank-circle-fill text-gold me-2" style="color:#FFD700"></i>@lang('Gold Tier')</span>
                                        <span class="fw-semibold">{{ $goldCustomers }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <div class="text-center mt-2">
                                    <i class="ri-group-line text-primary opacity-25" style="font-size: 80px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('Gift Analysis')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded shadow-sm text-center mb-3">
                                    <h6 class="text-muted mb-2">@lang('Gifts as Products')</h6>
                                    <h4 class="mb-0 text-primary">{{ number_format($giftProductsTotal, 2) }}</h4>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 bg-light rounded shadow-sm text-center mb-3">
                                    <h6 class="text-muted mb-2">@lang('Gifts as Cards')</h6>
                                    <h4 class="mb-0 text-success">{{ number_format($giftCardsTotal, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Stats Cards -->

        <div class="row">

            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Top Products')</h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">@lang('Product')</th>
                                        <th scope="col">@lang('Orders')</th>
                                        <th scope="col">@lang('Revenue')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($topProducts as $index => $product)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $product->image }}" alt="" class="avatar-xs rounded-circle" />
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $product->title }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-success"><i class="ri-checkbox-circle-line fs-17 align-middle"></i> {{ $product->orders_count }}</td>
                                        <td>{{ $product->orders->sum('grand_total') }}</td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Top Customers')</h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">@lang('Customer')</th>
                                        <th scope="col">@lang('Orders')</th>
                                        <th scope="col">@lang('Revenue')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($topCustomers as $index => $customer)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $customer->image }}" alt="" class="avatar-xs rounded-circle" />
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{ $customer->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-success"><i class="ri-checkbox-circle-line fs-17 align-middle"></i> {{ $customer->orders_count }}</td>
                                        <td>{{ $customer->orders->sum('grand_total') }}</td>
                                     </tr>

                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
                </div>



            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Top Categories')</h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">@lang('Category')</th>
                                        <th scope="col">@lang('Products')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($topCategories as $index => $category)

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td> {{ $category->title }} </td>
                                        <td class="text-success"><i class="ri-checkbox-circle-line fs-17 align-middle"></i> {{ $category->products_count }}</td>
                                     </tr>

                                    @endforeach

                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>

        </div>


        <div class="row mt-4">

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Top Branches by Net Sales')</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">@lang('Branch')</th>
                                        <th scope="col">@lang('Orders')</th>
                                        <th scope="col">@lang('Net Sales')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($branchOrders as $branch)
                                    <tr>
                                        <td>{{ $branch->title }}</td>
                                        <td>{{ $branch->orders_count }}</td>
                                        <td class="text-success fw-medium">{{ number_format($branch->orders_sum_grand_total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Branch Orders Count')</h5>
                    </div>
                    <div class="card-body">
                        <div id="branch-orders"></div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row mt-4">

            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title ">@lang('Orders Chart')</h5>
                        <div>
                           <select class="form-control" wire:model.live="year">
                            @for ($i = 2020; $i <= date('Y'); $i++)
                                <option @if($year == $i) selected @endif value="{{ $i }}">{{ $i }}</option>
                            @endfor
                           </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="orders-chart" wire:ignore></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('js')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    <script>

        let branchChart;

        function initBranchChart() {
            if (branchChart) {
                branchChart.destroy();
            }

            const options = {
                series: @json($branchOrders->pluck('orders_count')),
                chart: {
                    height: 370,
                    type: 'pie',
                },
                labels: @json($branchOrders->pluck('title')),
                colors: ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0"],
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    markers: {
                        width: 9,
                        height: 9,
                        radius: 6
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 0
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " {{__('Orders')}}";
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            branchChart = new ApexCharts(document.querySelector("#branch-orders"), options);
            branchChart.render();
        }

        // Initialize on first load
        document.addEventListener('DOMContentLoaded', initBranchChart);

        // Re-initialize when Livewire updates the page
        document.addEventListener('livewire:navigated', initBranchChart);


        let ordersPlaceChart;

        function initOrdersPlaceChart() {
            if (ordersPlaceChart) {
                ordersPlaceChart.destroy();
            }

            const options = {
                series: [@json($orders->where('place', 'branch')->count()), @json($orders->where('place', 'car')->count())],
                chart: {
                    height: 370,
                    type: 'pie',
                },
                labels: ["{{__('Branch Orders')}}", "{{__('Car Orders')}}"],
                colors: ["#008FFB", "#00E396"],
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    markers: {
                        width: 9,
                        height: 9,
                        radius: 6
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 0
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " {{__('Orders')}}";
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            ordersPlaceChart = new ApexCharts(document.querySelector("#orders-place"), options);
            ordersPlaceChart.render();
        }

        // Initialize on first load
        document.addEventListener('DOMContentLoaded', initOrdersPlaceChart);

        // Re-initialize when Livewire updates the page
        document.addEventListener('livewire:navigated', initOrdersPlaceChart);


        let ordersStatusChart;

        function initOrdersStatusChart() {
            if (ordersStatusChart) {
                ordersStatusChart.destroy();
            }

            const options = {
                series: [@json($orders->where('status', 'pending')->count()), @json($orders->where('status', 'processing')->count()), @json($orders->where('status', 'completed')->count())],
                chart: {
                    height: 370,
                    type: 'pie',
                },
                labels: ["{{__('Pending')}}", "{{__('Processing')}}", "{{__('Completed')}}"],
                colors: ["#008FFB", "#00E396", "#FEB019"],
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    markers: {
                        width: 9,
                        height: 9,
                        radius: 6
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 0
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " {{__('Orders')}}";
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            ordersStatusChart = new ApexCharts(document.querySelector("#orders-status"), options);
            ordersStatusChart.render();
        }

        // Initialize on first load
        document.addEventListener('DOMContentLoaded', initOrdersStatusChart);

        // Re-initialize when Livewire updates the page
        document.addEventListener('livewire:navigated', initOrdersStatusChart);


        let ordersChart;

        function initOrdersChart() {
            if (ordersChart) {
                ordersChart.destroy();
            }

            const options = {
                series: [{
                    name: "{{__('Orders')}}",
                    data: @json(array_values($chartData))
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: @json($months)
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " {{__('Orders')}}";
                        }
                    }
                }
            };

            ordersChart = new ApexCharts(document.querySelector("#orders-chart"), options);
            ordersChart.render();
        }

        // Initialize on first load
        document.addEventListener('DOMContentLoaded', initOrdersChart);

        // Re-initialize when Livewire updates the page
        document.addEventListener('livewire:navigated', initOrdersChart);

        // Listen for the chartDataUpdated event
        document.addEventListener('livewire:init', () => {
            Livewire.on('chartDataUpdated', (event) => {
                if (ordersChart) {
                    ordersChart.updateSeries([{
                        name: "{{__('Orders')}}",
                        data: Object.values(event.chartData)
                    }]);
                }
            });
        });

    </script>

@endpush
