<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFirma extends Model
{
    protected $table = 'users_firme';
    protected $guarded = [];

    public function path()
    {
        return "/agentii/{$this->id}";
    }

    public function useri()
    {
        return $this->hasMany('App\User', 'user_firma_id');
    }

    public function rezervari()
    {
        return $this->hasManyThrough('App\Rezervare', 'App\User', 'user_firma_id', 'user_id');
    }
}
