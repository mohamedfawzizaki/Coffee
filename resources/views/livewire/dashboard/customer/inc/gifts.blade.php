<div class="tab-pane fade p-0 border-0" id="giftstab" role="tabpanel" aria-labelledby="gifts-tab" wire:ignore>

    <div class="card" style="background: #fff;">
        <div class="card-body">

            <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#sent-product-gifts" role="tab">
                        <i class="ri-gift-line me-1"></i> @lang('Sent Product Gifts') ({{ $customer->sentGifts->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#received-product-gifts" role="tab">
                        <i class="ri-gift-2-line me-1"></i> @lang('Received Product Gifts') ({{ $customer->receivedGifts->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#sent-gift-cards" role="tab">
                        <i class="ri-bank-card-line me-1"></i> @lang('Sent Gift Cards') ({{ $customer->sentGiftCards->count() }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#received-gift-cards" role="tab">
                        <i class="ri-hand-coin-line me-1"></i> @lang('Received Gift Cards') ({{ $customer->receivedGiftCards->count() }})
                    </a>
                </li>
            </ul>

            <div class="tab-content text-muted">
                <!-- Sent Product Gifts -->
                <div class="tab-pane active" id="sent-product-gifts" role="tabpanel">
                    @if ($customer->sentGifts->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('Receiver')</th>
                                    <th scope="col">@lang('Price')</th>
                                    <th scope="col">@lang('Items')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Created At')</th>
                                    <th scope="col">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->sentGifts as $index => $order)
                                <tr wire:key="sent-prod-gift-{{ $order->id }}">
                                    <td>#{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <img src="{{ $order->sendTo?->image }}" alt="" class="avatar-xs rounded-circle" />
                                            {{ $order->sendTo?->name }}
                                        </div>
                                    </td>
                                    <td>{{ number_format($order->grand_total, 2) }}</td>
                                    <td>{{ $order->items->count() }} @lang('Product') </td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.gift.show', $order->id) }}" class="btn btn-primary btn-sm" wire:navigate>
                                            <i class="ri-eye-line"></i> @lang('View')
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        @include('inc.nodata')
                    @endif
                </div>

                <!-- Received Product Gifts -->
                <div class="tab-pane" id="received-product-gifts" role="tabpanel">
                    @if ($customer->receivedGifts->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('Sender')</th>
                                    <th scope="col">@lang('Price')</th>
                                    <th scope="col">@lang('Items')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Created At')</th>
                                    <th scope="col">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->receivedGifts as $index => $order)
                                <tr wire:key="recv-prod-gift-{{ $order->id }}">
                                    <td>#{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <img src="{{ $order->customer->image }}" alt="" class="avatar-xs rounded-circle" />
                                            {{ $order->customer->name }}
                                        </div>
                                    </td>
                                    <td>{{ number_format($order->grand_total, 2) }}</td>
                                    <td>{{ $order->items->count() }} @lang('Product') </td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.gift.show', $order->id) }}" class="btn btn-primary btn-sm" wire:navigate>
                                            <i class="ri-eye-line"></i> @lang('View')
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        @include('inc.nodata')
                    @endif
                </div>

                <!-- Sent Gift Cards -->
                <div class="tab-pane" id="sent-gift-cards" role="tabpanel">
                    @if ($customer->sentGiftCards->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('Receiver')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Message')</th>
                                    <th scope="col">@lang('Created At')</th>
                                    <th scope="col">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->sentGiftCards as $index => $gift)
                                <tr wire:key="sent-card-gift-{{ $gift->id }}">
                                    <td>#{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <img src="{{ $gift->receiver?->image }}" alt="" class="avatar-xs rounded-circle" />
                                            {{ $gift->receiver?->name }}
                                        </div>
                                    </td>
                                    <td><span class="text-success fw-medium">{{ number_format($gift->amount, 2) }}</span></td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $gift->message }}</td>
                                    <td>{{ $gift->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.gifttransfer.show', $gift->id) }}" class="btn btn-primary btn-sm" wire:navigate>
                                            <i class="ri-eye-line"></i> @lang('View')
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        @include('inc.nodata')
                    @endif
                </div>

                <!-- Received Gift Cards -->
                <div class="tab-pane" id="received-gift-cards" role="tabpanel">
                    @if ($customer->receivedGiftCards->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('Sender')</th>
                                    <th scope="col">@lang('Amount')</th>
                                    <th scope="col">@lang('Message')</th>
                                    <th scope="col">@lang('Created At')</th>
                                    <th scope="col">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer->receivedGiftCards as $index => $gift)
                                <tr wire:key="recv-card-gift-{{ $gift->id }}">
                                    <td>#{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <img src="{{ $gift->sender?->image }}" alt="" class="avatar-xs rounded-circle" />
                                            {{ $gift->sender?->name }}
                                        </div>
                                    </td>
                                    <td><span class="text-success fw-medium">{{ number_format($gift->amount, 2) }}</span></td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $gift->message }}</td>
                                    <td>{{ $gift->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.gifttransfer.show', $gift->id) }}" class="btn btn-primary btn-sm" wire:navigate>
                                            <i class="ri-eye-line"></i> @lang('View')
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        @include('inc.nodata')
                    @endif
                </div>

            </div>
        </div>
    </div>



</div>
