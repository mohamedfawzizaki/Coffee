<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Foodics Numbers')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Foodics Numbers')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">@lang('Banned Numbers List')</h5>
                        <button type="button" class="btn btn-primary" wire:click="openModal">
                            <i class="ri-add-line me-1"></i>@lang('Add New Number')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <livewire:dashboard.foodics.foodics-number-table />
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Number Modal -->
        @if ($showModal)
            <div class="modal fade show" style="display: block;" tabindex="-1" aria-labelledby="addNumberModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNumberModalLabel">@lang('Add New Banned Number')</h5>
                            <button type="button" class="btn-close" wire:click="closeModal"
                                aria-label="Close"></button>
                        </div>
                        <form wire:submit.prevent="addNumber">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="number" class="form-label">@lang('Phone Number')</label>
                                    <input type="text" class="form-control @error('number') is-invalid @enderror"
                                        id="number" wire:model="number" placeholder="@lang('Enter phone number')">
                                    @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeModal">@lang('Close')</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="ri-save-line me-1"></i>@lang('Save Number')
                                    </span>
                                    <span wire:loading>
                                        <i class="ri-loader-4-line me-1 spin"></i>@lang('Saving...')
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade show"></div>
        @endif

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

    </div>
</div>
