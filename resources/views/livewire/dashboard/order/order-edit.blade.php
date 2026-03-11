<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Order') #{{ $order->id }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Order Details')</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">

                                <h5 class="card-title flex-grow-1 mb-1">@lang('Order') #{{ $order->id }}</h5>
                                <p class="mb-0 text-success">@lang('Place'): {{ $order->place }}</p>
                            </div>

                            <div class="flex-shrink-0">
                                <button class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> @lang('Invoice')</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">

                            <table class="table table-nowrap align-middle table-borderless mb-0">

                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">@lang('Product Details')</th>
                                        <th scope="col">@lang('Item Price')</th>
                                        <th scope="col">@lang('Quantity')</th>
                                        <th scope="col" class="text-end">@lang('Total Amount')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($order->items as $item)

                                    <tr>
                                        <td style="max-width: 200px;">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ $item->product?->image }}" alt="" class="img-fluid d-block">
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15 mt-3" style="word-wrap: break-word; max-width: 200px; overflow-wrap: break-word; white-space: normal;">
                                                        <a href="#" class="link-primary">{{ $item->product?->title }}</a>
                                                        @if ($item->size_id)
                                                            <small class="text-muted ms-1">({{ $item->size?->title }})</small>
                                                        @endif
                                                    </h5>

                                                    @if ($item->note)
                                                        <p class="text-muted mb-0" style="max-width: 200px; word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
                                                            @lang('Note'): <span class="fw-medium">{{ $item->note }}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>


                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-medium text-end">   {{ $item->total }}  </td>
                                        <td> <button class="btn btn-danger btn-sm float-end" wire:click="deleteItem({{ $item->id }})">@lang('Delete')</button>  </td>
                                    </tr>

                                    @endforeach

                                    <tr class="border-top border-top-dashed">
                                        <td colspan="3"></td>
                                        <td colspan="2" class="fw-medium p-0">

                                            <table class="table table-borderless mb-0">

                                                <tbody>

                                                    <tr>
                                                        <td>@lang('Sub Total') :</td>
                                                        <td class="text-end">{{ $order->total }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('Discount') :</td>
                                                        <td class="text-end">-{{ $order->discount }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>@lang('Tax') :</td>
                                                        <td class="text-end">{{ $order->tax }}</td>
                                                    </tr>

                                                    <tr class="border-top border-top-dashed">
                                                        <th scope="row">@lang('Grand Total') :</th>
                                                        <th class="text-end" scope="row">{{ $order->grand_total }}</th>
                                                    </tr>

                                                </tbody>

                                            </table>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>

            <div class="col-xl-3">

                <div class="card">

                    <div class="card-header">

                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Branch Details')</h5>
                            <div class="flex-shrink-0">
                                @if($order?->branch)
                                    <a href="{{ route('dashboard.branch.show', $order->branch->id) }}" class="link-secondary" wire:navigate>@lang('View Profile')</a>
                                @else
                                    <span class="text-muted">@lang('N/A')</span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $setting->logo }}" alt="" class="avatar-sm rounded shadow">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{ $order?->branch?->title ?? '—' }}</h6>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>


                <div class="card">

                    <div class="card-header">

                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Customer Details')</h5>
                            <div class="flex-shrink-0">
                                @if($order?->customer)
                                    <a href="{{ route('dashboard.customer.show', $order->customer->id) }}" class="link-secondary" wire:navigate>@lang('View Profile')</a>
                                @else
                                    <span class="text-muted">@lang('N/A')</span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if($order?->customer?->image)
                                            <img src="{{ $order->customer->image }}" alt="" class="avatar-sm rounded shadow">
                                        @else
                                            <div class="avatar-sm rounded shadow bg-light d-flex align-items-center justify-content-center">
                                                <span class="text-muted">—</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{ $order?->customer?->name ?? '—' }}</h6>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $order?->customer?->email ?? '—' }}</li>
                            <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $order?->customer?->phone ?? '—' }}</li>
                        </ul>
                    </div>

                </div>


                {{--  <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Billing Address</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                            <li class="fw-medium fs-14">Joseph Parker</li>
                            <li>+(256) 245451 451</li>
                            <li>2186 Joyce Street Rocky Mount</li>
                            <li>New York - 25645</li>
                            <li>United States</li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                            <li class="fw-medium fs-14">Joseph Parker</li>
                            <li>+(256) 245451 451</li>
                            <li>2186 Joyce Street Rocky Mount</li>
                            <li>California - 24567</li>
                            <li>United States</li>
                        </ul>
                    </div>
                </div>

 --}}
                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> @lang('Payment Details')</h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Payment Method'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $order->payment_method }}</h6>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Payment Status'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $order->payment_status }}</h6>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Payment ID'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">#{{ $order->payment_id }}</h6>
                            </div>
                        </div>


                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('BY Visa'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $order->visa }}</h6>
                            </div>
                        </div>


                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('BY Wallet'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $order->wallet }}</h6>
                            </div>
                        </div>


                    </div>
                </div>

                @if ($order->coupon)


                <div class="card">

                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> @lang('Coupon Details')</h5>
                    </div>

                    <div class="card-body">

                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Coupon Code'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $order->coupon?->code }}</h6>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Discount'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $order->discount }}</h6>
                            </div>
                        </div>

                    </div>
                </div>

                @endif

            </div>

        </div>

    </div>
</div>
