<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Activity Log')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Activity Log')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-lg">

            <div class="row justify-content-center">
                <div class="col-xxl-8 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <ul class="list-unstyled mb-0 notification-container">

                        @foreach ($activities as $activity)

                        <li>
                            <div class="card custom-card un-read">
                                 <div class="card-body p-3">
                                    <a href="javascript:void(0);">
                                        <div class="d-flex align-items-top mt-0 flex-wrap">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md me-3 avatar-rounded">
                                                    <img alt="avatar" src="{{ $activity->causer?->image  ?? asset('images/default-user.png') }}" width="50">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center">
                                                    <div class="mt-sm-0 mt-2">
                                                        <p class="mb-0 fs-14 fw-semibold">{{ $activity->causer?->name ?? 'Admin' }}</p>
                                                        <p class="mb-0 text-muted">

                                                            {{ $activity->subject_type ? __('admin.' . class_basename($activity->subject_type)) : '' }} |

                                                            {{ __('admin.' . $activity->description) }}

                                                            @if($activity->properties->isNotEmpty())
                                                                <div class="mt-2">
                                                                    @if($activity->properties->has('old') && $activity->properties->has('attributes'))
                                                                        @foreach($activity->properties['attributes'] as $key => $newValue)
                                                                            @if(isset($activity->properties['old'][$key]) && $activity->properties['old'][$key] !== $newValue)
                                                                                <p class="mb-1 text-muted fs-12">
                                                                                    <span class="fw-semibold fw-bold fs-10">{{ $key }}:</span>
                                                                                    <span class="d-block">
                                                                                        من: {{ is_array($activity->properties['old'][$key]) ? json_encode($activity->properties['old'][$key]) : $activity->properties['old'][$key] }}
                                                                                    </span>
                                                                                    <span class="d-block">
                                                                                        إلى: {{ is_array($newValue) ? json_encode($newValue) : $newValue }}
                                                                                    </span>
                                                                                </p>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </p>
                                                        <span class="mb-0 d-block text-muted fs-12">{{ $activity->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <span class="float-end badge bg-light text-muted">
                                                            {{ $activity->created_at->format('d M Y') }}
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

                    @if ($activities->hasMorePages())
                        <div
                            x-data="{}"
                            x-intersect="$wire.loadMore()"
                            class="text-center"
                        >
                            <button class="btn btn-info-transparent btn-loader my-3 mx-auto">
                                <span class="me-2">Loading</span>
                                <span class="loading"><i class="ri-loader-4-line fs-16"></i></span>
                            </button>
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>
</div>
