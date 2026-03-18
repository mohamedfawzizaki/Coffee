<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Roles')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Roles')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form id="createproduct-form" autocomplete="off" class="needs-validation" novalidate method="POST"
            wire:submit="update">

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">

                            <div class="row g-3">

                                <div class="form-floating">
                                    <input type="text" required class="form-control" id="sdfsdf"
                                        placeholder="@lang('name')" wire:model="name" required>
                                    <label for="sdfsdf"> @lang('Role Name') </label>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <div class="col-md-12">

                <div class="row">

                    @foreach (roleModel() as $permission)
                        <div class="col-lg-3">

                            <div class="card">

                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1"> @lang($permission)</h4>
                                    <div class="flex-shrink-0">
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <input class="form-check-input" type="checkbox"
                                                wire:click="selectGroup('{{ $permission }}', $event.target.checked)">
                                            <label class="form-label text-muted">@lang('Select All')</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <div class="live-preview">

                                        <div class="list-group">
                                            @foreach ($actions as $map)
                                                <div class="col-md-12">

                                                    <div class="list-group-item list-group-item-action">

                                                        <input type="checkbox" id="{{ $permission . '-' . $map }}"
                                                            name="permissions[]" class="custom-switch-input"
                                                            wire:model="permissions.{{ $permission }}.{{ $map }}">
                                                        <label for="{{ $permission . '-' . $map }}"
                                                            class="custom-switch-description"> @lang($map)</label>
                                                    </div>

                                                </div>
                                            @endforeach

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mb-4">
                <a href="{{ route('dashboard.role.index') }}" class="btn btn-danger w-sm" navigate>@lang('Cancel')</a>
                <button type="submit" class="btn btn-success w-sm">@lang('Save')</button>
            </div>

    </div>

    </form>

</div>

</div>

@push('js')
@endpush
