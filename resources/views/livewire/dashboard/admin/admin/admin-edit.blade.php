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
                        <div class="card-title">@lang('Edit Admin')</div>
                    </div>

                    <form wire:submit="updateAdmin">

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
                                <label for="category-title" class="form-label">@lang('Email')</label>
                                <input type="email" class="form-control" id="category-title" wire:model="email"
                                    placeholder="@lang('Email')">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category-title" class="form-label">@lang('Role')</label>
                                <select class="form-control" wire:model="role_id">
                                    <option value="">@lang('Select Role')</option>
                                    @foreach ($roles as $role)
                                        <option @if ($role->id == $this->role_id) selected @endif
                                            value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">@lang('Image')</label>
                                <input wire:model="newImage" type="file" id="image" class="form-control"
                                    placeholder="@lang('Image')" />
                                @error('newImage')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if ($image)
                                    <img src="{{ $image }}" alt="@lang('old avatar')"
                                        class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                @endif
                                <p class="text-muted">@lang('Leave blank to keep the old image')</p>
                            </div>


                            <div class="mb-3">
                                <label for="password" class="form-label">@lang('Password')</label>
                                <input wire:model="newPassword" type="password" id="password" class="form-control"
                                    placeholder="@lang('Password')" />
                                @error('newPassword')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <p class="text-muted">@lang('Leave blank to keep the old password')</p>
                            </div>
                        </div>

                        <div class="card-footer border-top-0">
                            <button class="btn btn-primary" type="submit">@lang('Update')</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
