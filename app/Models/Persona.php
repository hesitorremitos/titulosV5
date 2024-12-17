<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
  // Define primary key
  protected $primaryKey = 'ci';

  public function diplomas_academicos()
  {
    return $this->hasMany(DiplomaAcademico::class, 'ci', 'ci');
  }
}
