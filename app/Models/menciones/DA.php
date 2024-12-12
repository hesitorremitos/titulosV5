<?php

namespace App\Models\menciones;

use Illuminate\Database\Eloquent\Model;

class DA extends Model
{
    protected $table = 'menciones_da';
    protected $fillable = ['nombre', 'carrera_id'];
}
