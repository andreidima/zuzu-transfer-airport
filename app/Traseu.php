<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Traseu extends Model
{
    protected $table = 'trasee';
    protected $guarded = [];

    // protected $with = ['curse_ore:ora', 'rezervari:data_cursa,activa,nr_adulti,nr_copii'];


    public function path()
    {
        return "/trasee/{$this->id}";
    }

    // public function curse()
    // {
    //     return $this->hasMany('App\Cursa', 'traseu_id');
    // }

    // public function curse_ore()
    // {
    //     return $this->belongsToMany(CursaOra::class)->withTimestamps();
    // }

    public function curse_ore()
    {
        return $this->belongsToMany('App\CursaOra')
            ->using('App\CursaOraTraseu');
    }

    public function traseu_nume()
    {
        return $this->belongsTo('App\TraseuNume', 'traseu_nume_id');
    }

    public function rezervari()
    {
        return $this->hasManyThrough(
            'App\Rezervare',
            'App\CursaOraTraseu',
            'traseu_id', // Foreign key on users table...
            'ora_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'cursa_ora_id' // Local key on users table...
            // 'traseu_id', // Foreign key on users table...
            // 'cursa_ora_id', // Foreign key on posts table...
            // 'id', // Local key on countries table...
            // 'ora_id' // Local key on users table...
        );
    }

    public function rezervari_ziua($ziua)
    {
        $ziua_anterioara = \Carbon\Carbon::parse($ziua)->subDay()->format('Y-m-d');
        $ziua_maine = \Carbon\Carbon::parse($ziua)->subDay()->format('Y-m-d');
        return $this->rezervari()
                            // ->where(function ($query) use ($ziua_anterioara) {
                            //     $query->whereIn('ora_id', [293, 294, 307])
                            //         ->where('data_cursa', $ziua_anterioara)
                            //         ->where('activa', 1);
                            //     })
                            ->where(function ($query) use ($ziua_maine) {
                                $query->whereIn('ora_id', [40,53,66,79,183])
                                    ->where('data_cursa', $ziua_maine)
                                    ->where('activa', 1);
                                })
                            ->orWhere(function ($query) use ($ziua) {
                                $query->whereNotIn('ora_id', [40,53,66,79,183])
                                    ->where('data_cursa', $ziua)
                                    ->where('activa', 1);
                                });
    }
}
