<?php

namespace App\Http\Controllers;

use App\Models\Facultad;
use App\Models\Persona;
use App\Models\TituloProfesional;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TituloProfesionalController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index() {}

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia::render('TituloProfesional');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $valitated = $request->validate([
      'ci' => 'required',
      'nombres' => 'required|min:3',
      'apellido_paterno' => 'required|min:3',
      'apellido_materno' => 'required|min:3',
      'fecha_nacimiento' => 'required',
      'pais' => 'required|min:3',
      'departamento' => 'required|min:3',
      'provincia' => 'required|min:3',
      'localidad' => 'required|min:3',
      'mencion' => 'required|min:3',
      'programa' => 'required|min:3',
      'facultad' => 'required|min:3',
      'fojas' => 'required|numeric',
      'libro' => 'required|numeric',
      'nivel' => 'required|min:3',
      'sexo' => 'required',

    ]);

    $facultad = Facultad::firstOrCreate([
      'nombre' => $valitated['facultad'],
    ]);

    $carrera  = $facultad->carreras()->firstOrCreate([
      'nombre' => $valitated['programa'],
    ]);
    // buscar la persona
    $finded_person = Persona::find($valitated['ci']);
    if ($finded_person) {
      $persona = $finded_person;
    } else {
      $persona = new Persona;
      $persona->ci = $valitated['ci'];
      $persona->nombres = $valitated['nombres'];
      $persona->paterno = $valitated['apellido_paterno'];
      $persona->materno = $valitated['apellido_materno'];
      $persona->fecha_nacimiento = $valitated['fecha_nacimiento'];
      $persona->pais = $valitated['pais'];
      $persona->departamento = $valitated['departamento'];
      $persona->provincia = $valitated['provincia'];
      $persona->localidad = $valitated['localidad'];
      $persona->genero = $valitated['sexo'];
      $persona->save();
    }
    return $persona;
  }

  /**
   * Display the specified resource.
   */
  public function show(TituloProfesional $tituloProfesional)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(TituloProfesional $tituloProfesional)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, TituloProfesional $tituloProfesional)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(TituloProfesional $tituloProfesional)
  {
    //
  }
}
