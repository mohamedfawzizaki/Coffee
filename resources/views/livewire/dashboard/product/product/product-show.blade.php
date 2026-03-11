<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Product Details')</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Product Details')</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body checkout-tab">

                        <form action="#">
                            <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                                <ul class="nav nav-pills nav-justified custom-nav" role="tablist">

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fs-15 p-3 active" id="pills-bill-info-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-info" type="button" role="tab" aria-controls="pills-bill-info" aria-selected="true">
                                            <i class="ri-user-2-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i> @lang('Product Details')
                                        </button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link fs-15 p-3" id="pills-bill-address-tab" data-bs-toggle="pill" data-bs-target="#pills-bill-address" type="button" role="tab" aria-controls="pills-bill-address" aria-selected="false">
                                            <i class="ri-truck-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i>@lang('Product Sales')
                                        </button>
                                    </li>

                                    {{--  <li class="nav-item" role="presentation">
                                        <button class="nav-link fs-15 p-3" id="pills-finish-tab" data-bs-toggle="pill" data-bs-target="#pills-finish" type="button" role="tab" aria-controls="pills-finish" aria-selected="false">
                                            <i class="ri-checkbox-circle-line fs-16 p-2 bg-soft-primary text-primary rounded-circle align-middle me-2"></i> @lang('product Reviews')
                                        </button>
                                    </li>  --}}
                                </ul>
                            </div>

                            <div class="tab-content">

                                <div class="tab-pane fade show active p-3" id="pills-bill-info" role="tabpanel" aria-labelledby="pills-bill-info-tab">

                                    <div class="row gx-lg-5">
                                        <div class="col-xl-4 col-md-8 mx-auto">
                                            <div class="product-img-slider sticky-side-div">
                                                <div class="swiper product-thumbnail-slider p-2 rounded bg-light">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="{{ $this->product->image }}" alt=""   class="img-fluid d-block" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-xl-8">

                                            <div class="mt-xl-0 mt-5">

                                                <div class="d-flex">

                                                    <div class="flex-grow-1">

                                                        <h4>{{ $product->title }}</h4>

                                                        <div class="hstack gap-3 flex-wrap">

                                                            <div class="text-muted"> @lang('Published') : <span class="text-body fw-medium"> {{ $product->created_at->format('d M, Y') }} </span></div>
                                                        </div>

                                                    </div>

                                                    {{--  <div class="flex-shrink-0">
                                                        <div>
                                                            <a href="{{ route('provider.product.edit', $product->id) }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" wire:navigate>
                                                                <i class="ri-pencil-fill align-bottom"></i>
                                                            </a>
                                                        </div>
                                                    </div>  --}}

                                                </div>


                                                    <div class="form-check form-switch mt-4">
                                                        <input class="form-check-input" type="checkbox"  id="SwitchCheck1" checked>
                                                        <label class="form-check-label" for="SwitchCheck1">@lang('Feautured')</label>
                                                    </div>


                                                <div class="row mt-4">

                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-money-dollar-circle-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">@lang('Price') :</p>
                                                                    <h5 class="mb-0">{{ $product->price }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-file-copy-2-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">@lang('No. of Orders') :</p>
                                                                    <h5 class="mb-0">{{ $this->product->orders->count() }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-stack-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">@lang('Orders Revenue') :</p>
                                                                    <h5 class="mb-0">{{ $this->product->orders->sum('price') }}</h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="p-2 border border-dashed rounded">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar-sm me-2">
                                                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                        <i class="ri-stack-fill"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <p class="text-muted mb-1">@lang('Points') :</p>
                                                                    <h5 class="mb-0">
                                                                        @if($this->product->can_replace)
                                                                            {{ $this->product->points }}
                                                                        @else
                                                                            <span class="badge bg-danger">@lang('No')</span>
                                                                        @endif
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                @if ($product->sizes->count() > 0)

                                                    <div class="row">

                                                        <div class="col-xl-12">
                                                            <div class="mt-4">
                                                                <h5 class="fs-14">@lang('Sizes') :</h5>
                                                                <div class="d-flex flex-wrap gap-2">

                                                                    @foreach ($product->sizes as $extra)

                                                                        <span class="badge bg-primary">{{ $extra->title }} | @lang('Price') : {{ $extra->price }}</span>

                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                @endif

                                                {{--  @if ($product->customFields->count() > 0)

                                                <div class="row">

                                                    <div class="col-xl-12">
                                                        <div class="mt-4">
                                                            <h5 class="fs-14">@lang('Custom Fields') :</h5>
                                                        </div>
                                                    </div>

                                                   @foreach ($product->customFields as $customField)


                                                        <div class="col-lg-3 col-sm-6">
                                                            <div class="p-2 border border-dashed rounded">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-sm me-2">
                                                                        <div class="avatar-title rounded bg-transparent text-success fs-24">
                                                                            <i class="ri-money-dollar-circle-fill"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-muted mb-1"> {{ $customField->title }} :</p>
                                                                     </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                  @endforeach

                                                </div>

                                                @endif  --}}


                                                <div class="mt-4 text-muted">
                                                    <h5 class="fs-14">@lang('Description') :</h5>
                                                    <p>
                                                        {!! $product->content !!}
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="pills-bill-address" role="tabpanel" aria-labelledby="pills-bill-address-tab">


                   @if ($product->orders->count() > 0)

                        <div class="table-responsive">

                                    <table class="table caption-top table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">@lang('Price')</th>
                                                <th scope="col">@lang('Quantity')</th>
                                                <th scope="col">@lang('Total')</th>
                                                <th scope="col">@lang('Created At')</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($product->orders as $index => $order)

                                                <tr>
                                                    <th scope="row">{{ $index + 1 }}</th>
                                                    <td>{{ $order->price }}</td>
                                                    <td>{{ $order->quantity }}</td>
                                                    <td>{{ $order->total }}</td>
                                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                                </tr>

                                            @endforeach

                                        </tbody>
                                    </table>

                        </div>

                            @else

                                @include('inc.nodata')

                            @endif

                        </div>


                            </div>

                    </div>
                </div>

            </div>
        </div>

    </div>






