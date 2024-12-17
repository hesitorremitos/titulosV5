<?php

namespace App\Models;

use App\Models\menciones\DA;
use Illuminate\Database\Eloquent\Model;

class DiplomaAcademico extends Model
{
    //

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'ci', 'ci');
    }

    public function mencion()
    {
        return $this->belongsTo(DA::class, 'mencion_da_id', 'id');
    }
}
