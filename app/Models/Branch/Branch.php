<?php

namespace App\Models\Branch;

use App\Models\Order\Order;
use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Branch extends Model implements TranslatableContract
{
    use Translatable, LogsActivity, ForceTimeZone;
    
    protected static function booted()
    {
        static::addGlobalScope('active', function ($builder) {
            $builder->where('status', 1);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public $translatedAttributes = ['title'];

    protected $fillable = ['address', 'lat', 'lng', 'phone', 'email', 'image', 'remote_id', 'reference', 'type', 'status'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function notAvailableProducts()
    {
        return $this->hasMany(BranchProduct::class)->where('status', false);
    }

    public function posManagers()
    {
        return $this->hasMany(BranchManager::class);
    }

    public function worktimes()
    {
        return $this->hasMany(Worktime::class);
    }

    public function tabletManager()
    {
        return $this->hasOne(TabletManger::class);
    }

    public function isOpen()
    {
        return branchOpen($this->id) == __('Open');
    }

}
