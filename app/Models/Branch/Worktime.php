<?php

namespace App\Models\Branch;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;

class Worktime extends Model
{
    use ForceTimeZone;
    protected $fillable = ['branch_id', 'day', 'from', 'to', 'all_day', 'status'];

    protected $casts = [
        'all_day' => 'boolean',
        'status' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeAllDay($query)
    {
        return $query->where('all_day', true);
    }

    public function scopeSpecificTime($query)
    {
        return $query->where('all_day', false);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    public function getFormattedTimeAttribute()
    {
        if ($this->all_day) {
            return __('All Day');
        }

        return $this->from . ' - ' . $this->to;
    }
}
