<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Customer Orders Report')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Customer Orders Report')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">

                <div class="mb-3">
                    <label for="type" class="form-label">@lang('Type')</label>
                    <select wire:model="type" id="type" class="form-control">
                        <option value="has_orders">@lang('Customers with Orders')</option>
                        <option value="no_orders">@lang('Customers without Orders')</option>
                    </select>
                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="from" class="form-label">@lang('From')</label>
                    <input wire:model="from" type="date" id="from" class="form-control">
                    @error('from') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="to" class="form-label">@lang('To')</label>
                    <input wire:model="to" type="date" id="to" class="form-control">
                    @error('to') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <button wire:click="generateReport" class="btn btn-primary">@lang('Generate Report')</button>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Customers')</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('Customer')</th>
                                    <th scope="col">@lang('Phone')</th>
                                    <th scope="col">@lang('Email')</th>
                                    <th scope="col">@lang('Orders')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $index => $customer)
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
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->orders_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">@lang('No customers found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

        @if(count($customers) > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Send Notification')</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="notificationTitle" class="form-label">@lang('Notification Title')</label>
                                        <input wire:model="notificationTitle" type="text" id="notificationTitle" class="form-control" placeholder="@lang('Enter notification title')">
                                        @error('notificationTitle') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="notificationContent" class="form-label">@lang('Notification Content')</label>
                                        <textarea wire:model="notificationContent" id="notificationContent" class="form-control" rows="3" placeholder="@lang('Enter notification content')"></textarea>
                                        @error('notificationContent') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="notificationDate" class="form-label">@lang('Date')</label>
                                        <input wire:model="notificationDate" type="date" id="notificationDate" class="form-control">
                                        @error('notificationDate') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="notificationTime" class="form-label">@lang('Time')</label>
                                        <input wire:model="notificationTime" type="time" id="notificationTime" class="form-control">
                                        @error('notificationTime') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button wire:click="sendNotification" class="btn btn-success">
                                        <i class="ri-notification-line align-middle me-1"></i>
                                        @lang('Send Notification')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Livewire.on('customers-generated', function(customers) {
            // You can add any additional JavaScript handling here if needed
        });

        Livewire.on('notification-sent', function() {
            // Show success message
            Swal.fire({
                title: '@lang("Success!")',
                text: '@lang("Notifications have been sent successfully.")',
                icon: 'success',
                confirmButtonText: '@lang("OK")'
            });
        });


    </script>

@endpush
