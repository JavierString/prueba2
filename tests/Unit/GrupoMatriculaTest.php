<?php

use App\Models\Curso;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Matricula;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

uses(Tests\TestCase::class);

it('crea un grupo con dos estudiantes matriculados', function () {
    $curso = new Curso(['codigo' => 'IF6201', 'nombre' => 'Programación']);
    $docente = new Docente(['nombre' => 'Alonso Chavarría']);

    $grupo = new Grupo(['numero' => 1, 'cupo' => 30]);
    $grupo->setRelation('curso', $curso);
    $grupo->setRelation('docente', $docente);

    $est1 = new Estudiante(['carne' => 'B00001', 'nombre' => 'Javier']);
    $est2 = new Estudiante(['carne' => 'B00002', 'nombre' => 'María']);

    $mat1 = new Matricula(['fecha' => '2026-10-14']);
    $mat1->setRelation('estudiante', $est1);
    $mat1->setRelation('grupo', $grupo);

    $mat2 = new Matricula(['fecha' => '2026-10-14']);
    $mat2->setRelation('estudiante', $est2);
    $mat2->setRelation('grupo', $grupo);

    $grupo->setRelation('matriculas', new Collection([$mat1, $mat2]));

    expect($grupo->matriculas)->toHaveCount(2)
        ->and($grupo->matriculas[0]->estudiante->nombre)->toBe('Javier')
        ->and($grupo->matriculas[1]->estudiante->nombre)->toBe('Joshua')
        ->and($grupo->curso->codigo)->toBe('IF6201')
        ->and($grupo->docente->nombre)->toBe('Alonso Chavarría');
});

it('declara las relaciones del diagrama', function () {
    expect((new Curso)->grupos())->toBeInstanceOf(HasMany::class)
        ->and((new Grupo)->curso())->toBeInstanceOf(BelongsTo::class)
        ->and((new Grupo)->docente())->toBeInstanceOf(BelongsTo::class)
        ->and((new Grupo)->matriculas())->toBeInstanceOf(HasMany::class)
        ->and((new Estudiante)->matriculas())->toBeInstanceOf(HasMany::class)
        ->and((new Matricula)->estudiante())->toBeInstanceOf(BelongsTo::class)
        ->and((new Matricula)->grupo())->toBeInstanceOf(BelongsTo::class)
        ->and(method_exists(Docente::class, 'grupos'))->toBeFalse();
});