<?php

namespace App\Models\menciones;

use App\Models\Carrera;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DA extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'menciones_da';
    protected $fillable = ['nombre', 'carrera_id'];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class, 'carrera_id', 'id');
    }
}
