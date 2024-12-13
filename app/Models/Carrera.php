<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\menciones\DA;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrera extends Model
{
  // Definir clave primaria
  protected $primaryKey = 'id';
  protected $table = 'carreras';
  protected $fillable = ['nombre', 'facultad_id'];

  public function menciones(): HasMany
  {
    return $this->hasMany(DA::class, 'carrera_id', 'id');
  }

  public function facultad(): BelongsTo
  {
    return $this->belongsTo(Facultad::class, 'facultad_id', 'id');
  }
}
