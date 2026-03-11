
@php
    $defaultImage = asset('images/default.png');
    $imageUrl = $image ?? $defaultImage;
@endphp

<div id="lightgallery-{{ $id }}">
    <a href="" class="avatar avatar-xxl border bradius d-flex mx-auto border-white shadow-sm border-4 overflow-hidden p-0" style="height: 60px;width: 60px;" data-responsive="{{ $imageUrl }}" data-src="{{ $imageUrl }}" data-sub-html="<h4>{{ $caption }}</h4>">
        <img class="img-responsive br-5" src="{{ $imageUrl }}" alt="{{ $caption ?? 'Default Image' }}">
    </a>
</div>

@push('js')
    <script>
        lightGallery(document.getElementById("lightgallery-{{ $id }}"));
    </script>
@endpush
