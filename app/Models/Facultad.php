<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
  // Table facultades

  protected $table = 'facultades';
  protected $fillable = ['nombre', 'direccion'];

  public function carreras()
  {
    return $this->hasMany(Carrera::class);
  }
}
