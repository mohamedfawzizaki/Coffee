<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card mt-n4 mx-n4 mb-n5">
                    <div class="bg-soft-warning">
                        <div class="card-body pb-4 mb-5">
                            <div class="row">
                                <div class="col-md">
                                    <div class="row align-items-center">
                                        <div class="col-md-auto">
                                            <div class="avatar-md mb-md-0 mb-4">
                                                <div class="avatar-title bg-white rounded-circle">
                                                    <img src="{{ $setting->logo }}" alt="" class="avatar-sm" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md">
                                            <h4 class="fw-semibold" id="ticket-title">{{ $branch->title }}</h4>
                                            <div class="hstack gap-3 flex-wrap">
                                                <div class="vr"></div>
                                                <div class="text-muted">@lang('Created at') : <span class="fw-medium "
                                                        id="create-date">{{ $branch->created_at->format('d M, Y') }}</span>
                                                </div>
                                                <div class="vr"></div>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="card" style="background-color: #f8f9fa;">

                <div class="card-header">

                    <ul class="nav nav-pills nav-justified">

                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light {{ $activeTab == 'general' ? 'active' : '' }}"
                                data-bs-toggle="tab" href="#pill-justified-home-1" role="tab"
                                aria-selected="{{ $activeTab == 'general' ? 'true' : 'false' }}"
                                wire:click="setActiveTab('general')">
                                <i class="ri-home-4-line me-1"></i> @lang('General Information')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light {{ $activeTab == 'orders' ? 'active' : '' }}"
                                data-bs-toggle="tab" href="#pill-justified-profile-1" role="tab"
                                aria-selected="{{ $activeTab == 'orders' ? 'true' : 'false' }}"
                                wire:click="setActiveTab('orders')">
                                <i class="ri-shopping-cart-line me-1"></i> @lang('Orders')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light {{ $activeTab == 'products' ? 'active' : '' }}"
                                data-bs-toggle="tab" href="#pill-justified-messages-1" role="tab"
                                aria-selected="{{ $activeTab == 'products' ? 'true' : 'false' }}"
                                wire:click="setActiveTab('products')">
                                <i class="ri-store-2-line me-1"></i> @lang('Products')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light {{ $activeTab == 'customers' ? 'active' : '' }}"
                                data-bs-toggle="tab" href="#pill-justified-settings-1" role="tab"
                                aria-selected="{{ $activeTab == 'customers' ? 'true' : 'false' }}"
                                wire:click="setActiveTab('customers')">
                                <i class="ri-user-line me-1"></i> @lang('Customers')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light {{ $activeTab == 'pos-managers' ? 'active' : '' }}"
                                data-bs-toggle="tab" href="#pill-justified-pos-managers-1" role="tab"
                                aria-selected="{{ $activeTab == 'pos-managers' ? 'true' : 'false' }}"
                                wire:click="setActiveTab('pos-managers')">
                                <i class="ri-user-line me-1"></i> @lang('Pos Managers')
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light {{ $activeTab == 'worktimes' ? 'active' : '' }}"
                                data-bs-toggle="tab" href="#pill-justified-worktimes-1" role="tab"
                                aria-selected="{{ $activeTab == 'worktimes' ? 'true' : 'false' }}"
                                wire:click="setActiveTab('worktimes')">
                                <i class="ri-time-line me-1"></i> @lang('Work Times')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light {{ $activeTab == 'tablet-manager' ? 'active' : '' }}"
                                data-bs-toggle="tab" href="#pill-justified-tablet-manager-1" role="tab"
                                aria-selected="{{ $activeTab == 'tablet-manager' ? 'true' : 'false' }}"
                                wire:click="setActiveTab('tablet-manager')">
                                <i class="ri-tablet-line me-1"></i> @lang('Tablet Manager')
                            </a>
                        </li>

                    </ul>

                </div>
                <div class="card-body">



                    <div class="tab-content text-muted">

                        <div class="tab-pane {{ $activeTab == 'general' ? 'show active' : '' }}"
                            id="pill-justified-home-1" role="tabpanel">
                            @include('livewire.dashboard.branch.inc.general')
                        </div>

                        <div class="tab-pane {{ $activeTab == 'orders' ? 'show active' : '' }}"
                            id="pill-justified-profile-1" role="tabpanel">
                            @include('livewire.dashboard.branch.inc.orders')
                        </div>

                        <div class="tab-pane {{ $activeTab == 'products' ? 'show active' : '' }}"
                            id="pill-justified-messages-1" role="tabpanel">
                            @include('livewire.dashboard.branch.inc.products')
                        </div>

                        <div class="tab-pane {{ $activeTab == 'customers' ? 'show active' : '' }}"
                            id="pill-justified-settings-1" role="tabpanel">
                            @include('livewire.dashboard.branch.inc.customers')
                        </div>

                        <div class="tab-pane {{ $activeTab == 'pos-managers' ? 'show active' : '' }}"
                            id="pill-justified-pos-managers-1" role="tabpanel">
                            @include('livewire.dashboard.branch.inc.pos-managers')
                        </div>

                        <div class="tab-pane {{ $activeTab == 'worktimes' ? 'show active' : '' }}"
                            id="pill-justified-worktimes-1" role="tabpanel">
                            @include('livewire.dashboard.branch.inc.worktimes')
                        </div>

                        <div class="tab-pane {{ $activeTab == 'tablet-manager' ? 'show active' : '' }}"
                            id="pill-justified-tablet-manager-1" role="tabpanel">
                            @include('livewire.dashboard.branch.inc.tablet-manager')
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            // Listen for tab changes and update Livewire
            document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
                tab.addEventListener('shown.bs.tab', function(e) {
                    const targetId = e.target.getAttribute('href');
                    let tabName = 'general';

                    switch (targetId) {
                        case '#pill-justified-home-1':
                            tabName = 'general';
                            break;
                        case '#pill-justified-profile-1':
                            tabName = 'orders';
                            break;
                        case '#pill-justified-messages-1':
                            tabName = 'products';
                            break;
                        case '#pill-justified-settings-1':
                            tabName = 'customers';
                            break;
                        case '#pill-justified-pos-managers-1':
                            tabName = 'pos-managers';
                            break;
                        case '#pill-justified-worktimes-1':
                            tabName = 'worktimes';
                            break;
                        case '#pill-justified-tablet-manager-1':
                            tabName = 'tablet-manager';
                            break;
                    }

                    @this.setActiveTab(tabName);
                });
            });
        });
    </script>
