<div class="page-content" wire:ignore wire:poll.5s>

    <div class="container-fluid">

        <div class="row">
            <div class="col">

                <div class="h-100 mt-3">

                    <div class="row">

                        <div class="col-xl-4 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> @lang('Customers')</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $customers }}">0</span> </h4>
                                            <a href="{{ route('dashboard.customer.index') }}" class="text-decoration-underline" wire:navigate>@lang('View All')</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-success rounded fs-3">
                                                <i class="ri-team-line text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> @lang('Orders')</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $orders }}">0</span></h4>
                                            <a href="{{ route('dashboard.order.index') }}" class="text-decoration-underline" wire:navigate>@lang('View All')</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-warning rounded fs-3">
                                                <i class="ri-shopping-cart-2-line text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> @lang('Gifts')</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $gifts }}">0</span> </h4>
                                            <a href="{{ route('dashboard.gift.index') }}" class="text-decoration-underline" wire:navigate>@lang('View All')</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info rounded fs-3">
                                                <i class="ri-gift-line text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">@lang('Orders')</h4>
                                </div>

                                <div class="card-body p-0 pb-2">
                                    <div class="w-100">
                                        <div id="ordersChart" data-colors='["--vz-success", "--vz-primary", "--vz-primary-rgb, 0.50"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xl-6">
                            <div class="card">

                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">@lang('Best Selling Products')</h4>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                            <tbody>

                                                @foreach ($best_selling_products as  $product)

                                                <tr wire:key="product-{{ $product->id }}">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-light rounded p-1 me-2">
                                                                <img src="{{ $product->image }}" alt="" class="img-fluid d-block" />
                                                            </div>
                                                            <div>
                                                                <h5 class="fs-14 my-1"><a href="{{ route('dashboard.product.show', $product->id) }}" class="text-reset" wire:navigate>{{ $product->title }}</a></h5>
                                                                <span class="text-muted">{{ $product->created_at->format('d M Y') }} </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ $product->price }}</h5>
                                                        <span class="text-muted">@lang('Price')</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ $product->orders_count }}</h5>
                                                        <span class="text-muted">@lang('Orders')</span>
                                                    </td>
                                                    <td>
                                                        <h5 class="fs-14 my-1 fw-normal">{{ $product->orders_count * $product->price }}</h5>
                                                        <span class="text-muted">@lang('Revenue')</span>
                                                    </td>
                                                </tr>

                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">@lang('Latest Customers')</h4>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                            <tbody>
                                              @foreach ($latest_customers as $item)

                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 me-2">
                                                                <img src="{{ $item->image }}" alt="" class="avatar-sm rounded-circle" />
                                                            </div>
                                                            <div>
                                                                <h5 class="fs-14 my-1 fw-medium">
                                                                    <a href="{{ route('dashboard.customer.show', $item->id) }}" class="text-reset" wire:navigate>{{ $item->name }}</a>
                                                                </h5>
                                                             </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">{{ $item->email }}</span>
                                                    </td>
                                                    <td>
                                                       <a href="{{ route('dashboard.customer.show', $item->id) }}" class="btn btn-sm btn-soft-primary" wire:navigate>@lang('View')</a>
                                                    </td>
                                                </tr>

                                              @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@push('js')


    <script>

        let chart;

        function initChart() {
            if (chart) {
                chart.destroy();
            }

            // Only initialize if the element exists
            const chartElement = document.querySelector("#ordersChart");
            if (!chartElement) return;

            const options = {
                series: [{
                    name: "{{__('Orders')}}",
                    type: "area",
                    data: @json($ordersChart)
                }],
                chart: {
                    height: 370,
                    type: "line",
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    curve: "straight",
                    dashArray: [0, 0],
                    width: [2, 0]
                },
                fill: {
                    opacity: [0.1, 0.9]
                },
                markers: {
                    size: [0, 0],
                    strokeWidth: 2,
                    hover: {
                        size: 4
                    }
                },
                xaxis: {
                    categories: @json($months),
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                grid: {
                    show: true,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    },
                    padding: {
                        top: 0,
                        right: -2,
                        bottom: 15,
                        left: 10
                    }
                },
                legend: {
                    show: true,
                    horizontalAlign: "center",
                    offsetX: 0,
                    offsetY: -5,
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
                plotOptions: {
                    bar: {
                        columnWidth: "30%",
                        barHeight: "70%"
                    }
                },
                colors: ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0"],
                tooltip: {
                    shared: true,
                    y: [{
                        formatter: function(e) {
                            return e !== undefined ? e.toFixed(0) + " {{__('Orders')}}" : e;
                        }
                    }, {
                        formatter: function(e) {
                            return e !== undefined ? e.toFixed(0) + " {{__('Orders')}}" : e;
                        }
                    }]
                }
            };

            chart = new ApexCharts(chartElement, options);
            chart.render();
        }

        // Initialize on first load
        document.addEventListener('DOMContentLoaded', initChart);

        // Re-initialize when Livewire updates the page
        document.addEventListener('livewire:navigated', initChart);

        // Cleanup when navigating away
        document.addEventListener('livewire:navigating', () => {
            if (chart) {
                chart.destroy();
                chart = null;
            }
        });



    </script>

@endpush
