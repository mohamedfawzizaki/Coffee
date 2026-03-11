<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Pos Manager')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Pos Manager')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">

            <div class="card custom-card">

                <div class="card-header justify-content-between">
                    <div class="card-title"> @lang('Create Pos Manager') </div>
                </div>

                <div class="card-body">


                <form wire:submit.prevent="createPosManager">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">@lang('Name')</label>
                            <input wire:model="name" type="text" id="name" class="form-control" placeholder="@lang('Name')" required />
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">@lang('Email')</label>
                            <input wire:model="email" type="email" id="email" class="form-control" placeholder="@lang('Email')" required />
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">@lang('Phone')</label>
                            <input wire:model="phone" type="text" id="phone" class="form-control" placeholder="@lang('Phone')" required />
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">@lang('Password')</label>
                            <input wire:model="password" type="password" id="password" class="form-control" placeholder="@lang('Password')" required />
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">@lang('Image')</label>
                            <input wire:model="image" type="file" id="image" class="form-control" placeholder="@lang('Image')" />
                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="branch_id" class="form-label">@lang('Branch')</label>
                            <select wire:model="branch_id" id="branch_id" class="form-control" required>
                                <option selected disabled>@lang('Select Branch')</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->title }}</option>
                                @endforeach
                            </select>
                            @error('branch_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="modal-footer">
                         <button type="submit" class="btn btn-primary"> @lang('Save')  </button>
                    </div>

                </form>

            </div>

        </div>

     </div>

    </div>

  </div>
