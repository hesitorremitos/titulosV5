<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\DiplomaAcademico;
use App\Models\Facultad;
use App\Models\menciones\DA;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DiplomaAcademicoController extends Controller
{
    /**
   * Display a listing of the resource.
   */
  public function index() {
    return Inertia::render('Search', [
      'titulos'=> DiplomaAcademico::with('persona')->with('mencion')->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia::render('DiplomaAcademico', [
      'menciones' => DA::all(),
      'carreras' => Carrera::with('menciones')->get(),
    ]);
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
      'nro_documento' => 'required|numeric',
      'fojas' => 'required|numeric',
      'libro' => 'required|numeric',
      'fecha_emision' => 'required|date',
      'sexo' => 'required',
      'file' => 'required|file|mimes:pdf'
    ]);

    $facultad = Facultad::find([
      'nombre' => $valitated['facultad'],
    ]);

    $carrera  = $facultad->carreras()->firstOrCreate([
      'programa' => $valitated['programa'],
    ]);
    // buscar la persona
    $finded_person = Persona::firstOrCreate($valitated['ci']);
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
    // Alacenar el file en el storage con el siguiente formato: TituloProfesional/Carrera/CI.pdf
    $file = $valitated['file'];
    $file_name = $carrera->nombre . '/' . $persona->ci . '.pdf';
    $file->storeAs('DiplomaAcademico/'. $carrera->nombre, $persona->ci . '- '.  $persona->nombres .' '.$persona->paterno.' '.$persona->materno.'.pdf');
    return $persona;
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $diploma = DiplomaAcademico::find($id);
    // Comprobar si el archivo existe
    if(Storage::disk('local')->exists($diploma->file_dir)){
      // Retornar pagina pdf
      return response()->file(Storage::disk('local')->path($diploma->file_dir));
    } else {
      $diploma->verificado = false;
      $diploma->save();
      return response()->json(['error' => 'El archivo no existe'], 404);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(DiplomaAcademico $titulo)
  {
    return $titulo;
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, DiplomaAcademico $tituloProfesional)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(DiplomaAcademico $tituloProfesional)
  {
    //
  }
}
