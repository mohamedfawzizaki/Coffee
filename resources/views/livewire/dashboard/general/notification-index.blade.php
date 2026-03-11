<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Notifications')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Notifications')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

            <div class="row justify-content-center">


                <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12">

                    @if ($notifications->count() > 0)


                    <ul class="list-unstyled mb-0 notification-container">

                        @foreach ($notifications as $item)


                        <li wire:key="{{ $item->id }}">
                            <div class="card custom-card un-read">
                                <div class="card-body p-3">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex align-items-top mt-0 flex-wrap">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md online me-3 avatar-rounded">
                                                    <img alt="avatar" src="../assets/images/faces/4.jpg">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center">
                                                    <div class="mt-sm-0 mt-2">
                                                        <p class="mb-0 fs-14 fw-semibold">Emperio</p>
                                                        <p class="mb-0 text-muted">Project assigned by the manager all<span class="badge bg-primary-transparent fw-semibold mx-1">files</span>and<span class="badge bg-primary-transparent fw-semibold mx-1">folders</span>were included</p>
                                                        <span class="mb-0 d-block text-muted fs-12">12 mins ago</span>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <span class="float-end badge bg-light text-muted">
                                                            24,Oct 2022
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>

                        @endforeach

                    </ul>

                    @else

                    @include('inc.nodata')

                    @endif
                </div>
            </div>
            <!--End::row-1 -->
        </div>

    </div>
</div>
