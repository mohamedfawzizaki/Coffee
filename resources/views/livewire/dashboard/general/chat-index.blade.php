@push('css')
<style>
    .user-chat {
        background: url({{ asset('images/chat-bg-pattern.png') }});
    }
</style>
@endpush

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Chats')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Chats')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if($chats->count() > 0)
        <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
            <div class="chat-leftsidebar">
                <div class="px-4 pt-4 mb-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h5 class="mb-4">@lang('Chats')</h5>
                        </div>
                    </div>
                    <div class="search-box">
                        <input type="text" class="form-control bg-light border-light" wire:model.live="search" placeholder="@lang('Search here...')">
                        <i class="ri-search-2-line search-icon"></i>
                    </div>
                </div>

                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="chats" role="tabpanel">
                        <div class="chat-room-list pt-3 simplebar-scrollable-y" data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: -16px 0px 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden scroll;">
                                            <div class="simplebar-content" style="padding: 16px 0px 0px;">
                                                <div class="d-flex align-items-center px-4 mb-2">
                                                    <div class="flex-grow-1">
                                                        <h4 class="mb-0 fs-11 text-muted text-uppercase">Direct Messages</h4>
                                                    </div>
                                                </div>

                                                <div class="chat-message-list">
                                                    <ul class="list-unstyled chat-list chat-user-list" id="userList">
                                                        @foreach ($chats as $key => $chat)
                                                        <li id="contact-id-1" data-name="direct-message" class="checkforactive" wire:key="{{ $key }}" wire:click="openChat({{ $chat->id }})">
                                                            <a href="javascript: void(0);">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 chat-user-img online align-self-center me-2 ms-0">
                                                                        <div class="avatar-xxs">
                                                                            <img src="{{ $chat->store?->logo }}" class="rounded-circle img-fluid userprofile" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1 overflow-hidden">
                                                                        <p class="text-truncate mb-0">{{ $chat->store?->title }}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="ms-2">
                                                                    <p class="mb-0 fw-semibold" style="font-size: 10px; float: inline-end; color:#78a18d">
                                                                        {{ $chat->lastMessage?->created_at->diffForHumans() }}
                                                                    </p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                                <!-- End chat-message-list -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 300px; height: 649px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar" style="height: 25px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="contacts" role="tabpanel">
                        <div class="chat-room-list pt-3" data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: -16px 0px 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper"  aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                            <div class="simplebar-content" style="padding: 16px 0px 0px;">
                                                <div class="sort-contact">
                                                    <div class="mt-3">
                                                        <div class="contact-list-title">A</div>
                                                        <ul id="contact-sort-A" class="list-unstyled contact-list">
                                                            <li>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-2">
                                                                        <div class="avatar-xxs">
                                                                            <span class="avatar-title rounded-circle bg-primary fs-10">AC</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <p class="text-truncate contactlist-name mb-0">Alice Cruickshank</p>
                                                                    </div>
                                                                    <div class="flex-shrink-0">
                                                                        <div class="dropdown">
                                                                            <a href="#" class="text-muted" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="ri-more-2-fill"></i>
                                                                            </a>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <a class="dropdown-item" href="#"><i class="ri-pencil-line text-muted me-2 align-bottom"></i>Edit</a>
                                                                                <a class="dropdown-item" href="#"><i class="ri-forbid-2-line text-muted me-2 align-bottom"></i>Block</a>
                                                                                <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-line text-muted me-2 align-bottom"></i>Remove</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- Additional contact sections (B, C, etc.) -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!is_null($selectedChat))
            <div class="user-chat w-100 overflow-hidden minimal-border user-chat-show">
                <div class="chat-content d-lg-flex">
                    <div class="w-100 overflow-hidden position-relative">
                        <div class="position-relative">
                            <div class="position-relative" id="users-chat" style="display: block;">
                                <div class="p-3 user-chat-topbar">
                                    <div class="row align-items-center">
                                        <div class="col-sm-4 col-8">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 d-block d-lg-none me-3">
                                                    <a href="javascript: void(0);" class="user-chat-remove fs-18 p-1"><i class="ri-arrow-left-s-line align-bottom"></i></a>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 chat-user-img online user-own-img align-self-center me-3 ms-0">
                                                            <img src="{{ $selectedChat->customer?->image ?? ' ' }}" class="rounded-circle avatar-xs" alt="">
                                                        </div>
                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate mb-0 fs-16">
                                                                <a class="text-reset username" data-bs-toggle="offcanvas" href="#userProfileCanvasExample" aria-controls="userProfileCanvasExample">
                                                                    {{ $selectedChat->customer?->name ?? '' }}
                                                                </a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="chat-conversation p-3 p-lg-4" id="chat-conversation" data-simplebar="init">
                                    <div class="simplebar-wrapper" style="margin: -24px;">
                                        <div class="simplebar-height-auto-observer-wrapper">
                                            <div class="simplebar-height-auto-observer"></div>
                                        </div>
                                        <div class="simplebar-mask">
                                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                                <div class="simplebar-content-wrapper" aria-label="scrollable content" style="height: 100%; overflow: hidden;">
                                                    <div class="simplebar-content" style="padding: 24px;">
                                                        <div id="elmLoader"></div>
                                                        <ul class="list-unstyled chat-conversation-list" id="users-conversation">
                                                            @if(!is_null($selectedChat))
                                                                @foreach($selectedChat->messages as $message)
                                                                    @if($selectedChat->sender == 'provider')
                                                                    <li class="chat-list left" id="{{ $message->id }}" wire:key="{{ $message->id }}">
                                                                        <div class="conversation-list">
                                                                            <div class="chat-avatar">
                                                                                <img src="{{ $selectedChat->store?->logo }}" alt="">
                                                                            </div>
                                                                            <div class="user-chat-content">
                                                                                <div class="ctext-wrap">
                                                                                    <div class="ctext-wrap-content" id="1">
                                                                                        <p class="mb-0 ctext-content">{{ $message->message }} {{ $message->id }}</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="conversation-name">
                                                                                    <span class="d-none name">{{ $selectedChat->store?->title }}</span>
                                                                                    <small class="text-muted time">{{ $message->created_at->format('h:iA') }}</small>
                                                                                    <span class="text-success check-message-icon"><i class="bx bx-check-double"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    @else
                                                                    <li class="chat-list right" id="{{ $message->id }}" wire:key="{{ $message->id }}">
                                                                        <div class="conversation-list">
                                                                            <div class="chat-avatar">
                                                                                <img src="{{ $selectedChat->customer?->image }}" alt="">
                                                                            </div>
                                                                            <div class="user-chat-content">
                                                                                <div class="ctext-wrap">
                                                                                    <div class="ctext-wrap-content" id="2">
                                                                                        <p class="mb-0 ctext-content">{{ $message->message }} {{ $message->id }}</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="conversation-name">
                                                                                    <span class="d-none name">{{ $selectedChat->customer?->name }}</span>
                                                                                    <small class="text-muted time">{{ $message->created_at->format('h:iA') }}</small>
                                                                                    <span class="text-success check-message-icon"><i class="bx bx-check-double"></i></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="simplebar-placeholder" style="width: 1401px; height: 622px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="user-chat w-100 overflow-hidden minimal-border user-chat-show">
                <div class="chat-content d-lg-flex">
                    <div class="w-100 overflow-hidden position-relative">
                        <div class="position-relative">
                            <h5 class="mb-4" style="text-align: center;margin-top: 250px;font-size: 50px;color: lightcoral;">@lang('Please select a chat')</h5>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @else
            @include('inc.nodata')
        @endif
    </div>
</div>

@push('scripts')
<script>
    Livewire.on('chatOpened', (chat) => {
        $('#chat-user-details').show();
        $('#chat-msg-scroll').scrollTop($('#chat-msg-scroll')[0].scrollHeight);
    });
</script>
@endpush
