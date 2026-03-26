<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Categories')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Categories')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            @if(auth('admin')->id() == 1 || auth('admin')->user()->isAbleTo('product-create'))
                            <a href="{{ route('dashboard.category.create') }}" class="btn btn-primary add-btn" wire:navigate>
                                <i class="ri-add-fill me-1 align-bottom"></i> @lang('Add Category')
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <div class="card" id="categoryList">
                <div class="card-body">
                    <div class="table-responsive table-card mb-3">

                        <livewire:dashboard.product.category.pcategory-table theme="bootstrap-5"/>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
