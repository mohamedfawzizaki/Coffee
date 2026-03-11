<div class="page-content" wire:poll.60s>
    <style>
        .sortable-ghost {
            opacity: 0.5;
            background: #f8f9fa !important;
            border: 2px dashed #6c757d !important;
        }
        .sortable-drag {
            background: #fff !important;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .list-group-item {
            cursor: default;
            transition: all 0.2s ease;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
        }
        .ri-drag-move-fill {
            cursor: grab;
            color: #6c757d;
        }
        .ri-drag-move-fill:active {
            cursor: grabbing;
        }
        .category-handle {
            padding: 5px;
            border-radius: 3px;
        }
        .category-handle:hover {
            background-color: #e9ecef;
        }
        .accordion-button {
            position: relative;
        }
        .category-sort-badge {
            position: absolute;
            right: 40px;
            font-size: 0.75rem;
        }
    </style>

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Products Sorting')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Products Sorting')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="accordion sortable-categories" id="categoryAccordion">

                            @foreach($categories as $category)

                                <div class="accordion-item" data-id="{{ $category->id }}" data-sort="{{ $category->sort ?? 0 }}">

                                    <h2 class="accordion-header" id="heading{{ $category->id }}">
                                        <button class="accordion-button {{ $openCategoryId == $category->id ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}" aria-expanded="{{ $openCategoryId == $category->id ? 'true' : 'false' }}" aria-controls="collapse{{ $category->id }}">
                                            <i class="ri-drag-move-fill me-2 category-handle"></i>
                                            {{ $category->title }}
                                            <span class="badge bg-secondary category-sort-badge">{{ $category->sort ?? 'N/A' }}</span>
                                        </button>
                                    </h2>

                                    <div id="collapse{{ $category->id }}" class="accordion-collapse collapse {{ $openCategoryId == $category->id ? 'show' : '' }}" aria-labelledby="heading{{ $category->id }}" data-bs-parent="#categoryAccordion">
                                        <div class="accordion-body">

                                            <ul class="list-group sortable-products" data-category-id="{{ $category->id }}">
                                                @foreach($category->products->sortBy('sort') as $product)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center"
                                                        data-id="{{ $product->id }}"
                                                        data-sort="{{ $product->sort }}"
                                                        wire:key="product-{{ $product->id }}">
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-drag-move-fill me-2"></i>
                                                            <img src="{{ $product->image }}" alt="{{ $product->title }}" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                            {{ $product->title }}
                                                        </div>
                                                        <span class="badge bg-primary rounded-pill">{{ $product->sort }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script>
        // Initialize sortables when the document loads initially
        document.addEventListener('DOMContentLoaded', function() {
            initCategorySortable();
            initProductSortables();
            initAccordionListeners();
        });

        // Function to initialize accordion event listeners
        function initAccordionListeners() {
            // Add event listeners to the accordion buttons
            document.querySelectorAll('.accordion-button').forEach(button => {
                button.addEventListener('click', function() {
                    // Get the category ID from the data-bs-target attribute
                    const targetId = this.getAttribute('data-bs-target');
                    const categoryId = targetId.replace('#collapse', '');

                    // Check if this is expanding or collapsing
                    const isExpanding = this.classList.contains('collapsed');

                    if (isExpanding) {
                        // If expanding, set the open category
                        // Get Livewire component instance
                        const component = window.Livewire.find(
                            this.closest('[wire\\:id]').getAttribute('wire:id')
                        );

                        // Call the Livewire method
                        if (component) {
                            component.call('setOpenCategory', categoryId);
                        }
                    }
                });
            });
        }

        // Livewire hook for component initialization (Livewire 3)
        document.addEventListener('livewire:init', function() {
            // Initialize when this specific component is loaded
            Livewire.hook('component.initialized', (component) => {
                // Check for both possible naming conventions in Livewire 3
                if (component.name === 'dashboard.product.category.category-product-order' ||
                    component.name === 'CategoryProductOrder') {
                    setTimeout(() => {
                        initCategorySortable();
                        initProductSortables();
                        initAccordionListeners();
                    }, 100); // Small delay to ensure DOM is ready
                }
            });

            // Initialize after any component update
            Livewire.hook('morph.updated', (el) => {
                if (el.closest('[wire\\:id]')) {
                    setTimeout(() => {
                        initCategorySortable();
                        initProductSortables();
                        initAccordionListeners();
                    }, 100); // Small delay to ensure DOM is ready
                }
            });
        });

        // For Livewire 3 navigation
        document.addEventListener('livewire:navigated', function() {
            setTimeout(() => {
                initCategorySortable();
                initProductSortables();
                initAccordionListeners();
            }, 100); // Small delay to ensure DOM is ready
        });

        // Listen for custom event from Livewire
        window.addEventListener('reinitializeSortable', function() {
            setTimeout(() => {
                initCategorySortable();
                initProductSortables();
                initAccordionListeners();
            }, 100); // Small delay to ensure DOM is ready
        });

        function initCategorySortable() {
            // Get the categories container
            const categoriesContainer = document.querySelector('.sortable-categories');

            // If container doesn't exist, exit early
            if (!categoriesContainer) return;

            // Destroy existing sortable instance if it exists
            if (categoriesContainer._sortable) {
                categoriesContainer._sortable.destroy();
            }

            // Create a new sortable instance for categories
            const categorySortable = new Sortable(categoriesContainer, {
                animation: 150,
                delay: 100,
                delayOnTouchOnly: true,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                handle: '.category-handle',
                onStart: function(evt) {
                    // Store the current open state before sorting
                    const openCategory = categoriesContainer.querySelector('.accordion-collapse.show');
                    if (openCategory) {
                        categoriesContainer.dataset.openCategory = openCategory.id;
                    }
                },
                onEnd: function(evt) {
                    if (evt.oldIndex !== evt.newIndex) {
                        const items = Array.from(categoriesContainer.querySelectorAll('.accordion-item[data-id]')).map((item, index) => {
                            return {
                                id: parseInt(item.dataset.id),
                                order: index + 1
                            };
                        });

                        // Get Livewire component instance
                        const component = window.Livewire.find(
                            categoriesContainer.closest('[wire\\:id]').getAttribute('wire:id')
                        );

                        // Call the Livewire method
                        if (component) {
                            component.call('updateCategoryOrder', items);
                        }
                    }
                }
            });

            // Store the sortable instance on the element
            categoriesContainer._sortable = categorySortable;
        }

        function initProductSortables() {
            // First, destroy any existing sortable instances
            try {
                document.querySelectorAll('.sortable-products').forEach(el => {
                    if (el._sortable) {
                        el._sortable.destroy();
                    }
                });

                // Then create new instances
                document.querySelectorAll('.sortable-products').forEach(el => {
                    // Safety check
                    if (!el) return;

                    const sortable = new Sortable(el, {
                        animation: 150,
                        delay: 100, // Slight delay to improve mobile experience
                        delayOnTouchOnly: true,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        dragClass: 'sortable-drag',
                        handle: '.ri-drag-move-fill',
                        onEnd: function(evt) {
                            if (evt.oldIndex !== evt.newIndex) {
                                const categoryId = evt.to.dataset.categoryId;
                                const items = Array.from(evt.to.querySelectorAll('li[data-id]')).map((item, index) => {
                                    return {
                                        id: parseInt(item.dataset.id),
                                        order: index + 1
                                    };
                                });

                                // Get Livewire component instance
                                try {
                                    const component = window.Livewire.find(
                                        evt.to.closest('[wire\\:id]').getAttribute('wire:id')
                                    );

                                    // Call the Livewire method
                                    if (component) {
                                        // Store the category ID to ensure this accordion stays open after update
                                        component.set('openCategoryId', categoryId);

                                        // Direct call with two separate parameters for updating product order
                                        component.call('updateProductOrder', categoryId, items);
                                    }
                                } catch (e) {
                                    console.error('Error calling Livewire method:', e);
                                }
                            }
                        }
                    });

                    // Store the sortable instance on the element
                    el._sortable = sortable;
                });
            } catch (e) {
                console.error('Error initializing product sortables:', e);
            }
        }
    </script>

    <style>
        .sortable-ghost {
            opacity: 0.5;
            background: #f8f9fa !important;
            border: 2px dashed #6c757d !important;
        }
    </style>
@endpush
