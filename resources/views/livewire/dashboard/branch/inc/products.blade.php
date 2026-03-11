<div class="tab-pane" id="pill-justified-messages-1" role="tabpanel">


    <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box accordion-secondary"
        id="accordionBordered">

        @foreach ($categories as $index => $category)
            <div class="accordion-item shadow">
                <h2 class="accordion-header" id="accordionborderedExample{{ $index }}">
                    <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button"
                        data-bs-toggle="collapse" data-bs-target="#accor_borderedExamplecollapse{{ $index }}"
                        aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-controls="accor_borderedExamplecollapse{{ $index }}">
                        {{ $category->title }}
                    </button>
                </h2>

                <div id="accor_borderedExamplecollapse{{ $index }}"
                    class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                    aria-labelledby="accordionborderedExample{{ $index }}" data-bs-parent="#accordionBordered">
                    <div class="accordion-body">


                        <div class="table-responsive">

                            <table class="table align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">@lang('Product')</th>
                                        <th scope="col">@lang('Available')</th>
                                        <th scope="col">@lang('Actions')</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($category->products as $key => $product)
                                        <tr wire:key="product-{{ $product->id }}">

                                            <td style="width: 80px">
                                                <a href="#" class="fw-semibold">#{{ $key + 1 }}</a>
                                            </td>
                                            <td style="width: 300px">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ $product->image }}" alt=""
                                                            class="avatar-xs rounded-circle" />
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        {{ $product->title }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 200px">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="product-{{ $product->id }}" aria-checked="true"
                                                        @if (productAvailableInBranch($branch->id, $product->id)) checked @endif
                                                        wire:change="changestatus({{ $product->id }})">
                                                    <label class="form-check-label" for="product-{{ $product->id }}">
                                                        @if (!productAvailableInBranch($branch->id, $product->id))
                                                            @lang('Not Available')
                                                        @else
                                                            @lang('Available')
                                                        @endif
                                                    </label>
                                                </div>
                                            </td>
                                            <td style="width: 100px">
                                                <button class="btn btn-primary">
                                                    @lang('Show')
                                                </button>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <!-- end table -->
                        </div>


                    </div>
                </div>
            </div>
        @endforeach


    </div>


</div>


@push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        Livewire.on('refreshProducts', () => {
            const activeAccordions = document.querySelectorAll('.accordion-collapse.show');
            activeAccordions.forEach(accordion => {
                const id = accordion.getAttribute('id');
                const button = document.querySelector(`[data-bs-target="#${id}"]`);
                if (button) {
                    button.classList.remove('collapsed');
                }
            });

            $("#pill-justified-messages-1").click();

            console.log('Products refreshed');
        });
    </script>
@endpush
