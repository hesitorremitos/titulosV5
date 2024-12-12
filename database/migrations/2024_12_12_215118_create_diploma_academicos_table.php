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
    Schema::create('menciones_da', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->char('carrera_id', 5);
      $table->foreign('carrera_id')->references('id')->on('carreras');
      $table->timestamps();
    });
    Schema::create('diploma_academicos', function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger('nro_documento');
      $table->unsignedInteger('fojas');
      $table->unsignedInteger('libro');
      $table->date('fecha_emision');
      $table->foreignId('mencion_da_id')->constrained('menciones_da', 'id');
      $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diploma_academicos');
        Schema::dropIfExists('menciones_da');
    }
};
