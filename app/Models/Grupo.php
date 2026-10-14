<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grupo extends Model
{
    protected $fillable = ['numero', 'cupo', 'curso_id', 'docente_id'];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    // Navegable solo de Grupo hacia Docente
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function matriculas(): HasMany
    {
        return $this->hasMany(Matricula::class);
    }
}