<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menciones extends Model
{
    protected $table = 'menciones_da';

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id', 'id', 'carreras');
    }
}
