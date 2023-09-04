<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Trip;
use App\Models\Driver;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'login_code',
        'remember_token',
    ];

    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

     public function driver(){
        return $this->hasOne(Driver::class);
     }

     public function trips(){
        return $this->hasMany(Trip::class);
     }
}