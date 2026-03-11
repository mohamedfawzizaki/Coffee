<?php

namespace App\Models\Branch;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Tymon\JWTAuth\Contracts\JWTSubject;
class TabletManger extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, LogsActivity, ForceTimeZone;

    protected $fillable = [
        'branch_id',
        'name',
        'email',
        'phone',
        'image',
        'password',
        'status',
        'device_token',
    ];

    protected $hidden = [
        'password',
        'otp',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getImageAttribute($value)
    {
        return $value ? asset($value) : asset('images/default-user.png');
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function routeNotificationForFcm()
    {
        return $this->device_token;
    }
}
