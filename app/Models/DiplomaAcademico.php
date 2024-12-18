<?php

namespace App\Models;

use App\Models\menciones\DA;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DiplomaAcademico extends Model
{
  //
  protected $primaryKey = 'id';
  protected $fillable = [
    'ci',
    'nro_documento',
    'fojas',
    'libro',
    'fecha_emision',
    'observaciones',
    'graduacion_id',
    'mencion_da_id',
    'file_dir',
    'verificado'
  ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'ci', 'ci');
    }

    public function mencion()
    {
        return $this->belongsTo(DA::class, 'mencion_da_id', 'id');
    }


    public function getFechaEmisionAttribute($value)
    {
      # REalizar la conversion solamente si es numerico
      if(is_numeric($value)) {
        return Carbon::parse($value/1000)->format('d/m/Y');
      }
      return $value;
    }
}
