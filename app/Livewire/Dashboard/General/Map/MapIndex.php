<?php

namespace App\Livewire\Dashboard\General\Map;

use App\Models\Order\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

class MapIndex extends Component
{
    /** @var array<int, array{lat: float, lng: float, weight: float}> */
    public array $heatmapPoints = [];

    public function mount()
    {
        $parseCoord = function ($value): ?float {
            if ($value === null) {
                return null;
            }
            if (is_float($value) || is_int($value)) {
                return (float) $value;
            }
            $s = trim((string) $value);
            if ($s === '') {
                return null;
            }
            // Handle locales that store decimals with comma
            $s = str_replace(',', '.', $s);
            if (!is_numeric($s)) {
                return null;
            }
            return (float) $s;
        };

        // Only fetch what we need for heatmap
        $this->heatmapPoints = Order::query()
            ->select(['lat', 'lng', 'grand_total'])
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->where('lat', '!=', '')
            ->where('lng', '!=', '')
            ->get()
            ->map(function (Order $order) use ($parseCoord) {
                $lat = $parseCoord($order->lat);
                $lng = $parseCoord($order->lng);

                // Weight: keep previous behavior (grand_total) but ensure numeric fallback
                $weight = is_numeric($order->grand_total) ? (float) $order->grand_total : 1.0;
                if ($weight <= 0) {
                    $weight = 1.0;
                }

                return [
                    'lat' => $lat,
                    'lng' => $lng,
                    'weight' => $weight,
                ];
            })
            ->filter(function (array $p) {
                // Guard against invalid coordinates
                return $p['lat'] !== null && $p['lng'] !== null
                    && $p['lat'] !== 0.0 && $p['lng'] !== 0.0
                    && $p['lat'] >= -90 && $p['lat'] <= 90
                    && $p['lng'] >= -180 && $p['lng'] <= 180;
            })
            ->values()
            ->all();
    }

    #[Title('Heat Map')]
    public function render()
    {
        return view('livewire.dashboard.general.map.map-index');
    }
}
