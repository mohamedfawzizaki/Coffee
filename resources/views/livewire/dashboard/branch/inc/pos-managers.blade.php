<div class="tab-pane" id="pill-justified-pos-managers-1" role="tabpanel">

    @if ($branch->posManagers->count() > 0)

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('Name')</th>
                    <th scope="col">@lang('Email')</th>
                    <th scope="col">@lang('Phone')</th>
                    <th scope="col">@lang('Status')</th>
                    <th scope="col">@lang('Created At')</th>
                    <th scope="col">@lang('Actions')</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($branch->posManagers as $index => $posManager)

                <tr wire:key="product-order-{{ $posManager->id }}">

                    <td><a href="#" class="fw-semibold">#{{ $index + 1 }}</a></td>

                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="flex-shrink-0">
                                <img src="{{ $posManager->image }}" alt="" class="avatar-xs rounded-circle" />
                            </div>
                            <div class="flex-grow-1">
                                {{ $posManager->name }}
                            </div>
                        </div>
                    </td>

                    <td>  {{ $posManager->email }} </td>

                    <td>{{ $posManager->phone }}</td>

                    <td class="text-success"><i class="ri-checkbox-circle-line fs-17 align-middle"></i> {{ $posManager->status ? __('Active') : __('Inactive') }}</td>

                    <td>{{ $posManager->created_at->format('d/m/Y') }}</td>

                    <td>
                        <a href="{{ route('dashboard.posmanager.edit', $posManager->id) }}" class="btn btn-primary btn-sm" wire:navigate>
                            <i class="ri-eye-line"></i>
                            @lang('Edit')
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
