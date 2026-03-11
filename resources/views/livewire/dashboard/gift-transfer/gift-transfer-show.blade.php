<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Gift Transfer') #{{ $gift->id }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.gifttransfer.index') }}" wire:navigate>@lang('Gift Transfers')</a></li>
                            <li class="breadcrumb-item active">@lang('Details')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">@lang('General Information')</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">@lang('Amount') :</th>
                                        <td class="text-muted"><span class="badge badge-soft-success fs-14">{{ number_format($gift->amount, 2) }}</span></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">@lang('Message') :</th>
                                        <td class="text-muted">{{ $gift->message ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">@lang('Sending Date') :</th>
                                        <td class="text-muted">{{ $gift->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <!-- Sender Details -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Sender Details')</h5>
                            <div class="flex-shrink-0">
                                <a href="{{ route('dashboard.customer.show', $gift->sender_id) }}" class="link-secondary" wire:navigate>@lang('View Profile')</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $gift->sender?->image }}" alt="" class="avatar-sm rounded shadow">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{ $gift->sender?->name }}</h6>
                                        <p class="text-muted mb-0">{{ $gift->sender?->phone }}</p>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $gift->sender?->email }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Receiver Details -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">@lang('Receiver Details')</h5>
                            <div class="flex-shrink-0">
                                <a href="{{ route('dashboard.customer.show', $gift->receiver_id) }}" class="link-secondary" wire:navigate>@lang('View Profile')</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $gift->receiver?->image }}" alt="" class="avatar-sm rounded shadow">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="fs-14 mb-1">{{ $gift->receiver?->name }}</h6>
                                        <p class="text-muted mb-0">{{ $gift->receiver?->phone }}</p>
                                    </div>
                                </div>
                            </li>
                            <li><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $gift->receiver?->email }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Payment Details -->
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
                                <h6 class="mb-0">@lang(ucfirst($gift->payment_method ?: 'Wallet'))</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-0">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">@lang('Payment ID'):</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $gift->payment_id ?: '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
