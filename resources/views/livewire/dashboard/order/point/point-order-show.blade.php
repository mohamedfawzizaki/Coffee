<div class="page-content">

    <div class="container-fluid">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

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
                                <a href="{{ route('dashboard.order.invoice', $order->id) }}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="ri-file-text-line align-middle me-1"></i> @lang('Invoice')
                                </a>
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
                                        <th scope="col" class="text-center">@lang('Action')</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($order->items as $item)

                                    <tr class="{{ $item->is_refunded ? 'table-danger' : '' }}">
                                        <td style="max-width: 200px;">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ $item->product?->image }}" alt="" class="img-fluid d-block" style="{{ $item->is_refunded ? 'opacity:0.5;' : '' }}">
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15 mt-3" style="word-wrap: break-word; max-width: 200px; overflow-wrap: break-word; white-space: normal; {{ $item->is_refunded ? 'text-decoration:line-through; color:#aaa;' : '' }}">
                                                        <a href="#" class="{{ $item->is_refunded ? 'text-muted' : 'link-primary' }}">{{ $item->product?->title }}</a>
                                                        @if ($item->size_id)
                                                            <small class="text-muted ms-1">({{ $item->size?->title }})</small>
                                                        @endif
                                                    </h5>

                                                    @if ($item->is_refunded)
                                                        <span class="badge bg-danger">@lang('Refunded')</span>
                                                        <small class="text-muted d-block mt-1">{{ $item->refunded_at?->format('d M Y H:i') }}</small>
                                                    @endif

                                                    @if ($item->note)
                                                        <p class="text-muted mb-0" style="max-width: 200px; word-wrap: break-word; overflow-wrap: break-word; white-space: normal;">
                                                            @lang('Note'): <span class="fw-medium">{{ $item->note }}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td style="{{ $item->is_refunded ? 'text-decoration:line-through; color:#aaa;' : '' }}">{{ $item->price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-medium text-end" style="{{ $item->is_refunded ? 'text-decoration:line-through; color:#aaa;' : '' }}">
                                            {{ $item->total }}
                                        </td>
                                        <td class="text-center">
                                            @if (!$item->is_refunded && (auth('admin')->user()->id == 1 || auth('admin')->user()->isAbleTo('order-update')))
                                                <button wire:click="refundItem({{ $item->id }})"
                                                    wire:confirm="@lang('Are you sure you want to refund this item? Customer points will be deducted.')"
                                                    class="btn btn-sm btn-outline-danger">
                                                    <i class="ri-refund-line me-1"></i>@lang('Refund')
                                                </button>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
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

                @if ($order->logs->count() > 0)

                <div class="card">

                    <div class="card-header">

                        <div class="d-sm-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Order Status')</h5>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="profile-timeline">
                            <div class="accordion accordion-flush" id="accordionFlushExample">

                                @foreach ($order->logs as $log)

                                <div class="accordion-item border-0 mb-3">
                                    <div class="accordion-header" id="headingOne">
                                            <div class="d-flex flex-column">

                                                <div class="d-flex align-items-center mb-2">

                                                    <div class="flex-shrink-0 avatar-xs me-2">

                                                        @if($log->customer)
                                                            <img src="{{ $log->customer->image }}" alt="" class="rounded-circle" style="width: 30px; height: 30px;">
                                                        @elseif($log->manager)
                                                            <img src="{{ $log->manager->image }}" alt="" class="rounded-circle" style="width: 30px; height: 30px;">
                                                        @else
                                                            <div class="avatar-title bg-success rounded-circle shadow">
                                                                <i class="ri-shopping-bag-line"></i>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div>
                                                        <h6 class="fs-15 mb-2 fw-semibold">
                                                            @if($log->customer)
                                                                <span class="text-success"> @lang('Customer') {{ $log->customer->name }}</span>
                                                            @elseif($log->manager)
                                                                <span class="text-primarty">@lang('Manager') {{ $log->manager->name }}</span>
                                                            @endif
                                                        </h6>
                                                    </div>

                                                </div>

                                                <div style="margin: 5px 40px;">
                                                    <p>
                                                        {{ $log->content }}
                                                        <span class="text-muted fw-normal">{{ $log->created_at->format('d M Y - H:i') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>

                @endif

            </div>

            <div class="col-xl-3">


                <div class="card">

                    <div class="card-header">

                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Order Status')</h5>
                        </div>

                    </div>

                    @if ($order->status !== 'completed' && $order->status !== 'cancelled' && (auth('admin')->user()->id == 1 || auth('admin')->user()->isAbleTo('order-update')))

                    <div class="card-body">


                        <div class="mb-3">
                            <label for="status" class="form-label">@lang('Status')</label>
                            <select class="form-select" id="statuss" name="status" wire:model="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>@lang('Pending')</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>@lang('Processing')</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>@lang('Completed')</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>@lang('Cancelled')</option>
                            </select>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button style="width: 100%;" wire:click="updateStatus" class="btn btn-primary d-block">@lang('Update')</button>
                    </div>

                    @else

                    <div class="card-body">
                        <p class="lead"> {{ $order->status }}</p>
                    </div>

                    @endif

                  </div>

                @if (!is_null($order->branch))

                <div class="card">

                    <div class="card-header">

                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Branch Details')</h5>
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
                                        <h6 class="fs-14 mb-1">{{ $order->branch->title }}</h6>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
                @endif

                @if ($order->type == 'gift' && $order->created_by == 'admin')
                <div class="card">

                    <div class="card-header">

                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Admin Details')</h5>

                        </div>

                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $order->admin?->image }}" alt="" class="avatar-sm rounded shadow">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{ $order->admin?->name }}</h6>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $order->admin?->email }}</li>
                            <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $order->admin?->phone }}</li>
                        </ul>
                    </div>

                </div>
                @else
                <div class="card">

                    <div class="card-header">

                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Customer Details')</h5>
                        </div>

                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $order->customer->image }}" alt="" class="avatar-sm rounded shadow">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{ $order->customer->name }}</h6>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $order->customer->email }}</li>
                            <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $order->customer->phone }}</li>
                        </ul>
                    </div>

                </div>
                @endif




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
                                <h6 class="mb-0">@lang(ucfirst($order->payment_method))</h6>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Payment Status'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">@lang(ucfirst($order->payment_status))</h6>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Payment ID'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $order->payment_id ?: '-' }}</h6>
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
