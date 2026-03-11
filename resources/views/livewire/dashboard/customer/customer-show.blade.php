<div class="page-content">

    <div class="container-fluid">
        <div class="profile-foreground position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg">
                <img src="{{ asset('images/profile-bg.jpg')}}" alt="" class="profile-wid-img" />
            </div>
        </div>
        <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
            <div class="row g-4">

                <div class="col-auto">
                    <div class="avatar-lg">
                        <img src="{{ $customer->image }}" alt="@lang('User Image')" class="img-thumbnail rounded-circle" />
                    </div>
                </div>

                <div class="col">
                    <div class="p-2">
                        <h3 class="text-white mb-1" style="margin-top: 20px;">{{ $customer->name }} </h3>
                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div>
                    <div class="d-flex profile-wrapper">

                        <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1">

                            <li class="nav-item">
                                <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                    <i class="ri-user-info-line d-inline-block"></i> <span class="d-none d-md-inline-block">@lang('General Info')</span>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#productorders" role="tab">
                                    <i class="ri-shopping-cart-line d-inline-block"></i> <span class="d-none d-md-inline-block">@lang('Orders')</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#giftstab" role="tab">
                                    <i class="ri-gift-2-line d-inline-block"></i> <span class="d-none d-md-inline-block">@lang('Gifts')</span>
                                </a>
                            </li>
{{--
                            <li class="nav-item">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#reviews" role="tab">
                                    <i class="ri-price-tag-line d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">@lang('Reviews')</span>
                                </a>
                            </li>  --}}


                            <li class="nav-item">
                                <a class="nav-link fs-14" data-bs-toggle="tab" href="#finances" role="tab">
                                    <i class="ri-money-dollar-circle-line d-inline-block"></i> <span class="d-none d-md-inline-block">@lang('Finances')</span>
                                </a>
                            </li>


                        </ul>


                       <div class="flex-shrink-0">

                            <a href="{{ route('dashboard.customer.edit', $customer->id) }}" class="btn btn-info" wire:navigate><i class="ri-edit-box-line align-bottom"></i> @lang('Edit Profile')</a>

                            {{--  <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri-message-2-line align-bottom me-1"></i> @lang('Send Notification')</button>  --}}

                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPoints"><i class="ri-coin-line align-bottom me-1"></i> @lang('Add Points')</button>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMoney"><i class="ri-wallet-3-line align-bottom me-1"></i> @lang('Add Money to Wallet')</button>

                            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">@lang('Send Notification')</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="title" class="form-label fs-14 text-dark">@lang('Title')</label>
                                                <input type="text" class="form-control" id="title" wire:model="title">
                                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>


                                            <div class="mb-3">
                                                <label for="content" class="form-label fs-14 text-dark">@lang('Content')</label>
                                                <textarea class="form-control" id="content" rows="5" wire:model="content"></textarea>
                                                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('Close')</button>
                                            <button type="button" class="btn btn-primary ">@lang('Send')</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div id="addPoints" class="modal fade" tabindex="-1" aria-labelledby="addPointsLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <form wire:submit.prevent="addPoints">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addPointsLabel">@lang('Add Points')</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="amount" class="form-label fs-14 text-dark">@lang('Amount')</label>
                                                <input type="number" class="form-control" id="amount" wire:model="amount">
                                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="ar_content" class="form-label fs-14 text-dark">@lang('Arabic Content')</label>
                                                <input type="text" class="form-control" id="ar_content" wire:model="ar_content">
                                                @error('ar_content') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="en_content" class="form-label fs-14 text-dark">@lang('English Content')</label>
                                                <input type="text" class="form-control" id="en_content" wire:model="en_content">
                                                @error('en_content') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('Close')</button>
                                            <button type="submit" class="btn btn-success">@lang('Add Points')</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <div id="addMoney" class="modal fade" tabindex="-1" aria-labelledby="addMoneyLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <form wire:submit.prevent="addMoney">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addMoneyLabel">@lang('Add Money to Wallet')</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="amount" class="form-label fs-14 text-dark">@lang('Amount')</label>
                                                <input type="number" class="form-control" id="amount" wire:model="amount">
                                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="ar_content" class="form-label fs-14 text-dark">@lang('Arabic Content')</label>
                                                <input type="text" class="form-control" id="ar_content" wire:model="ar_content">
                                                @error('ar_content') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="en_content" class="form-label fs-14 text-dark">@lang('English Content')</label>
                                                <input type="text" class="form-control" id="en_content" wire:model="en_content">
                                                @error('en_content') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('Close')</button>
                                            <button type="submit" class="btn btn-success">@lang('Add Money')</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="tab-content pt-4 text-muted">

                        @include('livewire.dashboard.customer.inc.general')

                        @include('livewire.dashboard.customer.inc.productorders')

                        {{--  @include('livewire.dashboard.customer.inc.reviews')  --}}

                        @include('livewire.dashboard.customer.inc.gifts')

                        @include('livewire.dashboard.customer.inc.finances')

                        @include('livewire.dashboard.customer.inc.chats')

                    </div>

                </div>
            </div>

        </div>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">@lang('Add New Transfer')</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="addTransfer">

                <div class="modal-body">

                    <p>@lang('Maximum transfer amount is') {{ $customer->wallet }}</p>

                <div class="mb-3">
                    <label for="form-text" class="form-label fs-14 text-dark">@lang('Enter Amount')</label>

                    <input type="number" wire:model="amount" max="{{ $customer->wallet }}" min="1" step="1" class="form-control" id="form-text" placeholder="">

                    <input type="hidden" wire:model="customer_id" value="{{ $customer->id }}" class="form-control" id="form-text">
                </div>

                <div class="mb-3">
                    <label for="transfer_number" class="form-label fs-14 text-dark">@lang('Transfer Number')</label>
                    <input type="text" wire:model="transfer_number" class="form-control" id="transfer_number" placeholder="">
                </div>

                <div class="mb-3">
                    <label for="form-password" class="form-label fs-14 text-dark">@lang('Transfer Image')</label>
                    <input type="file" wire:model="image" class="form-control dropify" id="form-password">
                </div>

             </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" wire:loading.attr="disabled" wire:target="addTransfer" class="btn btn-primary">@lang('Transfer')</button>
                </div>

            </form>

            </div>
        </div>
    </div>

    </div>
</div>
