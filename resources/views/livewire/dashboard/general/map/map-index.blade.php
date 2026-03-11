
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@lang('Heat Map')</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active">@lang('Heat Map')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

            <div class="row">

                <div class="card">
                    <div class="card-body" wire:ignore>
                        <div id="map-status" class="alert alert-warning d-none" style="margin-bottom: 12px;"></div>
                         <div id="map" style="height: 95vh; width: 100%;" data-heatmap='@json($heatmapPoints)'></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('js')
        <script>
            window.__ordersHeatmap = window.__ordersHeatmap || {};

            function setMapStatus(message, type = 'warning') {
                const el = document.getElementById('map-status');
                if (!el) return;
                el.classList.remove('d-none', 'alert-warning', 'alert-danger', 'alert-info', 'alert-success');
                el.classList.add(type === 'danger' ? 'alert-danger' :
                    type === 'info' ? 'alert-info' :
                    type === 'success' ? 'alert-success' : 'alert-warning');
                el.textContent = message;
            }

            function initOrdersHeatMap() {
                const mapEl = document.getElementById("map");
                if (!mapEl || typeof google === 'undefined' || !google.maps) {
                    setMapStatus('لم يتم تحميل Google Maps بعد. تأكد من إعداد GOOGLE_MAPS_API_KEY.', 'danger');
                    return;
                }
                if (!google.maps.visualization || !google.maps.visualization.HeatmapLayer) {
                    setMapStatus('مكتبة Heatmap (visualization) غير متاحة. تأكد من تحميل Google Maps مع libraries=visualization.', 'danger');
                    return;
                }

                // Clean up previous instances (when navigating with Livewire)
                if (window.__ordersHeatmap.heatmap) {
                    window.__ordersHeatmap.heatmap.setMap(null);
                }
                if (window.__ordersHeatmap.markers && Array.isArray(window.__ordersHeatmap.markers)) {
                    window.__ordersHeatmap.markers.forEach(m => m.setMap(null));
                }

                const map = new google.maps.Map(mapEl, {
                    zoom: 12,
                    center: { lat: 24.7136, lng: 46.6753 },
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: [
                        {
                            featureType: "all",
                            elementType: "labels",
                            stylers: [{ visibility: "on" }]
                        }
                    ]
                });

                let rawPoints = [];
                try {
                    rawPoints = JSON.parse(mapEl.dataset.heatmap || "[]");
                } catch (e) {
                    console.error('Heatmap JSON parse failed', e, mapEl.dataset.heatmap);
                    rawPoints = [];
                }

                console.log('Heatmap points:', rawPoints.length);
                if (!rawPoints.length) {
                    setMapStatus('لا توجد نقاط حرارة لعرضها (بعد الفلترة). تأكد أن الطلبات تحتوي lat/lng صحيحة.', 'warning');
                } else {
                    setMapStatus(`تم تحميل ${rawPoints.length} نقطة حرارة.`, 'info');
                }

                const heatmapData = rawPoints.map(p => ({
                    location: new google.maps.LatLng(Number(p.lat), Number(p.lng)),
                    weight: Number(p.weight ?? 1)
                }));

                if (heatmapData.length > 0) {
                    let heatmap;
                    try {
                        heatmap = new google.maps.visualization.HeatmapLayer({
                            data: heatmapData,
                            map: map,
                            radius: 30,
                            opacity: 0.7,
                            gradient: [
                                'rgba(0, 255, 255, 0)',
                                'rgba(0, 255, 255, 1)',
                                'rgba(0, 191, 255, 1)',
                                'rgba(0, 127, 255, 1)',
                                'rgba(0, 63, 255, 1)',
                                'rgba(0, 0, 255, 1)',
                                'rgba(0, 0, 223, 1)',
                                'rgba(0, 0, 191, 1)',
                                'rgba(0, 0, 159, 1)',
                                'rgba(0, 0, 127, 1)',
                                'rgba(63, 0, 91, 1)',
                                'rgba(127, 0, 63, 1)',
                                'rgba(191, 0, 31, 1)',
                                'rgba(255, 0, 0, 1)'
                            ]
                        });
                    } catch (e) {
                        console.error('HeatmapLayer init failed', e);
                        setMapStatus('فشل إنشاء HeatmapLayer. راجع Console لأخطاء Google Maps/Key.', 'danger');
                        return;
                    }

                    // Fit map bounds to include all data points
                    const bounds = new google.maps.LatLngBounds();
                    heatmapData.forEach(data => bounds.extend(data.location));
                    map.fitBounds(bounds);

                    window.__ordersHeatmap.map = map;
                    window.__ordersHeatmap.heatmap = heatmap;

                    // Debug: show first N markers to confirm coordinates
                    const markers = [];
                    heatmapData.slice(0, 25).forEach(d => {
                        markers.push(new google.maps.Marker({ position: d.location, map }));
                    });
                    window.__ordersHeatmap.markers = markers;
                } else {
                    console.warn('No heatmap points found. Check orders lat/lng values.');
                }
            }

            function loadGoogleMapsAndInit() {
                // Already loaded
                if (typeof google !== 'undefined' && google.maps && google.maps.visualization) {
                    initOrdersHeatMap();
                    return;
                }

                // Avoid injecting the script more than once
                const existing = document.getElementById('google-maps-js');
                if (existing) {
                    // If script exists but google not ready yet, wait for it.
                    existing.addEventListener('load', () => initOrdersHeatMap(), { once: true });
                    return;
                }

                window.initOrdersHeatMap = initOrdersHeatMap; // callback needs global reference

                const script = document.createElement('script');
                script.id = 'google-maps-js';
                script.async = true;
                script.defer = true;
                script.src =
                    "https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=visualization&callback=initOrdersHeatMap";
                script.addEventListener('error', () => {
                    setMapStatus('فشل تحميل Google Maps. غالبًا API Key غير صحيح أو ممنوع (Referrer/Billing).', 'danger');
                });
                document.head.appendChild(script);
            }

            // First load
            if (document.readyState === "loading") {
                document.addEventListener('DOMContentLoaded', loadGoogleMapsAndInit);
            } else {
                loadGoogleMapsAndInit();
            }

            // Re-init after Livewire navigation
            document.addEventListener('livewire:navigated', () => {
                loadGoogleMapsAndInit();
            });
        </script>
    @endpush
