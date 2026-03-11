
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Profile')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Profile')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>


        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-xxl-9">
                <div class="card custom-card">
                    <div class="card-header">
                        <ul class="nav nav-tabs nav-tabs-header" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="ti ti-user-circle me-2"></i>@lang('General Information')
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                    <i class="ti ti-lock me-2"></i>@lang('Password')
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="personalDetails" role="tabpanel">

                                <form wire:submit.prevent="updateProfile" enctype="multipart/form-data">
                                     <div class="row gy-3">
                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    wire:model="name" id="nameInput" placeholder="@lang('Name')">
                                                <label for="nameInput"><i class="ti ti-user me-2"></i>@lang('Name')</label>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                    wire:model="email" id="emailInput" placeholder="@lang('Email')">
                                                <label for="emailInput"><i class="ti ti-mail me-2"></i>@lang('Email')</label>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-12">

                                            <label for="category-title" class="form-label">@lang('Profile Picture')</label>

                                            <input type="file" class="form-control" id="category-title" wire:model="image" placeholder="@lang('Profile Picture')" accept="image/*">

                                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror

                                            <span wire:loading wire:target="image" class="text-success">
                                              @lang('Loading...')
                                            </span>

                                                @isset($image)
                                                    @if(is_string($image))
                                                        <img src="{{ $image }}" alt="@lang('Category Image')" class="mt-2" style="max-width: 100px;">
                                                    @else
                                                        <img src="{{ $image->temporaryUrl() }}" alt="@lang('Category Image')" class="mt-2" style="max-width: 100px;">
                                                    @endif
                                                @endisset

                                        </div>

                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="image">  <i class="ti ti-device-floppy me-1"></i> @lang('Update') </button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="changePassword" role="tabpanel">

                                <form wire:submit.prevent="updatePassword">

                                    <div class="row gy-3">

                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" id="newPasswordInput" placeholder="@lang('New Password')">
                                                <label for="newPasswordInput"><i class="ti ti-lock me-2"></i>@lang('New Password')</label>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating">
                                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model="password_confirmation" id="confirmPasswordInput" placeholder="@lang('Confirm Password')">
                                                <label for="confirmPasswordInput"><i class="ti ti-lock me-2"></i>@lang('Confirm Password')</label>
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-success">  <i class="ti ti-key me-1"></i>@lang('Change Password')  </button>
                                        </div>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
