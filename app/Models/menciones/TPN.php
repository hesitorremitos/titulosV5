<?php

namespace App\Models\menciones;

use Illuminate\Database\Eloquent\Model;

class TPN extends Model
{
  protected $table = 'menciones_tpn';
  protected $fillable = ['nombre', 'carrera_id'];
}
