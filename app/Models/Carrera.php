<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
  //
  protected $table = 'carreras';
  protected $fillable = ['nombre', 'facultad_id'];
}