<div class="tab-pane active" id="overview-tab" role="tabpanel" wire:ignore>
    <div class="row">
        <div class="col-xxl-3">

            <div class="card border card-border-light" style="background: #fff;">
                <div class="card-body">
                    <h5 class="card-title mb-3">@lang('Info')</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th class="ps-0" scope="row"><i class="ri-user-line me-2"></i>@lang('Name')
                                        :</th>
                                    <td class="text-muted">{{ $customer->name }}</td>
                                </tr>

                                <tr>
                                    <th class="ps-0" scope="row"><i class="ri-mail-line me-2"></i>@lang('E-mail')
                                        :</th>
                                    <td class="text-muted">{{ $customer->email }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row"><i
                                            class="ri-phone-line me-2"></i>@lang('Phone') :</th>
                                    <td class="text-muted">{{ $customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row"><i
                                            class="ri-calendar-line me-2"></i>@lang('Birthday') :</th>
                                    <td class="text-muted">{{ $customer->birthday }}</td>
                                </tr>
                                <tr>
                                    <th class="ps-0" scope="row"><i
                                            class="ri-calendar-line me-2"></i>@lang('Joining Date') :</th>
                                    <td class="text-muted">{{ $customer->created_at->format('Y-m-d') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if ($customer->card)
                <div class="card border card-border-light" style="background: #fff;">
                    <div class="card-header">
                        <h5 class="card-title mb-3">@lang('Customer Card')</h5>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset($customer->card?->image) }}" alt="" class="img-fluid">
                    </div>
                </div>
            @endif

        </div>

        <div class="col-xxl-9">

            <div class="row">

                <div class="col-md-3">
                    <div class="card border card-border-light card-animate" style="background: #fff;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">@lang('Orders')</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                            data-target="{{ $customer->orders()->count() }}">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                            <i data-feather="shopping-bag" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border card-border-light card-animate" style="background: #fff;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">@lang('Gifts')</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                            data-target="{{ $customer->gifts()->count() }}">0</span></h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                            <i data-feather="activity" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border card-border-light card-animate" style="background: #fff;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">@lang('Wallet Balance')</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value" 
                                            data-target="{{ is_numeric($customer->wallet) ? $customer->wallet : 0 }}">
                                            {{ number_format($customer->wallet, 2) }}
                                        </span>
                                    </h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                            <i data-feather="activity" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="card border card-border-light card-animate" style="background: #fff;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-medium text-muted mb-0">@lang('Points')</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value"
                                              data-target="{{ is_numeric($customer->points) ? $customer->points : 0 }}">
                                            {{ number_format($customer->points ?? 0, 2) }}
                                        </span>
                                    </h2>
                                </div>
                                <div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                            <i data-feather="activity" class="text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">@lang('Orders Chart')</h5>
                    </div>
                    <div class="card-body" wire:ignore>
                        <canvas id="ordersChart" wire:ignore></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Re-initialize chart when navigating
        document.addEventListener('livewire:navigated', () => {
            const ctx = document.getElementById('ordersChart')?.getContext('2d');
            if (ctx) {
                // Get data from PHP
                const ordersData = @json($ordersChart);

                // Prepare data for chart
                const months = ordersData.map(item => item.month);
                const orders = ordersData.map(item => item.orders);

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [{
                            label: '@lang('Orders')',
                            data: orders,
                            borderColor: '#4b38b3',
                            backgroundColor: 'rgba(75, 56, 179, 0.2)',
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
        // Get data from PHP
        const ordersData = @json($ordersChart);

        // Prepare data for chart
        const months = ordersData.map(item => item.month);
        const orders = ordersData.map(item => item.orders);

        // Initialize chart
        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: '@lang('Orders')',
                    data: orders,
                    borderColor: '#4b38b3',
                    backgroundColor: 'rgba(75, 56, 179, 0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
