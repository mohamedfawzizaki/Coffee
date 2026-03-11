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

            <div class="row">

                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold fs-16 me-1">@lang('Roles')</span>
                                 </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a  href="{{ route('dashboard.role.create') }}" class="btn btn-primary btn-sm" wire:navigate>
                                        <i class="ri-add-line me-1 fw-semibold align-middle"></i>
                                        @lang('Add New Role')
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <livewire:dashboard.admin.role.role-table theme="bootstrap-5"/>
                        </div>
                    </div>
                </div>

            </div>
        </div>
