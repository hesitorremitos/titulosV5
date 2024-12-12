<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('menciones_tpn', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->foreignId('carrera_id')->constrained('carreras', 'id');
      $table->timestamps();
    });
    Schema::create('titulo_profesionals', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('nro_documento');
      $table->unsignedInteger('fojas');
      $table->unsignedInteger('libro');
      $table->date('fecha_emision');
      $table->foreignId('mencion_tpn_id')->constrained('menciones_tpn', 'id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('titulo_profesionals');
    Schema::dropIfExists('menciones_tpn');
  }
};
