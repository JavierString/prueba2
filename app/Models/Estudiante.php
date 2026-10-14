<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    protected $fillable = ['carne', 'nombre'];

    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }
}