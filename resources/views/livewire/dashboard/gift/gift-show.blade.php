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
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Order') #{{ $order->id }}</h5>
                            {{--  <div class="flex-shrink-0">
                                <button class="btn btn-success btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> @lang('Invoice')</button>
                            </div>  --}}
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
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($order->items as $item)

                                    <tr>

                                        <td>
                                            <div class="d-flex">

                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ $item->product?->image }}" alt="" class="img-fluid d-block">
                                                </div>


                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="fs-15 mt-3">
                                                        <a href="#" class="link-primary">{{ $item->product?->title }}</a>
                                                        @if ($item->size_id)
                                                            <small class="text-muted ms-1">({{ $item->size?->title }})</small>
                                                        @endif
                                                    </h5>
                                                </div>

                                            </div>
                                        </td>

                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-medium text-end">
                                            {{ $item->total }}
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

                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('General Information')</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">@lang('Order ID') :</th>
                                        <td class="text-muted">#{{ $order->id }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">@lang('Status') :</th>
                                        <td class="text-muted"><span class="badge badge-soft-primary text-uppercase">{{ $order->status }}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">@lang('Sending Date') :</th>
                                        <td class="text-muted">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">@lang('Message') :</th>
                                        <td class="text-muted">{{ $order->message ?: '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

{{--
                <div class="card">

                    <div class="card-header">

                        <div class="d-sm-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Order Status')</h5>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="profile-timeline">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingOne">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-success rounded-circle shadow">
                                                        <i class="ri-shopping-bag-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-0 fw-semibold">Order Placed - <span class="fw-normal">Wed, 15 Dec 2021</span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body ms-2 ps-5 pt-0">
                                            <h6 class="mb-1">An order has been placed.</h6>
                                            <p class="text-muted">Wed, 15 Dec 2021 - 05:34PM</p>

                                            <h6 class="mb-1">Seller has proccessed your order.</h6>
                                            <p class="text-muted mb-0">Thu, 16 Dec 2021 - 5:48AM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingTwo">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-success rounded-circle shadow">
                                                        <i class="mdi mdi-gift-outline"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-1 fw-semibold">Packed - <span class="fw-normal">Thu, 16 Dec 2021</span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body ms-2 ps-5 pt-0">
                                            <h6 class="mb-1">Your Item has been picked up by courier patner</h6>
                                            <p class="text-muted mb-0">Fri, 17 Dec 2021 - 9:45AM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingThree">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-success rounded-circle shadow">
                                                        <i class="ri-truck-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-15 mb-1 fw-semibold">Shipping - <span class="fw-normal">Thu, 16 Dec 2021</span></h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body ms-2 ps-5 pt-0">
                                            <h6 class="fs-14">RQK Logistics - MFDS1400457854</h6>
                                            <h6 class="mb-1">Your item has been shipped.</h6>
                                            <p class="text-muted mb-0">Sat, 18 Dec 2021 - 4.54PM</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingFour">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFour" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light text-success rounded-circle shadow">
                                                        <i class="ri-takeaway-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-0 fw-semibold">Out For Delivery</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="accordion-item border-0">
                                    <div class="accordion-header" id="headingFive">
                                        <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title bg-light text-success rounded-circle shadow">
                                                        <i class="mdi mdi-package-variant"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fs-14 mb-0 fw-semibold">Delivered</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--end accordion-->
                        </div>
                    </div>
                </div>  --}}

            </div>

            <div class="col-xl-3">

                @if (!is_null($order->branch))
                <div class="card">

                    <div class="card-header">

                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Branch Details')</h5>
                            <div class="flex-shrink-0">
                                <a href="{{ route('dashboard.branch.show', $order->branch->id) }}" class="link-secondary" wire:navigate>@lang('View Profile')</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $order->branch->logo }}" alt="" class="avatar-sm rounded shadow">
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

                <!-- Sender Details -->
                @if ($order->created_by == 'admin')
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">@lang('Sender Details') (@lang('Admin'))</h5>
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
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Sender Details')</h5>
                            <div class="flex-shrink-0">
                                <a href="{{ route('dashboard.customer.show', $order->customer->id) }}" class="link-secondary" wire:navigate>@lang('View Profile')</a>
                            </div>
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

                <!-- Receiver Details -->
                @if($order->sendTo)
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Receiver Details')</h5>
                            <div class="flex-shrink-0">
                                <a href="{{ route('dashboard.customer.show', $order->sendTo->id) }}" class="link-secondary" wire:navigate>@lang('View Profile')</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $order->sendTo?->image }}" alt="" class="avatar-sm rounded shadow">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{ $order->sendTo?->name }}</h6>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $order->sendTo?->email }}</li>
                            <li><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $order->sendTo?->phone }}</li>
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
                                <h6 class="mb-0">@lang($order->payment_method)</h6>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Payment Status'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">
                                    <span class="badge @if($order->payment_status == 'paid') badge-soft-success @else badge-soft-warning @endif text-uppercase">
                                        @lang($order->payment_status)
                                    </span>
                                </h6>
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


                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
