<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Customers')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Customers')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title"> @lang('Edit Customer') </div>
                    </div>

                    <div class="card-body">

                        <form wire:submit.prevent="updateCustomer">

                            <div class="modal-body">


                                <div class="mb-3">
                                    <label for="name" class="form-label">@lang('Name')</label>
                                    <input wire:model="name" type="text" id="name" class="form-control"
                                        placeholder="@lang('Name')" required />
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">@lang('Email')</label>
                                    <input wire:model="email" type="email" id="email" class="form-control"
                                        placeholder="@lang('Email')" required />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">@lang('Phone')</label>
                                    <input wire:model="phone" type="text" id="phone" class="form-control"
                                        placeholder="@lang('Phone')" required />
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="birthday" class="form-label">@lang('Birthday')</label>
                                    <input wire:model="birthday" type="date" id="birthday" class="form-control"
                                        placeholder="@lang('Birthday')" />
                                    @error('birthday')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="points" class="form-label">@lang('Image')</label>
                                    <input wire:model="image" type="file" id="image" class="form-control"
                                        placeholder="@lang('Image')" />
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                                    wire:target="image,updateCustomer">
                                    <span wire:loading.remove wire:target="updateCustomer">@lang('Save')</span>
                                    <span wire:loading wire:target="updateCustomer">@lang('Saving...')</span>
                                </button>
                                <span class="text-success" wire:target="image" wire:loading>
                                    @lang('Uploading...')
                                </span>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
