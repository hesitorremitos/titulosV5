<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\menciones\DA;
use App\Models\menciones\TPN;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carrera extends Model
{
  // Definir clave primaria
  protected $primaryKey = 'id';
  protected $keyType = 'char';
  public $incrementing = false;
  protected $table = 'carreras';
  protected $fillable = ['nombre', 'facultad_id'];

  public function menciones_da(): HasMany
  {
    return $this->hasMany(DA::class, 'carrera_id', 'id');
  }


  public function menciones(): HasMany
  {
    return $this->hasMany(Menciones::class);
  }

  public function menciones_tpn(): HasMany
  {
    return $this->hasMany(TPN::class, 'carrera_id', 'id');
  }

  public function facultad(): BelongsTo
  {
    return $this->belongsTo(Facultad::class, 'facultad_id', 'id');
  }
}
