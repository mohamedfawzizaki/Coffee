    <style>
        .spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="col-12 mb-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ri-check-line me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="col-12 mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ri-error-warning-line me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="row">

        @if (!$branch->tabletManager)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="ri-tablet-line me-2"></i>
                            @lang('Add Tablet Manager')
                        </h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="addTabletManager">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="tablet_name">@lang('Name')</label>
                                    <input type="text" class="form-control" wire:model="tablet_name"
                                        placeholder="@lang('Enter name')">
                                    @error('tablet_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="tablet_email">@lang('Email')</label>
                                    <input type="email" class="form-control" wire:model="tablet_email"
                                        placeholder="@lang('Enter email')">
                                    @error('tablet_email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="tablet_phone">@lang('Phone')</label>
                                    <input type="text" class="form-control" wire:model="tablet_phone"
                                        placeholder="@lang('Enter phone')">
                                    @error('tablet_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="tablet_password">@lang('Password')</label>
                                    <input type="password" class="form-control" wire:model="tablet_password"
                                        placeholder="@lang('Enter password')">
                                    @error('tablet_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="tablet_password_confirmation">@lang('Confirm Password')</label>
                                    <input type="password" class="form-control"
                                        wire:model="tablet_password_confirmation" placeholder="@lang('Confirm password')">
                                    @error('tablet_password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                                        <span wire:loading.remove>
                                            <i class="ri-add-line me-1"></i>
                                            @lang('Add Tablet Manager')
                                        </span>
                                        <span wire:loading>
                                            <i class="ri-loader-4-line me-1 spin"></i>
                                            @lang('Adding...')
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-{{ $branch->tabletManager ? '12' : '6' }}">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="ri-tablet-line me-2"></i>
                        @lang('Tablet Manager')
                        @if ($branch->tabletManager)
                            <span class="badge bg-success ms-2">@lang('Assigned')</span>
                        @else
                            <span class="badge bg-secondary ms-2">@lang('Not Assigned')</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if ($branch->tabletManager)
                        @if (!$edit_mode && !$reset_password_mode)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0">
                                    <img src="{{ $branch->tabletManager->image }}" alt=""
                                        class="avatar-md rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">{{ $branch->tabletManager->name }}</h5>
                                    <p class="text-muted mb-1">{{ $branch->tabletManager->email }}</p>
                                    <p class="text-muted mb-0">{{ $branch->tabletManager->phone }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    @if ($branch->tabletManager->status)
                                        <span class="badge bg-success">@lang('Active')</span>
                                    @else
                                        <span class="badge bg-danger">@lang('Inactive')</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($edit_mode)
                            <!-- Edit Form -->
                            <form wire:submit.prevent="updateTabletManager">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="edit_tablet_name">@lang('Name')</label>
                                        <input type="text" class="form-control" wire:model="edit_tablet_name"
                                            placeholder="@lang('Enter name')">
                                        @error('edit_tablet_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="edit_tablet_email">@lang('Email')</label>
                                        <input type="email" class="form-control" wire:model="edit_tablet_email"
                                            placeholder="@lang('Enter email')">
                                        @error('edit_tablet_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="edit_tablet_phone">@lang('Phone')</label>
                                        <input type="text" class="form-control" wire:model="edit_tablet_phone"
                                            placeholder="@lang('Enter phone')">
                                        @error('edit_tablet_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-success" type="submit"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="updateTabletManager">
                                                    <i class="ri-save-line me-1"></i>
                                                    @lang('Update')
                                                </span>
                                                <span wire:loading wire:target="updateTabletManager">
                                                    <i class="ri-loader-4-line me-1 spin"></i>
                                                    @lang('Updating...')
                                                </span>
                                            </button>
                                            <button type="button" class="btn btn-secondary" wire:click="cancelEdit">
                                                <i class="ri-close-line me-1"></i>
                                                @lang('Cancel')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @elseif ($reset_password_mode)
                            <!-- Reset Password Form -->
                            <form wire:submit.prevent="resetTabletPassword">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="new_password">@lang('New Password')</label>
                                        <input type="password" class="form-control" wire:model="new_password"
                                            placeholder="@lang('Enter new password')">
                                        @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="new_password_confirmation">@lang('Confirm New Password')</label>
                                        <input type="password" class="form-control"
                                            wire:model="new_password_confirmation" placeholder="@lang('Confirm new password')">
                                        @error('new_password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning" type="submit"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove wire:target="resetTabletPassword">
                                                    <i class="ri-lock-line me-1"></i>
                                                    @lang('Reset Password')
                                                </span>
                                                <span wire:loading wire:target="resetTabletPassword">
                                                    <i class="ri-loader-4-line me-1 spin"></i>
                                                    @lang('Resetting...')
                                                </span>
                                            </button>
                                            <button type="button" class="btn btn-secondary"
                                                wire:click="cancelResetPassword">
                                                <i class="ri-close-line me-1"></i>
                                                @lang('Cancel')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>@lang('Created At'):</strong>
                                        {{ $branch->tabletManager->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>@lang('Last Login'):</strong>
                                        {{ $branch->tabletManager->updated_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @endif

                        @if (!$edit_mode && !$reset_password_mode)
                            <div class="mt-3">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary btn-sm" wire:click="editTabletManager">
                                        <i class="ri-edit-line"></i>
                                        @lang('Edit')
                                    </button>
                                    <button class="btn btn-outline-warning btn-sm" wire:click="showResetPassword">
                                        <i class="ri-lock-line"></i>
                                        @lang('Reset Password')
                                    </button>
                                    <button class="btn btn-danger btn-sm" wire:click="removeTabletManager"
                                        wire:confirm="@lang('Are you sure you want to remove this tablet manager?')" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="removeTabletManager">
                                            <i class="ri-delete-bin-line"></i>
                                            @lang('Remove')
                                        </span>
                                        <span wire:loading wire:target="removeTabletManager">
                                            <i class="ri-loader-4-line spin"></i>
                                            @lang('Removing...')
                                        </span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="ri-tablet-line display-4 text-muted"></i>
                            <h5 class="mt-3">@lang('No Tablet Manager')</h5>
                            <p class="text-muted">@lang('This branch does not have a tablet manager assigned yet.')</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
