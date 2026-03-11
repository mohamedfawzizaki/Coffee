<div class="tab-pane" id="pill-justified-settings-1" role="tabpanel">

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('Customer')</th>
                    <th scope="col">@lang('Phone')</th>
                    <th scope="col">@lang('Email')</th>
                    <th scope="col">@lang('Actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>

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

                    <td>
                        <a href="{{ route('dashboard.customer.show', $customer->id) }}" class="btn btn-primary btn-sm" wire:navigate>
                            <i class="ri-eye-line"></i>
                            @lang('View')
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</div>
