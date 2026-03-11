<div class="tab-pane fade border-0" id="finances" role="tabpanel" aria-labelledby="finances-tab" style="background: #fff;">

    <div class="mt-10">

        <div class="row">

            <div class="col-xl-4 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('Current Balance')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                        data-target="{{ number_format($customer->wallet, 2) }}">0</span></h2>
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



            <div class="col-xl-4 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('Total Transactions')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                        data-target="{{ $customer->wallets->sum('amount') }}">0</span>
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


            <div class="col-xl-4 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">@lang('Total Points')</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                        data-target="{{ number_format($customer->points, 2) }}">0</span></h2>
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

            <div class="col-md-6">

                @if ($customer->wallets->count() > 0)


                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-4">@lang('Wallet Records')</h4>
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead class="table-danger">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('Amount')</th>
                                            <th scope="col">@lang('Order')</th>
                                            <th scope="col">@lang('Description')</th>
                                            <th scope="col">@lang('Type')</th>
                                            <th scope="col">@lang('Operation Date')</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($customer->wallets as $index => $wallet)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ number_format($wallet->amount, 2) }}</td>
                                                <td>
                                                    @if ($wallet->order_id)
                                                        <a
                                                            href="{{ route('dashboard.order.show', $wallet->order_id) }}">
                                                            #{{ $wallet->order_id }} </a>
                                                    @else
                                                        @lang('None')
                                                    @endif
                                                </td>
                                                <td>{{ $wallet->content }}</td>
                                                <td>{{ $wallet->type }}</td>
                                                <td>{{ $wallet->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                @else
                    @include('inc.nodata')

                @endif

            </div>

            <div class="col-md-6">

                @if ($customer->points > 0)


                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="mb-4">@lang('Points Records')</h4>
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead class="table-danger">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('Amount')</th>
                                            <th scope="col">@lang('Order')</th>
                                            <th scope="col">@lang('Description')</th>
                                            <th scope="col">@lang('Type')</th>
                                            <th scope="col">@lang('Operation Date')</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($customer->pointsRecords as $index => $point)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>{{ number_format($point->amount, 2) }}</td>
                                                <td>
                                                    @if ($point->order_id)
                                                        <a
                                                            href="{{ route('dashboard.order.show', $point->order_id) }}">
                                                            #{{ $point->order_id }} </a>
                                                    @else
                                                        @lang('None')
                                                    @endif
                                                </td>
                                                <td>{{ $point->content }}</td>
                                                <td>{{ $point->type }}</td>
                                                <td>{{ $point->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                @else
                    @include('inc.nodata')

                @endif


            </div>


        </div>






    </div>

</div>
