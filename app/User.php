<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'usename'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roluser()
    {
        return $this->hasOne('App\UserRole')->withDefault();
    }

    public function firma()
    {
        return $this->belongsTo('App\UserFirma', 'user_firma_id')->withDefault();
    }

    public function rezervari()
    {
        return $this->hasMany('App\Rezervare', 'user_id');
    }

    public function isDispecer()
    {
        if (auth()->user()->firma->id == 1) {
                return true;
        }
        return false;
    }
}
