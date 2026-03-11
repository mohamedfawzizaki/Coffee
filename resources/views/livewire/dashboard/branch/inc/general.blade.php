<div class="tab-pane active" id="pill-justified-home-1" role="tabpanel">

    <div class="row">

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> @lang('Customers')</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ $customers->count() }}">0</span> </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-primary rounded fs-3">
                                <i class="bx bx-store text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> @lang('Orders')</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ $branch->orders->count() }}">0</span> </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-primary rounded fs-3">
                                <i class="bx bx-store text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> @lang('Available Products')</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ $availableProducts->count() }}">0</span> </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-primary rounded fs-3">
                                <i class="bx bx-store text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> @lang('Not Available Products')</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ $notAvailableProducts->count() }}">0</span> </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-primary rounded fs-3">
                                <i class="bx bx-store text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">@lang('Branch Information')</h4>
                </div>

                <div class="card-body">
                    <div id="map" style="height: 400px;"></div>
                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">@lang('orders')</h4>
                </div>

                <div class="card-body">
                    <div class="w-100">
                        <div id="ordersChart" data-colors='["--vz-secondary", "--vz-primary", "--vz-primary-rgb, 0.50"]'
                            class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


@push('js')
    <script>
        function initMap() {
            const defaultLat = {{ $branch->lat ?? 24.7136 }};
            const defaultLng = {{ $branch->lng ?? 46.6753 }};

            const mapElement = document.getElementById('map');
            if (!mapElement) {
                return;
            }

            const map = new google.maps.Map(mapElement, {
                center: {
                    lat: defaultLat,
                    lng: defaultLng
                },
                zoom: 15,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT
                }
            });

            const marker = new google.maps.Marker({
                position: {
                    lat: defaultLat,
                    lng: defaultLng
                },
                map: map,
                title: '{{ $branch->title ?? 'Branch Location' }}'
            });
        }

        function loadGoogleMaps() {
            if (typeof google !== 'undefined' && google.maps) {
                initMap();
            } else {
                const script = document.createElement('script');
                script.src =
                    'https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap';
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadGoogleMaps();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            options = {
                series: [{
                    name: "{{ __('Orders') }}",
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
                            return e !== undefined ? e.toFixed(0) + " {{ __('Orders') }}" : e;
                        }
                    }, {
                        formatter: function(e) {
                            return e !== undefined ? e.toFixed(0) + " {{ __('Orders') }}" : e;
                        }
                    }]
                }
            };

            chart = new ApexCharts(document.querySelector("#ordersChart"), options);
            chart.render();
        });
    </script>
@endpush
