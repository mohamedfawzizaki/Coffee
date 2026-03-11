<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ForceTimeZone;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Admin extends Authenticatable  implements LaratrustUser
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory, Notifiable, HasRolesAndPermissions, ForceTimeZone;

       /**
        * The attributes that are mass assignable.
        *
        * @var list<string>
        */
       protected $fillable = [
           'name',
           'email',
           'image',
           'status',
           'password',
       ];

       /**
        * The attributes that should be hidden for serialization.
        *
        * @var list<string>
        */
       protected $hidden = [
           'password',
           'remember_token',
       ];

       /**
        * Get the attributes that should be cast.
        *
        * @return array<string, string>
        */
       protected function casts(): array
       {
           return [
               'email_verified_at' => 'datetime',
               'password'          => 'hashed',
           ];
       }

       public function getImageAttribute($value)
       {
           return  ($value) ?  $value : asset('images/default-user.png');
       }


       public function getActivitylogOptions(): LogOptions
       {
           return LogOptions::defaults()->logAll();
       }

}

