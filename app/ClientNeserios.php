<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientNeserios extends Model
{
    protected $table = 'clienti_neseriosi';
    protected $guarded = [];

    public function path()
    {
        return "/clienti-neseriosi/{$this->id}";
    }
}
