<div class="tab-pane" id="pill-justified-profile-1" role="tabpanel">



    @if ($branch->orders->count() > 0)

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('Customer')</th>
                    <th scope="col">@lang('Price')</th>
                    <th scope="col">@lang('Items')</th>
                    <th scope="col">@lang('Status')</th>
                    <th scope="col">@lang('Created At')</th>
                    <th scope="col">@lang('Actions')</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($branch->orders as $index => $order)

                <tr wire:key="product-order-{{ $order->id }}">

                    <td><a href="#" class="fw-semibold">#{{ $index + 1 }}</a></td>

                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ $order->customer->image }}" alt="" class="avatar-xs rounded-circle" />
                            </div>
                            <div class="flex-grow-1">
                                {{ $order->customer->name }}
                            </div>
                        </div>
                    </td>

                    <td>
                        <ul>

                            <li>@lang('Total'): {{ $order->total }}</li>
                            <li>@lang('Discount'): {{ $order->discount }}</li>
                            <li>@lang('Tax'): {{ $order->tax }}</li>
                            <li>@lang('Grand Total'): {{ $order->grand_total }}</li>

                        </ul>
                    </td>

                    <td>{{ $order->items->count() }} @lang('Product') </td>

                    <td class="text-success"><i class="ri-checkbox-circle-line fs-17 align-middle"></i> {{ $order->status }}</td>

                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('dashboard.order.show', $order->id) }}" class="btn btn-primary btn-sm" wire:navigate>
                            <i class="ri-eye-line"></i>
                            @lang('View')
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
