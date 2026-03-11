<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Customers Birthday')</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Customers Birthday')</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('Today Birthdays')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $todayBirthdays }}">{{ $todayBirthdays }}</span></h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i data-feather="external-link" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('This Month Birthdays')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $monthBirthdays }}">{{ $monthBirthdays }}</span></h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i data-feather="external-link" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('Sent Gifts')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $sentGifts }}">{{ $sentGifts }}</span></h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2 shadow">
                                        <i data-feather="external-link" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body checkout-tab">


                            <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                                <ul class="nav nav-pills nav-justified custom-nav">

                                    <li class="nav-item">
                                        <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-info" type="button" role="tab" aria-controls="pills-bill-info" aria-selected="true">
                                            <i class="ri-cake-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i> @lang('Customers')
                                        </button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link fs-15 p-3" id="pills-bill-address-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-address" type="button" role="tab" aria-controls="pills-bill-address" aria-selected="false">
                                            <i class="ri-gift-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i> @lang('Sent Gifts')
                                        </button>
                                    </li>

                                </ul>
                            </div>

                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="pills-bill-info" role="tabpanel" aria-labelledby="pills-bill-info-tab">

                                    <form wire:submit="filter" class="mb-4">

                                        <div class="row">


                                            <div class="col-md-4">
                                                <label class="visually-hidden" for="datefrom">@lang('Date From')</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">@lang('Date From')</div>
                                                    <input type="date" wire:model="datefrom" class="form-control" id="datefrom" placeholder="Username">
                                                </div>
                                                @error('datefrom') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label class="visually-hidden" for="dateto">@lang('Date To')</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">@lang('Date To')</div>
                                                    <input type="date" wire:model="dateto" class="form-control" id="dateto" placeholder="Username">
                                                </div>
                                                @error('dateto') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>


                                            <div class="col-md-4">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary flex-grow-1"><i class="ri-filter-2-line align-bottom me-1"></i> @lang('Filter')</button>
                                                    <button type="button" class="btn btn-warning flex-grow-1" wire:click="clearFilter"><i class="ri-refresh-line align-bottom me-1"></i> @lang('Clear')</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>

                                    <livewire:dashboard.birthday.customer-table />

                                </div>

                                <div class="tab-pane fade" id="pills-bill-address" role="tabpanel" aria-labelledby="pills-bill-address-tab">

                                    <livewire:dashboard.birthday.gift-table />

                                </div>


                            </div>

                    </div>

                </div>

            </div>


        </div>

    </div>


    <div class="offcanvas offcanvas-start {{ $showCanvas ? 'show' : '' }}" tabindex="-1" id="offcanvasLeft" aria-labelledby="offcanvasLeftLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasLeftLabel">@lang('Send Gifts')</h5>
            <button type="button" class="btn-close text-reset" wire:click="hideCanvas" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="sendgift">
        <div class="offcanvas-body">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex-grow-1 ms-3">
                <h6>@lang('Selected Customers')</h6>


                <input type="hidden" wire:model="customer_ids">


                <div class="avatar-group mb-2">
                    @if(isset($selectedCustomers) && count($selectedCustomers) > 0)
                        @foreach ($selectedCustomers as $customer)
                            <a href="javascript: void(0);" class="avatar-group-item shadow" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $customer['name'] }}">
                                <img src="{{ $customer['image'] }}" alt="" class="rounded-circle avatar-xs">
                            </a>
                        @endforeach
                    @else
                        <p>@lang('No customers selected')</p>
                    @endif
                </div>
             </div>

             <div class="mb-3">
                <label for="product" class="form-label">@lang('Select Product')</label>
                <select class="form-select" id="product" wire:model="product_id">
                    <option value="" selected disabled>@lang('Choose Product...')</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->title }}</option>
                    @endforeach
                </select>
                @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
             </div>


             <div class="mb-3">
                <label for="expire_date" class="form-label">@lang('Expire Date')</label>
                <input type="date" class="form-control" id="expire_date" wire:model="expire_date">
                @error('expire_date') <span class="text-danger">{{ $message }}</span> @enderror
             </div>


             <div class="mb-3">
                <label for="title" class="form-label">@lang('Title')</label>
                <input type="text" class="form-control" id="title" wire:model="title">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
             </div>


             <div class="mb-3">
                <label for="message" class="form-label">@lang('Message')</label>
                <textarea class="form-control" id="message" wire:model="message"></textarea>
                @error('message') <span class="text-danger">{{ $message }}</span> @enderror
             </div>

             <div class="mt-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ri-gift-line align-middle me-1"></i> @lang('Send Gift')
                </button>
             </div>

        </div>
    </form>
    </div>



</div>


@push('js')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('livewire:initialized', function () {
            // Add backdrop when canvas is shown
            Livewire.on('canvasStateChanged', function (isVisible) {
                if (isVisible) {
                    // Add backdrop
                    const backdrop = document.createElement('div');
                    backdrop.className = 'offcanvas-backdrop fade show';
                    document.body.appendChild(backdrop);

                    // Prevent body scrolling
                    document.body.classList.add('overflow-hidden');
                } else {
                    // Remove backdrop if exists
                    const backdrop = document.querySelector('.offcanvas-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }

                    // Re-enable body scrolling
                    document.body.classList.remove('overflow-hidden');
                }
            });

            // Listen for sendGifts event from the table component
            Livewire.on('sendGifts', function (customers) {
                // Send the event to show the canvas
                Livewire.dispatch('showCanvas');

                // Now customers can be either an array of IDs directly,
                // or an array of customer objects
                let customerIds = [];

                if (Array.isArray(customers)) {
                    // Check if the first item is a number (ID) or an object
                    if (customers.length > 0 && typeof customers[0] === 'object' && customers[0].id) {
                        // It's an array of objects
                        customerIds = customers.map(c => c.id);
                    } else {
                        // It's already an array of IDs
                        customerIds = customers;
                    }
                }

                console.log('Customer IDs to send:', customerIds);

                // Pass customer IDs to the parent component
                if (customerIds.length > 0) {
                    Livewire.dispatch('set-customer-ids', customerIds);
                } else {
                    console.error('No customer IDs found');
                }
            });
        });
    </script>
@endpush
