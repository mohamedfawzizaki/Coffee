<div class="page-content">

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Branches')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Branches')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card custom-card">

                    <div class="card-header justify-content-between">
                        <div class="card-title"> @lang('Edit Branch') </div>
                    </div>

                    <div class="card-body">

                        <form wire:submit.prevent="updateBranch">

                            <div class="modal-body">

                                @foreach ($locales as $locale)
                                    <div class="mb-3">
                                        <label for="{{ $locale }}_title"
                                            class="form-label">@lang($locale . '.title')</label>
                                        <input wire:model="{{ $locale }}.title" type="text"
                                            id="{{ $locale }}_title" class="form-control translated-input"
                                            placeholder="@lang($locale . '.title')" required />
                                        @error($locale . '.title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach

                                <div class="mb-3">
                                    <label for="mapsearch" class="form-label">@lang('Address')</label>
                                    <input id="mapsearch" type="text" class="form-control" wire:model="address"
                                        placeholder="@lang('Search for a location')" />
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div id="map" style="width: 100%; height: 400px;" wire:ignore
                                        data-default-lat="{{ $lat }}" data-default-lng="{{ $lng }}"></div>
                                    <input type="hidden" wire:model="lat" id="lat" />
                                    <input type="hidden" wire:model="lng" id="lng" />
                                    <input type="hidden" wire:model="address" id="address" />
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"> @lang('Save') </button>
                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
    <script>
        let map, marker, searchBox;

        function initMap() {
            const mapEl = document.getElementById('map');
            if (!mapEl || map) return;

            const rawLat = mapEl.dataset.defaultLat;
            const rawLng = mapEl.dataset.defaultLng;
            // Default to Riyadh if no coordinates
            const defaultLat = rawLat ? Number(rawLat) : 24.7136;
            const defaultLng = rawLng ? Number(rawLng) : 46.6753;

            map = new google.maps.Map(mapEl, {
                center: { lat: defaultLat, lng: defaultLng },
                zoom: 15,
                mapTypeControl: false,
                streetViewControl: false,
                fullscreenControl: false,
                zoomControlOptions: {
                    position: google.maps.ControlPosition.TOP_RIGHT
                }
            });

            marker = new google.maps.Marker({
                position: { lat: defaultLat, lng: defaultLng },
                map: map,
                draggable: true,
                title: 'Drag me'
            });

            const searchInput = document.getElementById('mapsearch');
            searchBox = new google.maps.places.SearchBox(searchInput);

            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener('places_changed', function() {
                const places = searchBox.getPlaces();
                if (places.length === 0) return;
                const place = places[0];

                if (!place.geometry || !place.geometry.location) return;

                map.setCenter(place.geometry.location);
                marker.setPosition(place.geometry.location);
                updateFormValues(
                    place.geometry.location.lat(),
                    place.geometry.location.lng(),
                    place.formatted_address
                );
            });

            marker.addListener('dragend', function() {
                const position = marker.getPosition();
                reverseGeocode(position.lat(), position.lng());
            });

            map.addListener('click', function(event) {
                marker.setPosition(event.latLng);
                reverseGeocode(event.latLng.lat(), event.latLng.lng());
            });

            function reverseGeocode(lat, lng) {
                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ location: { lat, lng } }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        updateFormValues(lat, lng, results[0].formatted_address);
                    } else {
                        updateFormValues(lat, lng);
                    }
                });
            }

            function updateFormValues(lat, lng, address = null) {
                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;
                
                // Use Livewire.dispatch for edit component consistency
                Livewire.dispatch('latLngUpdated', { lat, lng });

                if (address) {
                    document.getElementById('address').value = address;
                    document.getElementById('mapsearch').value = address;
                    Livewire.dispatch('addressUpdated', { address });
                }
            }
        }

    function startInitMap() {
        map = null;
        marker = null;
        searchBox = null;
        setTimeout(initMap, 100);
    }

    document.addEventListener('livewire:navigated', startInitMap);
    document.addEventListener('DOMContentLoaded', startInitMap);
  </script>
    @endpush

</content>
