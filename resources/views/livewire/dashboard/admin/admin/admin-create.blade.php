<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Admins')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Admins')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title"> @lang('Create Admin') </div>
                    </div>

                    <form wire:submit="createAdmin">

                        <div class="card-body">

                            <div class="mb-3">
                                <label for="form-text" class="form-label fs-14 text-dark">@lang('Admin Name')</label>
                                <input type="text" class="form-control" wire:model="name" id="form-text"
                                    placeholder="@lang('Admin Name')">

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category-title" class="form-label"> @lang('Email') </label>
                                <input type="email" class="form-control" id="category-title" wire:model="email"
                                    placeholder="@lang('Email')">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category-title" class="form-label"> @lang('Password') </label>
                                <input type="password" class="form-control" id="category-title" wire:model="password"
                                    placeholder="@lang('Password')">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="admin-image" class="form-label"> @lang('Image') </label>
                                <input type="file" class="form-control" id="admin-image" wire:model="image"
                                    placeholder="@lang('Image')">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category-title" class="form-label"> @lang('Role') </label>
                                <select class="form-control" wire:model="role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>

                        <div class="card-footer border-top-0">
                            <button class="btn btn-primary" type="submit">@lang('Create')</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
