<?php

namespace App\Http\Controllers;

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
    $file  = $request->file('file');
    $filePath = $file->store('uploads', 'public');
    return $filePath;
    $valitated = $request->validate([
      'nombres' => 'required|min:3',
      'mencion' => 'required|min:3',
      'programa' => 'required|min:3',
      'fojas' => 'required|numeric',
      'libro' => 'required|numeric',
      'nivel' => 'required|min:3',
    ]);
    return $valitated;
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
