<?php

namespace App\Livewire\Dashboard\General;

use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    public $perPage = 15;

    #[Title('سجل النشاطات')]
    public function render()
    {
        $activities = Activity::latest()
            ->paginate($this->perPage);

        return view('livewire.dashboard.general.activity-log', compact('activities'));
    }

    public function loadMore()
    {
        $this->perPage += 15;
    }
}
