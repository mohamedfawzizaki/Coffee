<?php

namespace App\Models\Branch;

use App\Traits\ForceTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BranchManager extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, ForceTimeZone;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'password',
        'branch_id',
        'device_token',
    ];

    protected $hidden = [
        'password',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getImageAttribute($value)
    {
        return  ($value) ?  $value : asset('images/default-user.png');
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
}
