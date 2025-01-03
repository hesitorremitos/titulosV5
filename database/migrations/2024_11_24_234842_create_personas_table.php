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
    Schema::create('personas', function (Blueprint $table) {
      $table->string('ci')->primary();
      $table->string('nombres');
      $table->string('paterno')->nullable();
      $table->string('materno')->nullable();
      $table->date('fecha_nacimiento')->nullable();
      $table->string('pais', 50)->nullable();
      $table->string('Departamento', 50)->nullable();
      $table->string('Provincia', 50)->nullable();
      $table->string('Localidad', 50)->nullable();
      $table->char('genero',1)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('personas');
  }
};
