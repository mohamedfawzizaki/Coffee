
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

                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="fw-semibold fs-16 me-1">@lang('Admins')</span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @if(auth('admin')->id() == 1 || auth('admin')->user()->isAbleTo('create-admin'))
                                        <a href="{{ route('dashboard.admin.create') }}" class="btn btn-primary btn-sm" wire:navigate><i class="ri-add-line me-1| fw-semibold align-middle" ></i> @lang('Create Admin')  </a>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">

                                <livewire:dashboard.admin.admin.admin-table theme="bootstrap-5"/>

                            </div>
                        </div>
                    </div>

                </div>
    </div>
</div>
