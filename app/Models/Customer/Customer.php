<?php

namespace App\Models\Customer;

use App\Models\Branch\Branch;
use App\Models\CustomerCard\CustomerCard;
use App\Models\Order\Cart;
use App\Models\Order\Gift\GiftOrder;
use App\Models\Order\Order;
use App\Traits\ForceTimeZone;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable implements JWTSubject
{
    use LogsActivity, Notifiable, ForceTimeZone;

    protected $fillable = ['name', 'phone', 'email', 'password', 'image', 'status', 'otp', 'otp_expire', 'device_token', 'verified', 'lat', 'lng', 'address', 'wallet', 'online', 'points', 'birthday', 'card_id'];

    protected $hidden = ['password', 'otp', 'otp_expire', 'device_token', 'verified', 'wallet', 'points'];

    protected $casts = [
        'status'   => 'boolean',
        'verified' => 'boolean',
    ];



    public function getImageAttribute($value)
    {
        return  ($value) ?  $value : asset('images/default-user.png');
    }


    public function wallets()
    {
        return $this->hasMany(CustomerWallet::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->latest();
    }

    public function gifts()
    {
        return $this->hasMany(GiftOrder::class)->latest();
    }


    public function sentGifts()
    {
        return $this->hasMany(GiftOrder::class, 'customer_id', 'id')->latest();
    }

    public function receivedGifts()
    {
        return $this->hasMany(GiftOrder::class, 'send_to', 'id')->latest();
    }


    public function sentGiftCards()
    {
        return $this->hasMany(\App\Models\Gift\Gift::class, 'sender_id')->latest();
    }

    public function receivedGiftCards()
    {
        return $this->hasMany(\App\Models\Gift\Gift::class, 'receiver_id')->latest();
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll();
    }

    public function card()
    {
        return $this->belongsTo(CustomerCard::class);
    }

    public function pointsRecords()
    {
        return $this->hasMany(CustomerPoint::class)->latest();
    }


    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function faved_branches()
    {
        return $this->hasManyThrough(Branch::class, Favourite::class, 'customer_id', 'id', 'id', 'type_id');
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