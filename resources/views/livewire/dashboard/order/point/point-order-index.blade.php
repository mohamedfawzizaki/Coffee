<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Point Orders')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Point Orders')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <div class="card" id="categoryList">
                <div class="card-body">
                    <div class="table-responsive table-card mb-3">

                        <livewire:dashboard.order.point.point-order-table theme="bootstrap-5"/>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
